@extends('layouts.app')

@section('title', $news->title)

@section('content')
    <div class="card">
        @if($news->image)
            <img src="{{ asset('storage/' . $news->image) }}" class="card-img-top" alt="{{ $news->title }}">
        @endif
        <div class="card-body">
            <h1>{{ $news->title }}</h1>
            <p class="text-muted">Автор: {{ $news->user->name }}, 
            @if($news->created_at)
                                {{ $news->created_at->format('d.m.Y') }}
                            @else
                                Не указана
                            @endif
            <p>{{ $news->content }}</p>
            @if (Auth::check())
    <form action="{{ route('news.like', $news->id) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-link">
            @if (Auth::user()->likedNews->contains($news->id))
                <i class="fas fa-thumbs-down"></i> Не нравится
            @else
                <i class="fas fa-thumbs-up"></i> Нравится
            @endif
        </button>
    </form>
@else
    <a href="{{ route('login') }}" class="btn btn-link">Нравится</a>
@endif

        </div>
    </div>
@endsection
