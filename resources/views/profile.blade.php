@extends('layout')

@section('content')
    <div class="container">
        <h2>Профиль пользователя {{Auth::user()->name}}</h2>
        @if (Session::has('success'))
            <h1>{{ Session::get('success') }}</h1>
        @endif
        @if (Session::has('failure'))
            <h1>{{ Session::get('failure') }}</h1>
        @endif
        <div class="container-form">
        <form method="post">
            @csrf
            <input type="hidden" name="task_id" value="{{old('task_id')}}">
            <div>
                <h4>Задача</h4>
                <input type="text" name="task" id="task" class="@error('task') invalid @enderror" value="{{old('task')}}">
                <span>{{$errors->first('task')}}</span>
            </div>
            <div>
                <h4>Описание</h4>
                <textarea name="description" id="description" rows="5" cols="20" class="@error('description') invalid @enderror">{{old('description')}}</textarea>
            </div>
            <div>
                <h4>Срок</h4>
                <input type="datetime-local" name="date" id="date" value="{{old('date')}}">
            </div>
            <div>
                <h4>Срочная</h4>
                <input type="checkbox" name="urgent" id="urgent" {{$isChecked=old('urgent')==1?"checked":""}}>
            </div>
            <br>
            <input type="submit" class="reg-form" name="formSubmit" value="{{$formAction=old('action')==1?"Изменить":"Добавить"}}">
            <input type="reset" class="reg-form" value="Сброс">
        </form>
        </div>
        <br>
        <?php 
        $tasks = App\Models\User::find(Auth::id())->tasks()->get();
        $execTasks = $tasks->sortBy('task_create')->whereNull('task_done');
        $compTasks = $tasks->whereNotNull('task_done');
        ?>
        <h2 class="urgent">Срочные задачи</h2>
        @if (count($execTasks->where('is_urgent', 1)) > 0)
        <form method="post" onsubmit="return toDelete();">
            @csrf
            <input type="hidden" name="deleteTasks" id="tasksList" value="">
            <button type="submit" name="formSubmit" id="deleteBtn" value="Удалить">Удалить выделенные задачи</button>
        </form>
        <table class="urgent-task">
            <tr>
                <td>
                
                </td>
                <td>
                Задача
                </td>
                <td>
                Описание
                </td>
                <td>
                Срок
                </td>
                <td>
                Действия
                </td>
            </tr>
        @foreach ($execTasks->where('is_urgent', 1) as $task)
            <tr>
                <td>
                <input type="checkbox" name="taskCheckbox" value="{{$task->id}}">
                </td>
                <td>
                {{$task->task}}
                </td>
                <td>
                {{$task->description}}
                </td>
                <td>
                {{date('d.m.y, G:i:s', $task->task_create)}}
                </td>
                <td>
                <form method="post" action="handleTasks">
                    @csrf
                    <button type="submit" name="formSubmit" id="done-{{$task->id}}" value="d-{{$task->id}}">Выполнено</button>
                    <button type="submit" name="formSubmit" id="edit-{{$task->id}}" value="e-{{$task->id}}">Редактировать</button>
                </form>
                </td>
            </tr>
        @endforeach
        </table>
        @else
        <h3>Задач не обнаружено</h3>
        @endif
        <br>
        <h2>Задачи в процессе</h2>
        @if (count($execTasks->where('is_urgent', 0)) > 0)
        <form method="post" onsubmit="return toDelete();">
            @csrf
            <input type="hidden" name="deleteTasks" id="tasksList" value="">
            <button type="submit" name="formSubmit" id="deleteBtn" value="Удалить">Удалить выделенные задачи</button>
        </form>
        <table>
            <tr>
                <td>
                
                </td>
                <td>
                Задача
                </td>
                <td>
                Описание
                </td>
                <td>
                Срок
                </td>
                <td>
                Действия
                </td>
            </tr>
        @foreach ($execTasks->where('is_urgent', 0) as $task)
            <tr>
                <td>
                <input type="checkbox" name="taskCheckbox" value="{{$task->id}}">
                </td>
                <td>
                {{$task->task}}
                </td>
                <td>
                {{$task->description}}
                </td>
                <td>
                {{date('d.m.y, G:i:s', $task->task_create)}}
                </td>
                <td>
                <form method="post" action="handleTasks">
                    @csrf
                    <button type="submit" name="formSubmit" id="done-{{$task->id}}" value="d-{{$task->id}}">Выполнено</button>
                    <button type="submit" name="formSubmit" id="edit-{{$task->id}}" value="e-{{$task->id}}">Редактировать</button>
                </form>
                </td>
            </tr>
        @endforeach
        </table>
        @else
        <h3>Задач не обнаружено</h3>
        @endif
        <br>
        <h2>Выполненные задачи</h2>
        @if (count($compTasks) > 0)
        <form method="post" onsubmit="return toDelete();">
            @csrf
            <input type="hidden" name="deleteTasks" id="tasksList" value="">
            <button type="submit" name="formSubmit" id="deleteBtn" value="Удалить">Удалить выделенные задачи</button>
        </form>
        <table>
            <tr>
                <td>
                
                </td>
                <td>
                Задача
                </td>
                <td>
                Описание
                </td>
                <td>
                Выполнено
                </td>
                <td>
                Действия
                </td>
            </tr>
        @foreach ($compTasks as $task)
            <tr>
                <td>
                <input type="checkbox" name="taskCheckbox" value="{{$task->id}}">
                </td>
                <td>
                {{$task->task}}
                </td>
                <td>
                {{$task->description}}
                </td>
                <td name="tz">
                {{$task->task_done}}
                </td>
                <td>
                <form method="post" action="handleTasks">
                    @csrf
                    <button type="submit" name="formSubmit" id="undone-{{$task->id}}" value="u-{{$task->id}}">Вернуть</button>
                    <button type="submit" name="formSubmit" id="edit-{{$task->id}}" value="e-{{$task->id}}">Редактировать</button>
                </form>
                </td>
            </tr>
        @endforeach
        </table>
        @else
        <h3>Задач не обнаружено</h3>
        @endif
    </div>
    <script text="javascript">
        function toDelete() {
            list = document.getElementById("tasksList");
            list.value = "";
            if(confirm('Удалить выделенные задачи?'))
            {
                checks = document.getElementsByName("taskCheckbox");
                checks.forEach((item)=>{if(item.checked){list.value+=`${item.value} `;}});
                console.log(list.value);
                return true;
            }
            else
            {
                return false;
            }
        }
    </script>
@stop