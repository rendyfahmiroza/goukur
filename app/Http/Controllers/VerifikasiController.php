<?php

namespace App\Http\Controllers;

use App\Verifikasi;
use App\Berkas;
use App\HistoryUsers;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $berkas = Berkas::find($request->berkas_id);
        $berkas->status_proses = 'proses';
        $berkas->save();

        $berkas = HistoryUsers::find($request->history_user_id);
        $berkas->status_proses = 'proses';
        $berkas->save();

        $verifikasi = new Verifikasi;
        $verifikasi->history_user_id = $request->history_user_id;
        $verifikasi->catatan = $request->catatan;
        $verifikasi->tanggal = date('Y-m-d H:i:s');
        $verifikasi->save();

        return response()->json($request, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Verifikasi  $verifikasi
     * @return \Illuminate\Http\Response
     */
    public function show(Verifikasi $verifikasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Verifikasi  $verifikasi
     * @return \Illuminate\Http\Response
     */
    public function edit(Verifikasi $verifikasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Verifikasi  $verifikasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Verifikasi $verifikasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Verifikasi  $verifikasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Verifikasi $verifikasi)
    {
        //
    }
}
