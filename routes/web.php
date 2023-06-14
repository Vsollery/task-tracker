<?php

use App\Http\Controllers\AdminController;
use App\Models\Task;
use App\Models\User;
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

Route::get('/discover', function () {
    return view('discover',[
        "title" => "Discover",
        "users" => User::latest()->paginate(3)->withQueryString()
    ]);
});

Route::get('/discover/{user}', function (User $user) {
    // dd($user);
    return view('show',[
        "title" => "Discover",
        "user" => $user,
        "tasks" => Task::where('user_id', $user->id)->get()
    ]);
});

Route::get('/dashboard', [TaskController:: class, 'status'])->middleware('auth');

Route::get('/dashboard/mytasks/finished',[TaskController::class, 'finished']);
Route::get('/dashboard/mytasks/unfinished',[TaskController::class, 'unfinished']);
Route::post('/dashboard/mytasks/{id}',[TaskController::class, 'checklist']);
Route::resource('/dashboard/mytasks', TaskController::class)->middleware('auth');

Route::get('/register',[UserController::class, 'create']);
Route::post('/register',[UserController::class, 'store']);
Route::get('/login',[UserController::class, 'login'])->name('login');
Route::post('/login',[UserController::class, 'authenticate']);
Route::post('/logout',[UserController::class, 'logout']);

Route::get('/manage-users', [AdminController::class,'index'])->middleware('admin');
Route::delete('/manage-users/{user}', [AdminController::class,'destroy'])->middleware('admin');
Route::post('/manage-users/{id}', [AdminController::class,'changeStats'])->middleware('admin');

// Route::delete('/dashboard/mytasks/{task}', function(Task $task){
//     Task::destroy($task->id);
//     return redirect('/dashboard/mytasks');
// });


