<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tasks.todos.index', [
            'tasks' => Task::latest()->where('user_id', auth()->user()->id)->get()
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
        // dd($request);
        $formFields = $request->validate([
            'title' => 'required | max: 200',
            'description' => ['required', 'max:1000']
        ]);

        $formFields['user_id'] = auth()->user()->id;
        Task::create($formFields);

        return redirect('/dashboard/mytasks')->with('message', 'New Task Added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $mytask)
    {
        return view('tasks.todos.show', [
            'task' => $mytask
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $mytask)
    {
        return view('tasks.todos.edit', [
            'task' => $mytask,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $mytask)
    {
        $formFields = $request->validate([
            'title' => 'required|max:200',
            'description' => ['required', 'max:1000']
        ]);

        $mytask->update($formFields);
        return redirect('/dashboard/mytasks')->with('message', 'Task Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param  \App\Models\Task  
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $mytask)
    {
        // dd(request()->id);
        $mytask->delete();
        return redirect('/dashboard/mytasks')->with('message', 'Task Deleted');
    }

    public function status()
    {
        $task = Task::latest()->where('user_id', auth()->user()->id);
        return view('tasks.index', [
            "tasks" => $task,
            "tasks_complete" => auth()->user()->tasks()->where('is_completed', 1)->get(),
            "tasks_incomplete" => auth()->user()->tasks()->where('is_completed', 0)->get(),
        ]);
    }

    public function finished()
    {
        $task = auth()->user()->tasks()->where('is_completed', 1)->get();
        // $tasks = Task::where('is_completed', 1)->get();
        return view('tasks.todos.finished', [
            'tasks' => $task
        ]);
    }

    public function unfinished()
    {
        $task = auth()->user()->tasks()->where('is_completed', 0)->get();
        // dd($task);
        // $tasks = Task::where('is_completed', 0)->get();
        return view('tasks.todos.unfinished', [
            'tasks' => $task
        ]);
    }

    public function checklist(Request $request)
    {
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
