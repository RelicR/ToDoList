<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Exception;

class TestController extends Controller
{

    public function register(Request $request) : RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:8',
            're-password' => 'required|same:password',
        ], [
            'required' => 'Поле :attribute обязательно',
            'min' => 'Значение :attribute должно содержать больше 3-х символов',
            'email' => 'Поле :attribute должно иметь вид адреса Email (address@example.com)',
            'same' => 'Значение :attribute должно быть идентичным значению :other',
        ], [
            'name' => 'Имя',
            'email' => 'Email',
            'password' => 'Пароль',
            're-password' => 'Повторите пароль',
        ]);
        $data = $validator->validate();
        try
        {
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        }
        catch (Exception $e)
        {
            return redirect('register')->with('failure', 'Пользователь с данным Email уже существует');
        }
        return redirect('login')->with('success', 'Пользователь успешно зарегистрирован');
    }

    public function logout(Request $request) : RedirectResponse
    {
        Auth::logout();
        return redirect('login')->with('success', 'Вы вышли из аккаунта');
    }
    public function login(Request $request) : RedirectResponse
    {
        if ($request->get('log') == "Выйти")
        {
            Auth::logout();
            return redirect('login')->with('success', 'Вы вышли из аккаунта');
        }
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], [
            'required' => 'Поле :attribute обязательно',
            'email' => 'Поле :attribute должно иметь вид адреса Email (address@example.com)',
        ], [
            'email' => 'Email',
            'password' => 'Пароль',
        ]);
        $data = $validator->validate();
        $remember = (bool)$request->get('remember');
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $remember))
        {
            $request->session()->regenerate();
            return redirect('profile')->with('success', 'Вы вошли в аккаунт');
        }
        else
        {
            return redirect('login')->with('failure', 'Ошибка входа в аккаунт');
        }
    }

    public function newTask(Request $request) : RedirectResponse
    {
        $action = $request->get('formSubmit');
        $validator = Validator::make($request->all(), [
            'task' => 'required',
        ], [
            'required' => 'Поле :attribute обязательно',
        ], [
            'task' => 'Задача',
        ]);
        $task = $request->except('csrf');
        switch ($action)
        {
            case "Добавить":
                $validator->validate();
                $task['urgent'] = $request->has('urgent') ? 1 : 0;
                Task::create([
                    'task' => $task['task'],
                    'description' => $task['description'],
                    'is_urgent' => $task['urgent'],
                    'task_create' => Carbon::parse($request->get('date'))->timestamp,
                    'user_id' => Auth::user()->id,
                ]);
                return redirect('profile')->with('success', 'Задача добавлена');
            case "Удалить":
                $taskToDelete = explode(" ", $request->get('deleteTasks'));
                Task::whereIn('id', $taskToDelete)->delete();
                return redirect('profile')->with('success', 'Задачи удалены');
            case "Изменить":
                $validator->validate();
                $targetId = $request->input('task_id');
                $task['urgent'] = $request->has('urgent') ? 1 : 0;
                Task::find($targetId)->update([
                    'task' => $task['task'],
                    'description' => $task['description'],
                    'is_urgent' => $task['urgent'],
                    'task_create' => Carbon::parse($request->get('date'))->timestamp,
                ]);
                return redirect('profile')->with('success', 'Задача изменена');
            default:
                return redirect('profile');
        }
    }
    public function handleTasks(Request $request) : RedirectResponse
    {
        $action = substr($request->input('formSubmit'), 0, 1);
        $targetId = preg_split('/(u-)|(e-)|(d-)/', $request->input('formSubmit'))[1];
        $targetTask = Task::find($targetId);
        switch ($action)
        {
            case 'e':
                return redirect('profile')->withInput([
                    'task' => $targetTask->task,
                    'description' => $targetTask->description,
                    'urgent' => $targetTask->is_urgent,
                    'task_id' => $targetTask->id,
                    'action' => 1,
                    'date' => date('Y-m-d\TH:i',$targetTask->task_create),
                ])->with('success', 'Редактирование задачи');
            case 'd':
                $targetTask->update(['task_done' => Carbon::now()->timestamp]);
                return redirect('profile')->with('success', 'Задача отмечена как "Выполнено"');
            case 'u':
                $targetTask->update(['task_done' => null]);
                return redirect('profile')->with('success', 'Задача отмечена как "В процессе"');
            default:
                return redirect('profile');
        }
    }
}