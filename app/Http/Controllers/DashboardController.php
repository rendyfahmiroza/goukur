<?php

namespace App\Http\Controllers;

use App\Berkas;
use App\Regencies;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        // dd($this->sendMessage('479255374', 'Test'));
        // die;
        $berkas = Berkas::where('status_proses','<>','baru-mandiri')->get();
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
            $expired_date = \Carbon\Carbon::parse($value->tanggal_pengukuran)->addDays(3);
            $result_date = $start_date->diffInDays($expired_date, false);
            // dd($result_date);
            // echo $result_date;
            
            // Kalkulasi Jatuh Tempo
            if ($value->status_proses == 'batal') {
                $batal++;
            } else {
                if ($value->status_proses == 'proses' && $result_date < 0) {
                    $jatuhTempo++;
                }
            }

            // Kalkulasi Proses dan Selesai
            if ($value->status_proses == 'proses') {
                $proses++; 
            } else if ($value->status_proses == 'selesai') {
                $selesai++;
            }

            // Kalkulasi Kuasa PPAT dan Masyarakat
            if ($value->kuasa_berkas == 'ppat') {
                $kuasaPpat++;
            }else if ($value->kuasa_berkas == 'masyarakat') {
                $kuasaMasyarakat++;
            }

        }

        $regency = Regencies::where('province_id', '11')->get();
        // echo $regency;
        
        $data_proses = array();
        $data_selesai = array();
        $data_jatuh_tempo = array();
        $data_kabupaten = array();
        $data_tertinggi = array();
        foreach ($regency as $value) {

            // Simpan data kabupaten
            array_push($data_kabupaten, $value->name);

            // Ambil berkas per Kabupaten
            $berkas = Berkas::where('kabupaten_id', $value->id)->where('status_proses','<>','baru-mandiri')->get();
            $bProses = 0;
            $bSelesai = 0;
            $bJatuhTempo = 0;
            $bTotalBerkas = 0;
            $data_per_kab = array();
            foreach ($berkas as $bV) {

                // Sum data berkas per kabupaten
                $bTotalBerkas++;

                //  Manipulasi Tanggal
                $start_date = \Carbon\Carbon::now();
                $expired_date = \Carbon\Carbon::parse($bV->tanggal_pengukuran)->addDays(3);
                $result_date = $start_date->diffInDays($expired_date, false);
                
                // Kalkulasi Jatuh Tempo
                if ($bV->status_proses == 'batal') {
                    // $batal++;
                } else {
                    if ($result_date <= 0) {
                        $bJatuhTempo++;
                    }
                }

                // Kalkulasi Status Proses
                if ($bV->status_proses == 'proses') {
                    $bProses++;
                } else if ($bV->status_proses == 'selesai') {
                    $bSelesai++; 
                }
            }
            
            // Data Terbanyak
            $data_per_kab['kabupaten'] = $value->name;
            $data_per_kab['selesai'] = $bSelesai;
            $data_per_kab['total'] = $bTotalBerkas > 0 ? number_format(($bSelesai / $bTotalBerkas) * 100, 2) : 0;

            // Masukan data 
            array_push($data_jatuh_tempo, $bJatuhTempo);
            array_push($data_proses, $bProses);
            array_push($data_selesai, $bSelesai);
            array_push($data_tertinggi, $data_per_kab);
        }

        // Inisialisasi data
        $json['jatuh_tempo'] = $jatuhTempo;
        $json['proses'] = $proses;
        $json['selesai'] = $selesai;
        $json['batal'] = $batal;
        $json['kuasa_ppat'] = $kuasaPpat;
        $json['data_kuasa'] = array(array($kuasaPpat, $kuasaMasyarakat));
        $json['data_bar'] = array($data_proses, $data_jatuh_tempo);
        $json['kabupaten'] = $data_kabupaten;
        $json['data_tertinggi'] = collect($data_tertinggi)->sortByDesc('total');

        return response()->json($json, 200);
    }

    //REUSABLE CURL AGAR TIDAK MENULISKAN CODE YANG SAMA BERULANG KALI
    private function getTelegram($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . $params); 

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        $content = curl_exec($ch);
        curl_close($ch);
        return json_decode($content, true);
    }

    private function sendMessage($chat_id, $reason)
    {
        $key = '1333535793:AAG9gCLM1YvbmKBNqtOP4yeJL2owiZ-qj0w'; //AMBIL TOKEN DARI ENV
        //KEMUDIAN KIRIM REQUEST KE TELEGRAM UNTUK MENGAMBIL DATA USER YANG ME-LISTEN BOT KITA
        $chat = $this->getTelegram('https://api.telegram.org/bot'. $key .'/getUpdates', '');
        //JIKA ADA
        // return $chat; die;
        if ($chat['ok']) {
            // dd($chat);
            //SAYA BERASUMSI PESAN INI HANYA DIKIRIM KE ADMIN, MAKA KITA TIDAK PERLU MELOOPING HASIL DARI GET DATA USER
            //CUKUP MENGAMBIL KEY 0 SAJA ATAU LIST YANG PERTAMA
            //UNTUK MENDAPATKAN CHAT_ID
            $chat_id = $chat_id;
            //TEKS YANG DIINGINKAN
            $text = "*Ada permohonan baru dengan* %0AKegiatan:";
        
            //DAN KIRIM REQUEST KE TELEGRAM UNTUK MENGIRIMKAN PESAN
            return $this->getTelegram('https://api.telegram.org/bot'. $key .'/sendMessage', '?chat_id=' . $chat_id . '&text=' . $text. '&parse_mode=markdown');
        }
    }
}
