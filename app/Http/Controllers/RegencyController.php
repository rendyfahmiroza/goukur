<?php

namespace App\Http\Controllers;

use App\Regencies;
use App\Districts;
use App\Villages;
use Illuminate\Http\Request;

class RegencyController extends Controller
{
    public function regency($id) {
        $regency = Districts::where('regency_id', $id)->get();

        return response()->json($regency, 200);
    }

    public function districs($id) {
        $regency = Villages::where('district_id', $id)->get();

        return response()->json($regency, 200);
    }
}
