<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    public function waiting(){
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect('/');
        }

        return view('emails.waiting-verify');
    }
    public function verify($id, $hash , EmailVerificationRequest $request){
        $request->fulfill();
        return redirect('/');
    }

    public function resend(Request $request){
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }
}
