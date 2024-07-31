@extends('layout')

@section('content')
    <div class="container-form">
        <h2>Вход</h2>
        @if (Session::has('success'))
            <h1>{{ Session::get('success') }}</h1>
        @endif
        @if (Session::has('failure'))
            <h1>{{ Session::get('failure') }}</h1>
        @endif
        <form method="post">
            @csrf
            <div class="form-input">
                <h4>Email</h4>
                <input type="email" name="email" id="email" class="@error('email') invalid @enderror" value="{{old('email')}}">
                <span>{{$errors->first('email')}}</span>
            </div>
            <div class="form-input">
                <h4>Пароль</h4>
                <input type="password" name="password" id="password" class="@error('password') invalid @enderror">
                <span>{{$errors->first('password')}}</span>
            </div>
            <div class="form-input">
                <span class="remember-me">Запомнить меня</span>
                <input type="checkbox" name="remember" id="remember">
            </div>
            <br>
            <div class="form-input">
            <input type="submit" class="reg-form" name="log" id="login" value="Войти">
            <br>
            <a href="/register">Регистрация</a>
            </div>
        </form>
    </div>
@stop