@extends('layouts/app')

@section('title', 'Account')

@section('content')
<div class="container mt-5">
    <div class="row mb-5">
        <div class="col-md-4 text-center">
            <img src="{{ asset('storage/avatars/' . $user->avatar) }}" class="rounded-circle" alt="Avatar" width="150" height="150">
        </div>
        <div class="col-md-8">
            <h2>{{ $user->name }}</h2>
            <p>Email: {{ $user->email }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4>Мои новости</h4>
            <div class="list-group">
                @foreach ($news as $newsItem) 
                <a href="{{ route('news.show', $newsItem->id) }}" class="list-group-item list-group-item-action">
                    <h5 class="mb-1">{{ $newsItem->title }}</h5>
                    <p class="mb-1">{{ \Str::limit($newsItem->content, 100) }}</p>
                </a>
                @endforeach
            </div>
            <div class="mt-3 text-center">
                <a href="{{ route('user.news') }}" class="btn btn-link">Посмотреть все мои новости</a>
            </div>
        </div>

        <!-- Понравившиеся новости -->
<div class="liked-news-panel mt-4">
    <h4>Понравившиеся новости</h4>
    @if($likedNews->isEmpty())
        <p>Нет понравившихся новостей.</p>
    @else
        <ul class="list-group">
            @foreach ($likedNews as $item)
                <li class="list-group-item">
                    <a href="{{ route('news.show', $item->id) }}">{{ $item->title }}</a>
                </li>
            @endforeach
        </ul>
        <div class="mt-2">
            <a href="{{ route('user.likedNews') }}" class="btn btn-link">Посмотреть все</a>
        </div>
    @endif
</div>

    </div>

    
</div>
@endsection
