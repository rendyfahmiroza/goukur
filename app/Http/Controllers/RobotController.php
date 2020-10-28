<?php

namespace App\Http\Controllers;

use App\HistoryUsers;
use App\Berkas;
use Illuminate\Http\Request;

class RobotController extends Controller
{
    public function tertunda(Request $request)
    {
        $berkas = Berkas::where('status_proses','=','proses')->get();
        
        foreach ($berkas as $value) {
            // Manipulasi Tanggal untuk mengetahui jatuh tempo
            $history = HistoryUsers::where('berkas_id', $value->id)->where('status_proses', 'proses')->first();
            $start_date = \Carbon\Carbon::now();
            $expired_date = \Carbon\Carbon::parse($history->tanggal_pengukuran);
            $result_date = $start_date->diffInDays($expired_date, false);

            if ($result_date < 0) {
                $history->status_proses = 'gagal';
                $history->catatan_proses = 'Telah memasuki jatuh tempo';
                $history->save();

                $dataBerkas = Berkas::find($value->id);
                $dataBerkas->status_proses = 'tertunda';
                $dataBerkas->save();                
            }
        }
    }
}
