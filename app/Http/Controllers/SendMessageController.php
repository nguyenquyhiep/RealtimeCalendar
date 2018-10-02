<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;

class SendMessageController extends Controller
{
    public function index()
    {
        return view('sendmessage');
    }
    public function sendMessage(Request $request)
    {

        $data['title'] = $request->input('title');
        $data['content'] = $request->input('content');
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true,
           // 'useTLS' => true,
        );

        $pusher = new Pusher(
            '8ad3fa296f9b5f85c3ff',
            '4767c17620e00bb7b870',
            '611672',
            $options
        );

        $pusher->trigger('Notify', 'send-message', $data);

        return redirect('/send');
    }
}
