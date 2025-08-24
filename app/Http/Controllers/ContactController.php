<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        return view('Contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);
        Contact::create([
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'user_id' => Auth::user()->id,
        ]);
        return redirect()->route('contact.index')->with('success', 'Message sent successfully!');
    }
}
