<?php

namespace App\Http\Controllers;

use App\User;
use App\Berkas;
use App\HistoryUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PpatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hak_akses == '1') {
            $ppat = User::where('hak_akses','4')->get();
        } else {
            $ppat = User::where('hak_akses','4')->where('kantah',Auth::user()->kantah)->get();
        }
        return response()->json($ppat, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ppat = new User;
        $ppat->name = $request->name;
        $ppat->email = $request->email;
        $ppat->password = Hash::make($request->password);
        $ppat->status = $request->status;
        $ppat->kantah = $request->kantah;
        $ppat->hak_akses = $request->hak_akses;
        $ppat->no_telepon = $request->no_telepon;
        $ppat->telegram_id = $request->telegram_id;
        $ppat->save();

        return response()->json($ppat, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ppat = User::find($id);
        return response()->json($ppat, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_kab($id)
    {
        $petugas = User::where('hak_akses', '4')->where('kantah', $id)->get();
        return response()->json($petugas, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_berkas(Request $request)
    {
        if ($request->exists('filterData')) {
            $berkas = Berkas::where('kuasa_ppat', Auth::user()->id)->where('status_proses','=','proses')->get();
        } else {
            $berkas = Berkas::where('kuasa_ppat', Auth::user()->id)->where('status_proses','<>','baru-mandiri')->get();
            // dd($berkas);
        }
        
        // dd($berkas);
        $json = array();
        foreach ($berkas as $value) {
            $item = array();

            // Manipulasi Tanggal untuk mengetahui jatuh tempo
            $start_date = \Carbon\Carbon::now();
            $expired_date = \Carbon\Carbon::parse($value->tanggal_pengukuran);
            $result_date = $start_date->diffInDays($expired_date, false);

            $item['id'] = $value->id;
            $item['nama_pemohon'] = $value->nama_pemohon;
            $item['nomor_hak'] = $value->nomor_hak;
            $item['kabupaten_id'] = $value->kabupaten_id;
            $item['kecamatan_id'] = $value->kecamatan_id;
            $item['desa_id'] = $value->desa_id;

            $history = HistoryUsers::where('berkas_id', $value->id)->where('status_proses', 'proses')->first();

            $item['petugas_ukur'] = $history->getUser->name;
            $item['petugas_ukur_nomor'] = $history->getUser->no_telepon;

            $item['alamat'] = $value->alamat;
            $item['catatan'] = $value->catatan;
            $item['tanggal_pengukuran'] = $result_date;
            $item['kuasa_berkas'] = $value->kuasa_berkas;
            $item['no_hp_kuasa'] = $value->no_hp_kuasa;
            $item['biaya_taktis'] = $value->biaya_taktis;
            $item['biaya_proses'] = $value->biaya_proses;
            $item['status_proses'] = $value->status_proses;

            if ($request->exists('filterData')) {
                if ($request->filterData == 'jatuh-tempo' && $result_date <= 0) {
                    array_push($json, $item);
                } 
                
                if ($request->filterData == 'proses') {
                    array_push($json, $item);
                }
            } else {
                array_push($json, $item);
            }
        }

        return response()->json($json, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $ppat)
    {
        $ppat->name = $request->name;
        $ppat->email = $request->email;
        $ppat->kantah = $request->kantah;
        $ppat->no_telepon = $request->no_telepon;
        $ppat->telegram_id = $request->telegram_id;
        $ppat->status = $request->status;
        if ($request->password != null) {
            $ppat->password = Hash::make($request->password);
        }
        $ppat->update();
        // $ppat->fill($request->all());
        // $ppat->save();
        return response()->json($request, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $ppat)
    {
        $ppat->delete();
        return response()->json($ppat, 200);
    }
}
