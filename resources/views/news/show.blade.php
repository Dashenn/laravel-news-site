@extends('layouts.app')

@section('title', $news->title)

@section('content')
<div class="container-fluid mt-7 px-0" style="background-color: #f8f9fa;">
    <div class="row new-show-content mx-0">
        <div class="col-md-7 new-info px-3">
            <h1 class="title-news">{{ $news->title }}</h1>
            <p class="text-muted">
                Автор: <a href="{{ route('user.profile', $news->user->id) }}">{{ $news->user->name }}</a>
                @if($news->created_at)
                {{ $news->created_at->format('d.m.Y') }}
                @endif
            </p>

            @if (Auth::check())
            <button type="button" class="btn btn-link like-button" data-news-id="{{ $news->id }}">
                @if (Auth::user()->likedNews->contains($news->id))
                <img src="{{ asset('images/like-on.png') }}" class="card-like" alt="like-on">
                @else
                <img src="{{ asset('images/like-off.png') }}" class="card-like" alt="like-off">
                @endif
            </button>
            @else
            <a href="{{ route('login') }}" class="btn btn-link">
                <img src="{{ asset('images/like-off.png') }}" class="card-like" alt="like-on">
            </a>
            @endif


        </div>
        <div class="col-md-5 d-flex justify-content-end align-items-center px-0">
            @if($news->image)
            <img src="{{ asset('storage/' . $news->image) }}" class="img-fluid" alt="{{ $news->title }}" style="width: 100%; max-height: 400px; object-fit: cover; object-position: center;">
            @else
            <img src="{{ asset('images/photo_news.png') }}" class="img-fluid" alt="default image" style="width: 100%; max-height: 400px; object-fit: cover; object-position: center;">
            @endif
        </div>


    </div>
</div>
<div class="container mt-3 news-div-content" style="max-width: 900px;">
    <div class="row">
        <div class="col">
            @foreach(explode("\n", trim($news->content)) as $paragraph)
            <p class="news-content">{{ $paragraph }}</p>
            @endforeach
        </div>
    </div>
    @if(Auth::check() && Auth::id() === $news->user->id)
    <div class="row mt-3">
        <div class="col d-flex gap-2">
            <form action="{{ route('news.delete', $news->id) }}" method="POST" onsubmit="return confirm('Удалить новость?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Удалить</button>
            </form>
            <a href="{{ route('news.edit', $news->id) }}" class="btn btn-secondary">Редактировать</a>
        </div>
    </div>
    @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const likeOn = "{{ asset('images/like-on.png') }}";
        const likeOff = "{{ asset('images/like-off.png') }}";

        const likeButtons = document.querySelectorAll('.like-button');

        likeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const newsId = this.getAttribute('data-news-id');
                const btn = this;

                fetch(`/news/${newsId}/like`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.liked) {
                            btn.innerHTML = `<img src="${likeOn}" class="card-like" alt="like-on">`;
                        } else {
                            btn.innerHTML = `<img src="${likeOff}" class="card-like" alt="like-off">`;
                        }
                    })
                    .catch(error => console.error('Ошибка:', error));
            });
        });
    });
</script>
@endsection