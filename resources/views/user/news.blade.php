@extends('layouts/app')

@section ('title', 'My news')

@section('content')
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
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection