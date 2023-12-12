<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Students;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::where('status', 1)->where('type', 'message')->with(['student'])->orderBy('updated_at', 'desc')->get();
        return view('admin.messages')->with('messages', $messages);
    }


    public function sendMessage(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id_no',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $student = Students::where('id_no', $request->input('student_id'))->first();

        if ($student) {
            $message = new Message();
            $message->student_id = $student->id;
            $message->subject = $request->input('subject');
            $message->message = $request->input('message');
            $message->save();

            return redirect()->back()->with('flash_message', 'Message sent successfully!');
        }

        return redirect()->back()->with('flash_message', 'Error: Student not found.');
    }

    public function destroy($id)
    {
        $messages = Message::find($id);

        $messages->update(['status' => 0]);

        return redirect('/admin/messages')->with('flash_message', 'Officer deleted successfully');
    }
}
