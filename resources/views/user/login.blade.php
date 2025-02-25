@extends('layouts/app')

@section ('title', 'Login')

@section('content')

<div class="row">
    <div class="col-md-6 offset-md-3">
        <h2 style="margin-bottom: 30px;" class="text-center">Вход</h2>

        <form method="POST" action="{{route('login.auth')}}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email адрес</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email address" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember">
                <label class="form-check-label" for="exampleCheck1">Запомнить меня</label>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Войти</button>
            </div>
    
        </form>
    </div>
</div>

@endsection