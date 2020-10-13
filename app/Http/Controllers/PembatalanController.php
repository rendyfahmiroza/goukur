<?php

namespace App\Http\Controllers;

use App\Pembatalan;
use Illuminate\Http\Request;

class PembatalanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembatalan = Pembatalan::all();
        return response()->json($pembatalan, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pembatalan = new Pembatalan;
        $pembatalan->pembatalan = $request->pembatalan;
        $save = $pembatalan->save();

        return response()->json($pembatalan, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pembatalan  $pembatalan
     * @return \Illuminate\Http\Response
     */
    public function show(Pembatalan $pembatalan)
    {
        return response()->json($pembatalan, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pembatalan  $pembatalan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pembatalan $pembatalan)
    {
        $pembatalan->pembatalan = $request->pembatalan;
        $pembatalan->update();

        return response()->json($pembatalan, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pembatalan  $pembatalan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembatalan $pembatalan)
    {
        $pembatalan->delete();
        return response()->json($pembatalan, 200);
    }
}
