@extends('layout')

@section('content')
    <div class="container-form">
        <h2>Регистрация</h2>
        @if (Session::has('success'))
            <h1>{{ Session::get('success') }}</h1>
        @endif
        @if (Session::has('failure'))
            <h1>{{ Session::get('failure') }}</h1>
        @endif
        <form method="post">
            @csrf
            <div class="form-input">
                <h4>Имя</h4>
                <input type="text" name="name" id="name" class="@error('name') invalid @enderror" value="{{old('name')}}">
                <br><span>{{$errors->first('name')}}</span>
            </div>
            <div class="form-input">
                <h4>Email</h4>
                <input type="email" name="email" id="email" class="@error('email') invalid @enderror" value="{{old('email')}}">
                <br><span>{{$errors->first('email')}}</span>
            </div>
            <div class="form-input">
                <h4>Пароль</h4>
                <input type="password" name="password" id="password" class="@error('password') invalid @enderror">
                <br><span>{{$errors->first('password')}}</span>
            </div>
            <div class="form-input">
                <h4>Повторите пароль</h4>
                <input type="password" name="re-password" id="re-password" class="@error('re-password') invalid @enderror">
                <br><span>{{$errors->first('re-password')}}</span>
            </div>
            <br>
            <input type="submit" class="reg-form" value="Зарегистрироваться">
        </form>
    </div>
@stop