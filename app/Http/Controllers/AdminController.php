<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(){
        return view('tasks.admin.index',[
            'title' => 'Admin',
            'users' => User::where('id','!=', auth()->user()->id)->latest()->get()
        ]);
    }

    public function destroy(User $user)
    {
        // dd(request()->id);
        $user->delete();
        return redirect('/manage-users')->with('message', 'User Deleted');
    }
}
