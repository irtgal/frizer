<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TermControllerClient extends Controller
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
            $termsForDay[$incrementedDate] = Term::whereDate('full_time', $incrementedDate)->where('reserved', false)->orderBy('full_time')->get();
        }
        return response()->json($termsForDay);
    }

    // reserve or unreserve term
    public function update(Request $request, $id)
    {
        $term = Term::findOrFail($id);
        if ($request['reserved'] && $request['name'] && $request['type']) {
            $term->update(['reserved'=> true, 'name' => $request['name'], 'type'=> $request['type'],'contact'=> $request['contact']]);
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
