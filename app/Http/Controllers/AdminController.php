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
            'users' => User::all()
        ]);
    }
}
