<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
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
            'name'     => ['required', 'max:255'],
            'email'    => ['required', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ]);

        $user = User::create($request->all());
        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('account');
    }

    public function loginAuth(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('account')->with('success', 'Welcome ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
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

    return view('user.liked_news', ['news' => $news]);
}
}

