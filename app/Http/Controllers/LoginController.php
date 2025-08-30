<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => '',
        ]);
        if (Auth::attempt($request->only('email', 'password'))){
            $request->session()->regenerate();
            $user = Auth::user();
            $user->session_id = Session::getId();
            $user->save();

            return redirect()->route('home');
        }
        return back()->withErrors([
            'email' => 'Wrong credentials, please try again.',
        ])->withInput($request->only('email'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Auth::logout();
        return redirect('/login');
    }
}
