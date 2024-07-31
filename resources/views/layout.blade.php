<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('/css/style.css') }}" rel="stylesheet"> 
        <title>ToDoList fwt-test</title>
    </head>
    <body onload="makeDates();">
        <header>
            <div class="navbar">
                @if (!Auth::check())
                <a class="nav-item" href="/">Главная</a>
                <a class="nav-item" href="/register">Регистрация</a>
                <a class="nav-item" href="/login">Вход</a>
                @else
                <a class="nav-item" href="/">Главная</a>
                <a class="nav-item" href="/profile">Профиль</a>
                <a class="nav-item" href="/logout">Выход</a>
                @endif
            </div>
        </header>
        @yield('content')
    </body>
    <script src="{{asset('/js/mkd.js')}}"></script>
</html>