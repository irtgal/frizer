<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Exception;
use Illuminate\Http\Request;

class TermControllerAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $startDate = date("Y-m-d");
        if ($request['start_date'] && (bool) strtotime($request['start_date'])) {
            $startDate = date_create_from_format('d.m.Y', $request['start_date'])->format('Y-m-d');
        }

        $loadDays = 7;
        if ($request['load_days']) {
            $loadDays = $request['load_days'];
        }

        $termsForDay = [];
        for ($i = 0; $i < $loadDays; $i++) {
            $incrementDay = strtotime("+" . $i . "day", strtotime($startDate));
            $incrementedDate = date("Y-m-d", $incrementDay);
            $termsForDay[$incrementedDate] = Term::whereDate('full_time', $incrementedDate)->orderBy('full_time')->get();
        }
        return response()->json($termsForDay);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'time' => ['required'], //, 'date_format:H:i'],
            'date' => ['required'], //, 'date_format:d.m.Y'],
        ]);
        $full_time_string = $data['time'] . ' ' . $data['date'];
        $full_date_time = date_create_from_format('H:i Y-m-d', $full_time_string);
        $newTerm = Term::create(['full_time' => $full_date_time]);
        return $newTerm;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        return Term::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Term $term)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Term  $term
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $term = Term::findOrFail($id);
        $status = $term->delete();
        if ($status != 1) {
            return response()->json(false, 500);
        }
        return response()->json(true);
    }
}
