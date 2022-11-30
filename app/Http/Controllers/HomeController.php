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
                'title' => $appointment->task . '(' . $appointment->user->name . ')',
                'start' => $appointment->start_time,
                'end'   => $appointment->finish_time,
            ];
        }
        return view('home', [
            'events' => $events,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'semester' => 'required',
            'task' => 'required|string',
            'start_time' => 'required|date',
            'finish_time' => 'required|date',
        ]);

        $appointment = Appointment::create([
            'semester' => $request->semester,
            'task' => $request->task,
            'start_time' => $request->start_time,
            'finish_time' => $request->finish_time,
            'user_id' => $request->user_id,
        ]);

        $color = null;

        if($appointment->title == 'Test') {
            $color = '#924ACE';
        }

        return response()->json([
            'id' => $appointment->id,
            'start' => $appointment->start_time,
            'end' => $appointment->finish_time,
            'title' => $appointment->task,
            'color' => $color ? $color: '',
        ]);
    }
}
