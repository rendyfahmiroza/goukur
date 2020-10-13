<?php

namespace App\Http\Controllers;

use App\Berkas;
use App\HistoryUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ixudra\Curl\Facades\Curl;

class DashboardPetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $berkas = HistoryUsers::where('user_id', '=', Auth::user()->id)->get();
        $json = array();
        $jatuhTempo = 0;
        $proses = 0;
        $selesai = 0;
        $batal = 0;
        $kuasaPpat = 0;
        $kuasaMasyarakat = 0;

        foreach ($berkas as $value) {

            //  Manipulasi Tanggal
            $start_date = \Carbon\Carbon::now();
            $expired_date = \Carbon\Carbon::parse($value->tanggal_pengukuran);
            $result_date = $start_date->diffInDays($expired_date, false);
            // dd($result_date);
            
            // Kalkulasi Jatuh Tempo
            if ($value->status_proses == 'batal') {
                $batal++;
            } else {
                if ($value->status_proses == 'proses' && $result_date <= 0) {
                    $jatuhTempo++;
                }
            }

            // Kalkulasi Proses dan Selesai
            if ($value->status_proses == 'proses') {
                $proses++; 
            }else if ($value->status_proses == 'selesai') {
                $selesai++;
            }

            // Kalkulasi Kuasa PPAT dan Masyarakat
            if ($value->getBerkas->kuasa_berkas == 'ppat') {
                $kuasaPpat++;
            }else if ($value->getBerkas->kuasa_berkas == 'masyarakat') {
                $kuasaMasyarakat++;
            }

        }

        // Inisialisasi data
        $json['jatuh_tempo'] = $jatuhTempo;
        $json['proses'] = $proses;
        $json['selesai'] = $selesai;
        $json['batal'] = $batal;
        $json['data_kuasa'] = array(array($kuasaPpat, $kuasaMasyarakat));

        return response()->json($json, 200);
    }
}
