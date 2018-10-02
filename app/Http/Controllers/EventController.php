<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use MaddHatter\LaravelFullcalendar\Facades\Calendar;

use App\Event;
use Pusher\Pusher;
class EventController extends Controller

{



    public function index()

    {

        $events = [];

        $data = Event::all();

        if($data->count()){

            foreach ($data as $key => $value) {

                $events[] = Calendar::event(

                    $value->title,

                    true,

                    new \DateTime($value->start_date),

                    new \DateTime($value->end_date.' +1 day'),
                    null,
                    [
                     'color' => 'red',
                     'url' => 'pass here url and any route',
                     'id' => $value->id,
                    ]
                );

            }

        }

        $calendar = Calendar::addEvents($events);
        return view('backEnd.users.mycalender', compact('calendar'));

    }

    public function store(Request $request)
    {
        Event::create($request->all());

        $options = array(
            'cluster' => 'ap1',
            //'encrypted' => true,
            'useTLS' => true,
        );

        $pusher = new Pusher(
            '8ad3fa296f9b5f85c3ff',
            '4767c17620e00bb7b870',
            '611672',
            $options
        );
        $pusher->trigger('Calendar', 'calendar-update',$request->all());

        //return  $request->all();
    }

    public function calendar(){
        return view('backEnd.users.calendar');
    }

}