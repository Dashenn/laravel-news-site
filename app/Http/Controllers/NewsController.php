<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('created_at', 'desc')->paginate(15);
        return view('home', ['news' => $news]);
    }

    public function show($id)
    {

        $news = News::find($id);

        if (!$news) {
            abort(404, 'Пост не найден');
        }

        return view('news.show', ['news' => $news]);
    }

    public function like($id)
    {
        $user = Auth::user();
        $news = News::findOrFail($id);
        /** @var \App\Models\User $user */

        if ($user->likedNews->contains($news->id)) {
            $user->likedNews()->detach($news->id);
            $liked = false;
        } else {
            $user->likedNews()->attach($news->id);
            $liked = true;
        }

        $likesCount = $news->likedUsers()->count();

        return response()->json([
            'liked' => $liked,
            'likes_count' => $likesCount
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:70',
            'content' => 'required|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => 'Введите заголовок.',
            'title.max' => 'Заголовок не должен превышать 70 символов.',
            'content.required' => 'Введите текст новости.',
            'image.mimes' => 'Допустимые форматы: JPG, PNG, GIF.',
            'image.max' => 'Максимальный размер файла: 2MB.',
        ]);

        $news = new News();
        $news->title = $validatedData['title'];
        $news->content = $validatedData['content'];
        $news->user_id = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news_images', 'public');
            $news->image = $path;
        }

        $news->save();

        return redirect()->route('news.show', $news->id)->with('success', 'Пост добавлен!');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);

        if (Auth::id() !== $news->user_id) {
            abort(403, 'Вы не можете редактировать этот пост.');
        }

        return view('news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);



        $request->validate(
            [
                'title'   => 'required|string|max:70',
                'content' => 'required|string',
                'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif',
            ],
            [
                'title.required' => 'Введите заголовок.',
                'title.max' => 'Заголовок не должен превышать 70 символов.',
                'content.required' => 'Введите текст новости.',
                'image.mimes' => 'Допустимые форматы: JPG, PNG, GIF.',
                'image.max' => 'Максимальный размер файла: 2MB.',
            ]
        );


        $news->title   = $request->title;
        $news->content = $request->content;


        if ($request->hasFile('image')) {

            if ($news->image) {
                Storage::delete('public/' . $news->image);
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/news-images', $imageName);
            $news->image = 'news-images/' . $imageName;
        }

        $news->save();

        return redirect()->route('news.show', $news->id)->with('success', 'Пост обновлен.');
    }
}
