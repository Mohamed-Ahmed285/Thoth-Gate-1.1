<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\AdminNotificationEvent;
use App\Models\AdminNotification;

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
            'user_id' => Auth::id(),
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);
        
        $notification = AdminNotification::create([
            'title' => "New contact message from " . Auth::user()->name,
            'message' => "Subject: " . $validated['subject'] . ", Message: " . $validated['message'],
            'is_read' => false,
        ]);

        event(new AdminNotificationEvent($notification));
        
        return redirect()->route('contact.index')->with('success', 'Message sent successfully!');
    }
}
