@extends('layouts/app')

@section ('title', 'Login')

@section('content')
<div class=" login-container">
    <div class=" login-user">
        <div class="col-md-6 offset-md-3">
            <h2 style="margin: 30px;color:white" class="text-center">Вход в Hotwire</h2>

            <form method="POST" action="{{route('login.auth')}}" class="user-form">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email адрес</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Введите email адрес">

                    @error('email')
                    <div class="invalid-feedback">
                        <ul>
                            @foreach ($errors->get('email') as $message)
                            <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                        id="password"
                        name="password"
                        placeholder="Введите пароль">

                    @error('password')
                    <div class="invalid-feedback">
                        <ul>
                            @foreach ($errors->get('password') as $message)
                            <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember">
                    <label class="form-check-label" for="exampleCheck1">Запомнить меня</label>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-action">Войти</button>
                </div>
                <div class="d-flex justify-content-center">
                    <a href="{{route('register')}}" class="text-center" style="color: white; margin-top:15px">Нет аккаунта?</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection