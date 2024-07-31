@extends('layout')

@section('content')
  <div class="container-form" style="margin:25dvh;">
  ToDoList предоставляет лёгкий доступ к управлению Вашими заметками прямо из браузера.
  <div class="container-reg">
  <a class="big-refer" href="/register">Зарегистрироваться</a>
  </div>
  @if (Session::has('success'))
    {{Session::get('success')}}
  @elseif(Session::has('failure'))
    {{Session::get('failure')}}
  @endif
  </div>
@stop