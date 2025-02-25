@extends('layouts/app')

@section ('title', 'Registration')

@section('content')

<div class="row">
    <div class="col-md-6 offset-md-3">
        <h2 style="margin-bottom: 30px;" class="text-center">Регистрация</h2>

        <form method="POST" action="{{route('user.store')}}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input class="form-control @error('name') is-invalid @enderror " value="{{old('name')}}" id="name" aria-describedby="emailHelp" placeholder="Input your name" name="name">
                @error('name')
                <div class="invalid-feedback">
                    <ul>
                        @foreach ($errors->get('name') as $message)
                        <li>{{ $message }}</li>
                    </ul>
                    @endforeach
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email адрес</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" id="email" aria-describedby="emailHelp" placeholder="Input your email address" name="email">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                @error('email')
                <div class="invalid-feedback">
                    <ul>
                        @foreach ($errors->get('email') as $message)
                        <li>{{ $message }}</li>
                    </ul>
                    @endforeach
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                @error('password')
                <div class="invalid-feedback">
                    <ul>
                        @foreach ($errors->get('password') as $message)
                        <li>{{ $message }}</li>
                    </ul>
                    @endforeach
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="pass_confirm" class="form-label">Повторите пароль</label>
                <input type="password" class="form-control" id="pass_confirm" name="password_confirmation">
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Регистрация</button>
            </div>
            <div class="d-flex justify-content-center">
                <a href="{{route('login')}}" class="text-center">Уже зарегистрированы?</a>
            </div>
        </form>
    </div>
</div>

@endsection