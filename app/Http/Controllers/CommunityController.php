<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\CommunityMessage;
use App\Models\PurchasedCommunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'user_id' => auth()->id(),
            'message' => $request->message,
            'community_id' => $request->community_id,
            'created_at' => now('Africa/Cairo'),
        ]);

        $user = $message->user;

        // Return HTML for AJAX (single message)
        return response()->json([
            'html' => '
        <div class="message '.($user->id === auth()->id() ? 'user-message' : 'other-message').'">
            <div class="message-avatar">
                <img src="/imgs/profile.png" alt="Student">
            </div>
            <div class="message-content">
                <div class="message-header">
                    <span class="message-author">'.($user->type == 1 ? 'Mr.' : '').$user->name.'</span>
                    <span class="message-time">'. $message->created_at->format('h:i A').'</span>

                </div>
                <p>'.$message->message.'</p>
            </div>
        </div>'
        ]);
    }

    public function fetchMessages(Request $request)
    {
        $community_id = $request->community_id;
        $messages = CommunityMessage::where('community_id', $community_id)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        $html = '';
        foreach ($messages as $message) {
            $html .= '<div class="message '.($message->user_id === auth()->id() ? 'user-message' : (Auth::user()->type == 2 ? "system-message" : "other-message")).'">
            <div class="message-avatar">
                <img src="/imgs/profile.png" alt="Student">
            </div>
            <div class="message-content">
                <div class="message-header">
                    <span class="message-author">'.($message->user->type == 1 ? 'Mr. ' : '').$message->user->name.'</span>
                    <span class="message-time">'. $message->created_at->format('h:i A').'</span>
                </div>
                <p>'.$message->message.'</p>
            </div>
          </div>';
        }
        return response($html);
    }
}
