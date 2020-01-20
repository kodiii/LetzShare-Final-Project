<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\User;

class ContactController extends Controller
{
    // https://www.youtube.com/watch?v=rn0BHdqrock
    public function index()
    {
        return view('contact');
    }

    public function sendEmail(Request $request)
    {
        $this->validate($request, [
            'fullname' => 'required|min:4|max:100',
            'email' => 'required|email|min:4|max:100',
            'message' => 'required|min:5|max:500',
        ]);

        $data = array(
            'fullname' => $request->fullname,
            'message' => $request->message,
            'ip' => request()->ip(),
            'timestamp' => \Carbon\Carbon::now(),
            'sendEmail' => true
        );

        Mail::to($request->email)->send(new SendMail($data));

        return back()->with('success', 'Thanks for contacting us!');
    }

    public function sendMessage(Request $request, $id)
    {
        $validatedData = \Validator::make($request->all(), [
            'fullname' => 'required|min:4|max:100',
            'email' => 'required|email|min:4|max:100',
            'message' => 'required|min:5|max:500',
            'user_id' => 'required'
        ]);
        if($validatedData->fails()){
            return response()->json(['errors' => $validatedData->errors()->all()]);
        }else{
        $receiver = User::find($id);
        $data = array(
            'fullname' => $request->fullname,
           'from' => $request->email,
            'message' => $request->message,
            'ip' => request()->ip(),
            'timestamp' => \Carbon\Carbon::now(),
            'sendEmail' => false
        );

      Mail::to($receiver->email)
      ->send(new SendMail($data));

      return response()->json(['success' => 'Your message was successfully sent to '. $receiver->name .'!']);
    }

    }
}
