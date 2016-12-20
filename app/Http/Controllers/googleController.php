<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;

class googleController extends Controller
{
    //

    	public function index() {
        
		
		$event = new Event;

		$event->name = 'sbamTONY';
		$event->startDateTime = Carbon::now();
		$event->endDateTime = Carbon::tomorrow('Europe/London');

		$return = $event->save();

		$data = Event::find($return->googleEvent->id);


			\Debugbar::info($data);

			return view('/home' );

//        return true;



    }
}
