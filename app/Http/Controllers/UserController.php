<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'max:20', 'unique:users'],
            'email'    => ['required', 'max:100', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:6', 'max:16'],
        ]);

        $user = User::create($request->all());
        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('account')->with('success', 'Вы успешно зарегистрированы');
    }

    public function loginAuth(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('account')->with('success', 'Добро пожаловать ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Предоставленные учетные данные не соответствуют нашим записям.',
        ]);
    }

    public function login()
    {
        return view('user.login');
    }

    public function account()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $news = $user->news()->latest()->limit(3)->get();

        $likedNews = $user->likedNews()->latest()->limit(3)->get();

        return view('user.account', [
            'user' => $user,
            'news' => $news,
            'likedNews' => $likedNews,
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function news()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $news = $user->news()->latest()->get();

        return view('user.news', ['news' => $news]);
    }

    public function likedNews()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $news = $user->likedNews()->latest()->get();

        return view('user.liked-news', ['news' => $news]);
    }


    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:png,jpg|max:2048',
        ], [
            'image.mimes' => 'Допустимые форматы: JPG, PNG, GIF.',
            'image.max' => 'Максимальный размер файла: 2MB.',
        ]);
        /** @var \App\Models\User $user */
        $user = Auth::user();


        if ($user->avatar) {
            Storage::delete('public/avatars/' . $user->avatar);
        }


        $avatarName = time() . '.' . $request->avatar->extension();
        $request->avatar->storeAs('public/avatars', $avatarName);


        $user->avatar = $avatarName;
        $user->save();

        return redirect()->back()->with('success', 'Аватар успешно обновлен.');
    }

    public function deleteNews($id)
    {
        $user = Auth::user();
        /** @var \App\Models\User $user */
        $news = $user->news()->find($id);

        if (!$news) {
            return redirect()->back()->with('error', 'Пост не найден или у вас нет прав для удаления.');
        }

        $news->delete();

        return redirect()->route('home',)->with('success', 'Пост удален!');
    }

    public function profile($id)
    {
        $user = User::findOrFail($id);
        $news = $user->news()->latest()->get();

        return view('user.profile', compact('user', 'news'));
    }
}
