<?php

namespace App\Http\Controllers;


use App\Models\Term;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewReservation;


class TermControllerClient extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $minAvailableDate = Term::where('full_time', '>=', date("Y-m-d"))
                ->where('reserved', false)
                ->min('full_time');
        if ($minAvailableDate) {
            $minAvailableDate = Carbon::parse($minAvailableDate)->format('Y-m-d');
        } else {
            $minAvailableDate = null;
        }

        $maxAvailableDate = Term::where('reserved', false)->max('full_time');
        if ($maxAvailableDate) {
            $maxAvailableDate = Carbon::parse($maxAvailableDate)->format('Y-m-d');
        } else {
            $maxAvailableDate = null;
        }

        $startDate = $request['start_date'];
        if (!$startDate || !(bool) strtotime($startDate)) {
            $startDate = $minAvailableDate;
        }

        $loadDays = 3;
        if ($request['load_days']) {
            $loadDays = $request['load_days'];
        }

        $termsForDay = [];
        for ($i = 0; $i < $loadDays; $i++) {
            $incrementDay = strtotime("+" . $i . "day", strtotime($startDate));
            $incrementedDate = date("Y-m-d", $incrementDay);
            $termsForDay[$incrementedDate] = Term::whereDate('full_time', $incrementedDate)->where('reserved', false)->orderBy('full_time')->get();
        }


        $response = [
            'timetable' => $termsForDay,
            'first_available_date' => $minAvailableDate,
            'last_available_date' => $maxAvailableDate,
        ];
        return response()->json($response);
    }

    // reserve or unreserve term
    public function update(Request $request, $id)
    {
        $term = Term::findOrFail($id);
        if ($request['reserved'] && $request['name'] && $request['type']) {
            if ($term->reserved) {
                return response()->json(['error'=> 'Nekdo je ravnokar rezerviral ta termin.']);
            }

            $term->update(['reserved'=> true, 'name' => $request['name'], 'type'=> $request['type'],'contact'=> $request['contact']]);

            Mail::to("gal.irt.01@gmail.com")->queue(new NewReservation($term));

        } else {
            $term->update(['reserved'=> false, 'name' => null, 'type'=> null,'contact'=> null]);
        }
        return $term;
    }

    public function show(Request $request, $id)
    {
        $term = Term::findOrFail($id);
        return response()->json($term);
    }

    public function types(Request $request) {
        $types = Type::all();
        return response()->json($types);
    }

}
