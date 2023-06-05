<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tasks.todos.index',[
            'tasks' => Task::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.todos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function finished(){
        $tasks = Task::where('is_completed', 1)->get();
        return view('tasks.todos.finished',[
            'tasks' => $tasks
        ]);
    }

    public function unfinished(){
        $tasks = Task::where('is_completed', 0)->get();
        return view('tasks.todos.unfinished',[
            'tasks' => $tasks
        ]);
    }

    public function checklist(Request $request){
        $id = $request->id;
        $task = Task::where('id', '=', ($id))->first();
    // dd($task);
        if ($task) {
            $task->is_completed = 1;
            $task->save();
            return redirect('/dashboard/mytasks');
        }
    }
}
