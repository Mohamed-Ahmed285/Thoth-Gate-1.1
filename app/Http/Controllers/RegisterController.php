<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:255',
            'dateOfBirth' => 'required|date',
            'password' => 'required|string|min:8|confirmed',
            'grade' => 'required|string|in:3prep,1sec',
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'date_of_birth' => $request->dateOfBirth,
            'password' => bcrypt($request->password),
            'is_instructor' => false,
        ]);

        $user->student()->create([
            'grade' => $request->grade,
            'points' => 0,
        ]);

        $user->sendEmailVerificationNotification();
        Auth::login($user);
        return redirect()->route('verification.notice');
    }
}
