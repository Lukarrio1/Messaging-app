<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\NewMessage;
use App\Delete;

class MessageController extends Controller
{
    public function getMessages($id)
    {
        // $message = array();
        // $del = Delete::where('user_id', Auth::user()->id)->get();
        // foreach ($del as $delete) {
        //     $messages = Message::where([['to', '=', $id], ['from', '=', $id], ['id', '!=', $delete->message_id]])->get();
        //     foreach ($messages as $msg) {
        //         $message[] = [
        //             'id' => $msg->id,
        //             'to' => $msg->to,
        //             'from' => $msg->from,
        //             'message' => $msg->message,
        //             'created_at' => $msg->created_at,
        //             'updated_at' => $msg->updated_at
        //         ];
        //     }
        // }
        $messages =
            Message::where(function ($q) use ($id) {
                $q->where('from', Auth::user()->id);
                $q->where('to', $id);
            })->orWhere(function ($q) use ($id) {
                $q->where('from', $id);
                $q->where('to', Auth::user()->id);
            })
            ->get();

        return $messages;
    }

    public function sendMessage(Request $request)
    {
        $msg = new Message;
        $msg->to = $request->to;
        $msg->from = Auth::user()->id;
        $msg->message = $request->message;
        $msg->save();
        return ['status' => 201];
    }

    public function deleteMessage(Request $request)
    {
        $del = new Delete;
        $del->user_id = Auth::user()->id;
        $del->message_id = $request->message_id;
        $del->save();
        return ['status', 200];
    }
}
