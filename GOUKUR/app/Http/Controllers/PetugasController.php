<?php

namespace App\Http\Controllers;

use App\User;
use App\Berkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hak_akses == '1') {
            $petugas = User::where('hak_akses', '3')->get();
        } else if (Auth::user()->hak_akses == '2') {
            $petugas = User::where('hak_akses', '3')->where('kantah','=',Auth::user()->kantah)->get();
        }

        foreach ($petugas as $item) {
            $berkas = Berkas::where('petugas_ukur_id', $item->id)->get();
            $proses = 0;
            $jatuh_tempo = 0;

            foreach ($berkas as $bk) {
                $start_date = \Carbon\Carbon::now();
                $expired_date = \Carbon\Carbon::parse($bk->tanggal_pengukuran);
                $result_date = $start_date->diffInDays($expired_date, false);

                if ($bk->status_proses == 'proses') {
                    $proses++;
                }

                if ($bk->status_proses == 'batal') {
                    // $batal++;
                } else {
                    if ($result_date < 0) {
                        $jatuh_tempo++;
                    }
                }
            }

            $item->proses = $proses;
            $item->jatuh_tempo = $jatuh_tempo;
        }

        return response()->json($petugas, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $petugas = new User;
        $petugas->name = $request->name;
        $petugas->email = $request->email;
        $petugas->password = Hash::make($request->password);
        $petugas->status = $request->status;
        $petugas->kantah = $request->kantah;
        $petugas->hak_akses = $request->hak_akses;
        $petugas->no_telepon = $request->no_telepon;
        $petugas->telegram_id = $request->telegram_id;
        $petugas->nip = $request->nip;
        $petugas->golongan = $request->golongan;
        $petugas->save();

        return response()->json($petugas, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $petugas = User::find($id);
        return response()->json($petugas, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_kab($id)
    {
        $petugas = User::where('hak_akses', '3')->where('kantah', $id)->get();
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
            $berkas = Berkas::where('petugas_ukur_id', Auth::user()->id)->where('status_proses','=','proses')->get();
        } else {
            $berkas = Berkas::where('petugas_ukur_id', Auth::user()->id)->where('status_proses','<>','baru-mandiri')->get();
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
    public function update(Request $request, $id)
    {
        $petugas = User::find($id);
        $petugas->name = $request->name;
        $petugas->email = $request->email;
        $petugas->kantah = $request->kantah;
        $petugas->no_telepon = $request->no_telepon;
        $petugas->telegram_id = $request->telegram_id;
        $petugas->status = $request->status;
        $petugas->nip = $request->nip;
        $petugas->golongan = $request->golongan;
        if ($request->password != null) {
            $petugas->password = Hash::make($request->password);
        }
        $petugas->update();
        // $petugas->fill($request->all());
        // $petugas->save();
        return response()->json($petugas, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $petugas)
    {
        $petugas->delete();
        return response()->json($petugas, 200);
    }
}
