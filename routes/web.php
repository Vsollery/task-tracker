<?php

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home',[
        "title" => "Home"
    ]);
});

Route::get('dashboard', function(){
    $task = Task::latest()->where('user_id', auth()->user()->id);
    return view('tasks.index',[
        "tasks" => $task,
        "tasks_complete" => auth()->user()->tasks()->where('is_completed', 1)->get(),
        "tasks_incomplete" => auth()->user()->tasks()->where('is_completed', 0)->get(),
    ]);
})->middleware('auth');

Route::get('/dashboard/mytasks/finished',[TaskController::class, 'finished']);
Route::get('/dashboard/mytasks/unfinished',[TaskController::class, 'unfinished']);
Route::post('/dashboard/mytasks/{id}',[TaskController::class, 'checklist']);
Route::resource('/dashboard/mytasks', TaskController::class)->middleware('auth');

Route::get('/register',[UserController::class, 'create']);
Route::post('/register',[UserController::class, 'store']);
Route::get('/login',[UserController::class, 'login'])->name('login');
Route::post('/login',[UserController::class, 'authenticate']);
Route::post('/logout',[UserController::class, 'logout']);

// Route::delete('/dashboard/mytasks/{task}', function(Task $task){
//     Task::destroy($task->id);
//     return redirect('/dashboard/mytasks');
// });


