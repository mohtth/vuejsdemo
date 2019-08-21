<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Auth\User as IlluminateUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationsController extends Controller
{
    public function index()
    {
        $users = User::select('name', 'id')->where('id', '!=', Auth::user()->id)->get();
        return view('conversations/index', compact('users'));
    }

    public function show(User $user)
    {
        $users = User::select('name', 'id')->where('id', '!=', Auth::user()->id)->get();
        return view('conversations/show', compact('users', 'user'));
    }
}
