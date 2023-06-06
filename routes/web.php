<?php

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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
    return view('tasks.index',[
        "tasks" => Task::all(),
        "tasks_complete" => Task::where('is_completed', 1)->get(),
        "tasks_incomplete" => Task::where('is_completed', 0)->get(),
    ]);
});

Route::get('/dashboard/mytasks/finished',[TaskController::class, 'finished']);
Route::get('/dashboard/mytasks/unfinished',[TaskController::class, 'unfinished']);
Route::post('/dashboard/mytasks/{id}',[TaskController::class, 'checklist']);
Route::resource('/dashboard/mytasks', TaskController::class);

// Route::delete('/dashboard/mytasks/{task}', function(Task $task){
//     Task::destroy($task->id);
//     return redirect('/dashboard/mytasks');
// });


