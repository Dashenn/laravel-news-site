@extends('layouts.app')

@section('title', 'Понравившиеся новости')

@section('content')
    <div class="container">
        <h2>Понравившиеся новости</h2>
        @if($news->isEmpty())
            <p>Нет понравившихся новостей.</p>
        @else
            <ul class="list-group">
                @foreach($news as $item)
                    <li class="list-group-item">
                        <a href="{{ route('news.show', $item->id) }}">{{ $item->title }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
