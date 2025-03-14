@extends('layouts.app')

@section('title', $user->name)

@section('content')
<div class="container mt-5">
    <div class="row mb-5 user">
        <div class="col-md-4 text-center">
            @if($user->avatar && $user->avatar !== 'users/default.png')
            <img src="{{ asset('storage/avatars/' . $user->avatar) }}" class="rounded-circle mb-3"
                alt="Avatar" width="150" height="150" style="object-fit: cover;">
            @else
            <img src="{{ asset('images/default_avatar.png') }}" class="rounded-circle mb-3"
                alt="Default Avatar" width="150" height="150" style="object-fit: cover;">
            @endif
        </div>

        <div class="col-md-8">
            <div class="user-info mb-3">
                <strong>
                    <h6 style="font-size: 28px;">{{ $user->name }}</h6>
                </strong>
            </div>
        </div>
    </div>
    <h4>Посты автора</h4>
    @if($news->isEmpty())
    <p>У этого автора нет новостей.</p>
    @else
    <div class="row">
        @foreach($news as $item)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-img-wrapper">
                    @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->title }}">
                    @else
                    <img src="{{ asset('images/photo_news.png') }}" class="card-img-top" alt="default image">
                    @endif
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $item->title }}</h5>
                    <p class="card-text">{{ Str::limit($item->content, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center" style="height:20px;">
                        <a href="{{ route('news.show', $item->id) }}" class="btn btn-primary mx-auto btn-read-more">Читать</a>
                        <div class="d-flex align-items-center ml-3">
                            @if (Auth::check())
                            <button type="button" class="btn btn-link like-button" data-news-id="{{ $item->id }}">
                                @if (Auth::user()->likedNews->contains($item->id))
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
                    </div>
                    <footer class="mt-3 text-muted card-footer">
                        Автор: <a href="{{ route('user.profile', $item->user->id) }}">{{ $item->user->name }}</a>
                        @if(Auth::check() && Auth::id() === $item->user->id)
                        <form action="{{ route('news.delete', $item->id) }}" method="POST" onsubmit="return confirm('Удалить новость?');" style="margin-top:5px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-del-new">Удалить</button>
                            <a href="{{ route('news.edit', $item->id) }}" class="btn btn-del-new">Редактировать</a>

                        </form>
                        @endif
                    </footer>

                </div>
            </div>
        </div>
        @endforeach
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