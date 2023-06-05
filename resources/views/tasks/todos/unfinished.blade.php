@extends('tasks.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">My Unfinished Tasks</h1>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $task->title }}</td>
                <td>
                    Unfinished
                </td>
                <td>
                    <form action="/dashboard/mytasks/{{ $task->id }}" method="post" class="d-inline">
                        @csrf
                        <button class="badge bg-success border-0" onclick= "return confirm ('Finish this task?')"><span data-feather="check"
                            class="align-text-bottom"></span>
                        </button>
                    </form>
                    <a href="/dashboard/posts/{{ $task->id }}" class="badge bg-primary"> <span data-feather="eye" class="align-text-bottom"></span></a>
                    <a href="/dashboard/posts/{{ $task->id }}/edit" class="badge bg-warning"> <span data-feather="edit" class="align-text-bottom"></span></a>
                    <form action="/dashboard/posts/{{ $task->id }}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button class="badge bg-danger border-0" onclick="return confirm('Are you sure you want to delet this task?')"><span data-feather="trash" class="align-text-bottom"></span></button>
                    </form>
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection