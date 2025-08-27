<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityMessage;
use App\Models\PurchasedCommunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageEvent;
class CommunityController extends Controller
{
    public function index()
    {
        $grade = Auth::user()->student->grade;
        $student_id = Auth::user()->student->id;
        $fullCommunity = Community::where('grade' , $grade)->first();

        $community = PurchasedCommunity::where('community_id' , $fullCommunity->id)
            ->where('student_id' , $student_id)
            ->first();

        if (!$community || $community->end_date < now()){
            return redirect()
                ->route('home')
                ->with('error' , 'You don\'t have access to this community');
        }

        $messages = $fullCommunity->messages->all();

        return view('Community' , [
            'community' => $community,
            'fullCommunity' => $fullCommunity,
            'messages' => $messages
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $message = CommunityMessage::create([
            'user_id' => Auth::user()->id,
            'message' => $request->message,
            'community_id' => $request->community_id,
            'created_at' => now('Africa/Cairo'),
        ]);

        // Load the user relationship before broadcasting
        $message->load('user');

        // Broadcast the event to the correct channel and exclude the sender
        broadcast(new \App\Events\MessageEvent($message))->toOthers();

        return response()->json(['status' => 'Message Sent!']);
    }
}
