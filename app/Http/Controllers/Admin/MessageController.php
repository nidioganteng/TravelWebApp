<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message; 

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->get();
        return view('admin.message', compact('messages'));
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success', 'Message successfully deleted.');
    }

    public function markAsRead($id)
    {
        $message = Message::findOrFail($id);
        
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        // Kembalikan response sukses untuk Alpine.js
        return response()->json(['success' => true]);
    }
}