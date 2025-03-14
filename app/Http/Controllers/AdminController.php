<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\News;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'users' => User::all(),
            'news' => News::with('user')->get()
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->role_id === 2) {
            return redirect()->route('admin.dashboard')->with('error', 'Нельзя удалить администратора.');
        }

        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Пользователь удален.');
    }

    public function deleteNews($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Пост удален.');
    }
}
