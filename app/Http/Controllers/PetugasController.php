<?php

namespace App\Http\Controllers;

use App\User;
use App\HistoryUsers;
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
            $berkas = HistoryUsers::where('user_id', $item->id)->get();
            $proses = 0;
            $selesai = 0;
            $batal = 0;
            $jatuh_tempo = 0;

            foreach ($berkas as $bk) {
                $start_date = \Carbon\Carbon::now();
                $expired_date = \Carbon\Carbon::parse($bk->tanggal_pengukuran);
                $result_date = $start_date->diffInDays($expired_date, false);

                if ($bk->status_proses == 'proses') {
                    $proses++;
                }

                if ($bk->status_proses == 'selesai') {
                    $selesai++;
                } else {
                    if ($bk->status_proses == 'gagal') {
                        $batal++;
                    } else {
                        if ($result_date < 0) {
                            $jatuh_tempo++;
                        }
                    }
                }
            }

            $item->proses = $proses;
            $item->jatuh_tempo = $jatuh_tempo;
            $item->selesai = $selesai;
            $item->batal = $batal;
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
            $berkas = HistoryUsers::where('user_id', Auth::user()->id)->where('status_proses','=','proses')->get();
        } else {
            $berkas = HistoryUsers::where('user_id', Auth::user()->id)->get();
        }
       
        // dd($berkas);

        $json = array();
        foreach ($berkas as $value) {
            $item = array();

            // Manipulasi Tanggal untuk mengetahui jatuh tempo
            $start_date = \Carbon\Carbon::now();
            $expired_date = \Carbon\Carbon::parse($value->tanggal_pengukuran);
            $result_date = $start_date->diffInDays($expired_date, false);

            $item['id'] = $value->berkas_id;
            $item['nama_pemohon'] = $value->getBerkas->nama_pemohon;
            $item['nomor_hak'] = $value->getBerkas->nomor_hak;
            $item['kabupaten_id'] = $value->getBerkas->kabupaten_id;
            $item['kecamatan_id'] = $value->getBerkas->kecamatan_id;
            $item['desa_id'] = $value->getBerkas->desa_id;

            // $item['petugas_ukur_id'] = $history->getUser->name;

            $item['alamat'] = $value->getBerkas->alamat;
            $item['catatan'] = $value->getBerkas->catatan;
            $item['tanggal_pengukuran'] = $result_date;
            $item['kuasa_berkas'] = $value->getBerkas->kuasa_berkas;
            $item['no_hp_kuasa'] = $value->getBerkas->no_hp_kuasa;
            $item['biaya_taktis'] = $value->getBerkas->biaya_taktis;
            $item['biaya_proses'] = $value->getBerkas->biaya_proses;
            $item['status_proses'] = $value->getBerkas->status_proses;

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function penugasan(Request $request, $id)
    {
        $petugas = User::where('hak_akses', '3')->where('kantah', $id)->get();
        $json = array();
        foreach ($petugas as $data) {
            $arr = new \StdClass();
            $arr->id = $data->id;
            $arr->nama = $data->name;
            $jlhBerkas = 0;

            $arr->exp = FALSE;
            $arr->fail = FALSE;
            foreach ($data->getHistory as $history) {
                $start_date = \Carbon\Carbon::now();
                $expired_date = \Carbon\Carbon::parse($history->tanggal_pengukuran);

                if ( ( $history->status_proses != 'selesai' &&  $history->status_proses != 'batal' && $history->status_proses != 'gagal' ) && $start_date->diffInDays($expired_date, false) < 0) {
                    $expired = true;
                    $arr->exp = $expired;
                }
                if ($history->status_proses == 'gagal' && $history->berkas_id == $request->id) {
                    $failed = true;
                    $arr->fail = $failed;
                }
            }

            foreach ($data->getHistory->where('status_proses', 'proses') as $historyBerkas) {
                $jlhBerkas++;
            }
            $arr->jlhBerkas = $jlhBerkas;
            
            array_push($json, $arr);
        }

        return response()->json($json, 200);
    }
}
