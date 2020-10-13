<?php

namespace App\Http\Controllers;

use App\User;
use App\Berkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OperatorController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_berkas(Request $request)
    {
        if ($request->exists('filterData')) {
            $berkas = Berkas::where('kabupaten_id', Auth::user()->kantah)->where('status_proses','=','proses')->get();
        } else {
            $berkas = Berkas::where('kabupaten_id', Auth::user()->kantah)->where('status_proses','<>','baru-mandiri')->get();
        }

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
            $item['petugas_ukur_id'] = $value->pengguna->name;
            $item['alamat'] = $value->alamat;
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_berkas_filter(Request $request)
    {
        $berkas = Berkas::where('kabupaten_id', Auth::user()->kantah)->where('status_proses','<>','baru-mandiri')->get();

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
            $item['petugas_ukur_id'] = $value->pengguna->name;
            $item['alamat'] = $value->alamat;
            $item['tanggal_pengukuran'] = $result_date;
            $item['kuasa_berkas'] = $value->kuasa_berkas;
            $item['no_hp_kuasa'] = $value->no_hp_kuasa;
            $item['biaya_taktis'] = $value->biaya_taktis;
            $item['biaya_proses'] = $value->biaya_proses;
            $item['status_proses'] = $value->status_proses;

            array_push($json, $item);
        }

        return response()->json($json, 200);
    }
}
