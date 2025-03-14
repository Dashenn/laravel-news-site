@extends('layouts.app')

@section('title', 'Редактирование новости')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Редактировать пост</h2>
    <form method="POST" action="{{ route('news.update', $news->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input type="text" placeholder="Длина заголовка не должна превышать 70 символов" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $news->title) }}" id="title" name="title" maxlength="70" required>
            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Текст поста</label>
            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="6" required>{{ old('content', $news->content) }}</textarea>
            @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Изображение (необязательно)</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/png, image/jpeg">
            <small class="text-muted">Допустимые форматы: PNG, JPG,GIF.</small>

            @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary  btn-read-more" style="width: 20%;margin-right:20px">Сохранить изменения</button>
            <a href="{{ route('news.show', $news->id) }}" class="btn btn-danger">Отменить изменения</a>

        </div>
    </form>
</div>
@endsection