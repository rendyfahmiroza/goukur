<?php

namespace App\Http\Controllers;

use App\Kantor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KantorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hak_akses == '1') {
            $kantor = Kantor::all();
        } else if (Auth::user()->hak_akses == '2') {
            $kantor = Kantor::where('kabupaten_id','=',Auth::user()->kantah)->get();
        }
        
        return response()->json($kantor, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kantor = new Kantor;
        $kantor->kabupaten_id = $request->kabupaten_id;
        $kantor->nama = $request->nama;
        $kantor->kepala_kantor = $request->kepala_kantor;
        $kantor->kasi = $request->kasi;
        $kantor->nip_kasi = $request->nip_kasi;
        $kantor->alamat = $request->alamat;
        $kantor->no_telepon = $request->no_telepon;
        $kantor->ibukota = $request->ibukota;
        $kantor->save();

        return response()->json($kantor, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kantor  $kantor
     * @return \Illuminate\Http\Response
     */
    public function show(Kantor $kantor)
    {
        return response()->json($kantor, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kantor  $kantor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kantor $kantor)
    {
        $kantor->kabupaten_id = $request->kabupaten_id;
        $kantor->nama = $request->nama;
        $kantor->kepala_kantor = $request->kepala_kantor;
        $kantor->kasi = $request->kasi;
        $kantor->nip_kasi = $request->nip_kasi;
        $kantor->alamat = $request->alamat;
        $kantor->no_telepon = $request->no_telepon;
        $kantor->ibukota = $request->ibukota;
        $kantor->update();

        return response()->json($kantor, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kantor  $kantor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kantor $kantor)
    {
        $kantor->delete();
        return response()->json($kantor, 200);
    }
}
