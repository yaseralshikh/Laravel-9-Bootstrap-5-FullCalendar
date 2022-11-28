<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $events = [];

        $appointments = Appointment::with(['user'])->get();

        foreach ($appointments as $appointment) {
            $events[] = [
                'title' => $appointment->task,
                'start' => $appointment->start_time,
                'end'   => $appointment->finish_time,
            ];
        }
        return view('home', [
            'events' => $events,
        ]);
    }
}
