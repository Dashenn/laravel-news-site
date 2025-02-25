@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <h1 class="mb-4">Последние новости</h1>
    <div class="row">
        @foreach($news as $item)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <p class="card-text">{{ Str::limit($item->content, 100) }}</p>
                        <a href="{{ route('news.show', $item->id) }}" class="btn btn-primary">Читать</a>
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
            </div>
        @endforeach
    </div>
@endsection
