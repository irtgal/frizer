<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
            $startDate = $request['start_date'];
        }

        $loadDays = 3;
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
            'date' => ['required'], // , 'date_format:Y-m-d'],
            'start' => ['required', 'date_format:H:i'],
            'end' => ['required', 'date_format:H:i'],
        ]);
        $startTime = Carbon::createFromFormat('H:i Y-m-d',  $data['start'] . " " . $data["date"]);
        $endTime = Carbon::createFromFormat('H:i Y-m-d',  $data['end'] . " " . $data["date"]);
        while ($startTime < $endTime) {
            if (!Term::where('full_time', $startTime)->exists()) {
                Term::create(['full_time' => $startTime]);
            }
            $startTime = $startTime->addMinutes(30);
        }
        return $endTime;

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
    public function update(Request $request, $id)
    {
        $term = Term::findOrFail($id);
        if ($request['reserved'] && $request['name'] && $request['type']) {
            if ($term->reserved) {
                return response()->json(['error'=> 'Nekdo je ravnokar rezerviral ta termin.']);
            }

            $term->update(['reserved'=> true, 'name' => $request['name'], 'type'=> $request['type'],'contact'=> $request['contact']]);

            send_mail_confirmation($term);

        } else {
            if ($term->reserved) {
                send_mail_cancellation($term);
            }
            $term->update(['reserved'=> false, 'name' => null, 'type'=> null,'contact'=> null]);
        }
        return $term;
    }

    public function deleteMany(Request $request)
    {
        $ids = $request['ids'];
        foreach ($ids as $id) {
            $term = Term::findOrFail($id);
            $term->delete();
        }
        return true;
    }

    public function clearMany(Request $request)
    {
        $ids = $request['ids'];
        foreach ($ids as $id) {
            $term = Term::findOrFail($id);
            $term->update(['reserved'=> false, 'name' => null, 'type'=> null,'contact'=> null]);
        }
        return true;
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
