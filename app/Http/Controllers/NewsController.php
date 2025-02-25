<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('user')->paginate(15); 
        return view('home', ['news' => $news]);
    }
    

    public function show($id)
{

    $news = News::find($id);
    
    if (!$news) {
        abort(404, 'Новость не найдена');
    }

    return view('news.show', ['news' => $news]);
}

public function create()
{
    return view('article.create');
}


public function like($id)
{
    
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $news = News::findOrFail($id);
    $user = Auth::user();

    // Если новость уже лайкнута — убираем лайк, иначе — добавляем лайк
    if ($user->likedNews()->where('news_id', $news->id)->exists()) {
        $user->likedNews()->detach($news->id);
    } else {
        $user->likedNews()->attach($news->id);
    }

    return redirect()->back();
}
}
