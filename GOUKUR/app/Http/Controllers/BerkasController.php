<?php

namespace App\Http\Controllers;

use App\Berkas;
use App\Kantor;
use App\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ixudra\Curl\Facades\Curl;

use PDF;

class BerkasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->exists('filterData')) {
            $berkas = Berkas::where('status_proses','=','proses')->get();
        } else {
            $berkas = Berkas::where('status_proses','<>','baru-mandiri')->get();
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

            if ($value->kuasa_berkas == 'ppat') {
                $item['type_kuasa'] = 'ppat';
                $item['nama_kuasa'] = $value->ppat->name;
                $item['no_hp_kuasa'] = $value->ppat->no_telepon;
            } else {
                $item['type_kuasa'] = 'masyarakat';
                $item['nama_kuasa'] = $value->nama_kuasa;
                $item['no_hp_kuasa'] = $value->no_hp_kuasa;
            }
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $berkas = new Berkas;
        $berkas->fill($request->all());
        $berkas->no_surat_tugas = 'ST/01/VIII/2020';
        $berkas->status_proses = 'baru';
        $berkas->save();

        // Notifikasi ke Petugas
        $notifikasi = new Notifikasi();
        $notifikasi->user_id = $berkas->petugas_ukur_id;
        $notifikasi->message = 'Ada pekerjaan baru';
        $notifikasi->action_user_id = Auth::user()->id;
        $notifikasi->action = 'Baru';
        $notifikasi->save();

        return response()->json($request, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_mandiri(Request $request)
    {
        $berkas = new Berkas;

        $berkas->nama_pemohon = $request->nama_pemohon;
        $berkas->kegiatan_id = $request->kegiatan_id;
        $berkas->nomor_hak = $request->nomor_hak;
        $berkas->kabupaten_id = $request->kabupaten_id;
        $berkas->kecamatan_id = $request->kecamatan_id;
        $berkas->desa_id = $request->desa_id;
        $berkas->kuasa_berkas = $request->kuasa_berkas;
        
        if ($request->kuasa_berkas == 'masyarakat') {
            $berkas->kuasa_ppat = NULL;
            $berkas->nama_kuasa = $request->nama_kuasa;
            $berkas->no_hp_kuasa = $request->no_hp_kuasa;
        } else {
            $berkas->kuasa_ppat = $request->kuasa_ppat;
            $berkas->nama_kuasa = NULL;
            $berkas->no_hp_kuasa = NULL;
        }

        $berkas->status_proses = 'baru-mandiri';
        $berkas->save();

        $response = Curl::to('https://dev.farizdotid.com/api/daerahindonesia/kelurahan/'.$berkas->desa_id)->asJsonResponse()->get();
        $berkas->desa = $response->nama;

        $response = Curl::to('https://dev.farizdotid.com/api/daerahindonesia/kecamatan/'.$berkas->kecamatan_id)->asJsonResponse()->get();
        $berkas->kecamatan = $response->nama;
        $berkas->kegiatan = $berkas->kegiatan->kegiatan;

        if ($berkas->kuasa_berkas == 'ppat') {
            $berkas->type_kuasa = 'PPAT';
            $berkas->nama_kuasa = $berkas->ppat->name;
            $berkas->nomor_hp_kuasa = $berkas->ppat->no_telepon;
        } else {
            $berkas->type_kuasa = 'Masyarakat';
            $berkas->nama_kuasa = $berkas->nama_kuasa;
            $berkas->nomor_hp_kuasa = $berkas->no_hp_kuasa;
        }

        $this->sendMessage('479255374', $berkas);

        return response()->json(array('success' => true, 'last_insert_id' => $berkas->id), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Berkas  $berkas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $berkas = Berkas::find($id);

        // Manipulasi Tanggal untuk mengetahui jatuh tempo
        $start_date = \Carbon\Carbon::now();
        $expired_date = \Carbon\Carbon::parse($berkas->tanggal_pengukuran);
        $result_date = $expired_date->addDays(7)->format('l, d F Y');
        
        $berkas->id = $berkas->id;
        $berkas->nama_pemohon = $berkas->nama_pemohon;
        $berkas->nomor_hak = $berkas->nomor_hak;
        $berkas->kabupaten_id = $berkas->kabupaten_id;
        $berkas->kecamatan_id = $berkas->kecamatan_id;
        $berkas->desa_id = $berkas->desa_id;
        $berkas->petugas_ukur_id = $berkas->petugas_ukur_id;
        $berkas->no_surat_tugas = $berkas->no_surat_tugas;
        $berkas->alamat = $berkas->alamat;
        $berkas->catatan = $berkas->catatan;
        $berkas->tanggal_pengukuran = $berkas->tanggal_pengukuran;
        $berkas->kuasa_berkas = $berkas->kuasa_berkas;
        $berkas->no_hp_kuasa = $berkas->no_hp_kuasa;
        $berkas->biaya_taktis = $berkas->biaya_taktis;
        $berkas->biaya_proses = $berkas->biaya_proses;
        $berkas->total_biaya = $berkas->biaya_taktis + $berkas->biaya_proses;
        $berkas->status_proses = $berkas->status_proses;
        $berkas->file = $berkas->fileDwg;

        // Pembatalan
        if ($berkas->pembatalan_id != NULL) {
            if ($berkas->pembatalan_id != 'lainnya') {
                $berkas->pembatalan = $berkas->pembatalan->pembatalan;
            } else {
                $berkas->pembatalan = $berkas->alasan;
            }
        }
        
        // Manipulasi Data
        $berkas->man_tanggal_pengukuran = \Carbon\Carbon::parse($berkas->tanggal_pengukuran)->format('l, d F Y');
        $response = Curl::to('https://dev.farizdotid.com/api/daerahindonesia/kota/'.$berkas->kabupaten_id)->asJsonResponse()->get();
        $berkas->man_kabupaten_id = $response->nama;
        $response = Curl::to('https://dev.farizdotid.com/api/daerahindonesia/kecamatan/'.$berkas->kecamatan_id)->asJsonResponse()->get();
        $berkas->man_kecamatan_id = $response->nama;
        $response = Curl::to('https://dev.farizdotid.com/api/daerahindonesia/kelurahan/'.$berkas->desa_id)->asJsonResponse()->get();
        $berkas->man_desa_id = $response->nama;
        $berkas->man_petugas_ukur = $berkas->pengguna->name;
        $berkas->man_tanggal_pengukuran_berakhir = $result_date;

        // Kuasa PPAT
        if ($berkas->kuasa_berkas == 'ppat') {
            $berkas->nama_kuasa_ppat = $berkas->ppat->name;
            $berkas->no_hp_kuasa = $berkas->ppat->no_telepon;
        }

        return response()->json($berkas, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Berkas  $berkas
     * @return \Illuminate\Http\Response
     */
    public function show_kab($id)
    {
        $berkas = Berkas::where('kabupaten_id', $id)->where('status_proses','<>','baru-mandiri')->get();
        
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
            $item['kabupaten_id'] = $value->kabupaten_id;
            $item['kecamatan_id'] = $value->kecamatan_id;
            $item['desa_id'] = $value->desa_id;
            $item['petugas_ukur_id'] = $value->pengguna->name;
            $item['alamat'] = $value->alamat;
            $item['catatan'] = $value->catatan;
            $item['tanggal_pengukuran'] = $result_date;
            if ($value->kuasa_berkas == 'ppat') {
                $item['type_kuasa'] = 'ppat';
                $item['nama_kuasa'] = $value->ppat->name;
                $item['no_hp_kuasa'] = $value->ppat->no_telepon;
            } else {
                $item['type_kuasa'] = 'masyarakat';
                $item['nama_kuasa'] = $value->nama_kuasa;
                $item['no_hp_kuasa'] = $value->no_hp_kuasa;
            }
            $item['biaya_taktis'] = $value->biaya_taktis;
            $item['biaya_proses'] = $value->biaya_proses;
            $item['status_proses'] = $value->status_proses;

            array_push($json, $item);
        }
        return response()->json($json, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function berkas_mandiri()
    {
        if (Auth::user()->hak_akses == '1') {
            $berkas = Berkas::where('status_proses','=','baru-mandiri')->get();
        } else {
            $berkas = Berkas::where('status_proses','=','baru-mandiri')->where('kabupaten_id','=',Auth::user()->kantah)->get();
        }

        $json = array();
        foreach ($berkas as $value) {
            $item = array();
            $item['id'] = $value->id;
            $item['nama_pemohon'] = $value->nama_pemohon;
            $item['nomor_hak'] = $value->nomor_hak;

            $item['kabupaten_id'] = $value->kabupaten_id;
            // $response = Curl::to('https://dev.farizdotid.com/api/daerahindonesia/kota/'.$value->kabupaten_id)->asJsonResponse()->get();
            // $item['kabupaten'] = $response->nama;
            // $response = Curl::to('https://dev.farizdotid.com/api/daerahindonesia/kecamatan/'.$value->kecamatan_id)->asJsonResponse()->get();
            // $item['kecamatan'] = $response->nama;
            // $response = Curl::to('https://dev.farizdotid.com/api/daerahindonesia/kelurahan/'.$value->desa_id)->asJsonResponse()->get();
            // $item['desa'] = $response->nama;

            $item['alamat'] = $value->alamat;
            $item['kuasa'] = $value->kuasa_berkas;
            $item['status_proses'] = $value->status_proses;
            $item['tanggal_input'] = \Carbon\Carbon::parse($value->created_at)->format('d F Y');

            array_push($json, $item);
        }

        return response()->json($json, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Berkas  $berkas
     * @return \Illuminate\Http\Response
     */
    public function berkas_surat_tugas($id)
    {
        // dd($id);
        $data = Berkas::where('id', $id)->first();
        // dd($data);
        $data->man_tanggal_pengukuran = \Carbon\Carbon::parse($data->tanggal_pengukuran)->format('l, d F Y');
        $data->man_tanggal_pengukuran_selesai = \Carbon\Carbon::parse($data->tanggal_pengukuran)->addDays(1)->format('l, d F Y');
    
        $response = Curl::to('https://dev.farizdotid.com/api/daerahindonesia/kelurahan/'.$data->desa_id)->asJsonResponse()->get();
        $data->man_desa = $response->nama;

        $response = Curl::to('https://dev.farizdotid.com/api/daerahindonesia/kecamatan/'.$data->kecamatan_id)->asJsonResponse()->get();
        $data->man_kecamatan = $response->nama;
        $data->nama_kantor = $data->kantor->nama;
        $data->nama_kasi = $data->kantor->kasi;
        $data->alamat_kantor = $data->kantor->alamat;
        $data->telp_kantor = $data->kantor->no_telepon;
        $data->ibukota = $data->kantor->ibukota;
        $data->biaya_taktis = "Rp " . number_format($data->biaya_taktis,2,',','.');
        $data->biaya_proses = "Rp " . number_format($data->biaya_proses,2,',','.');

        $pdf = PDF::loadView('template', compact('data'));
        return $pdf->stream();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Berkas  $berkas
     * @return \Illuminate\Http\Response
     */
    public function berkas_mandiri_print($id)
    {
        // dd($id);
        $data = Berkas::where('id', $id)->first();
    
        $response = Curl::to('https://dev.farizdotid.com/api/daerahindonesia/kelurahan/'.$data->desa_id)->asJsonResponse()->get();
        $data->man_desa = $response->nama;

        $response = Curl::to('https://dev.farizdotid.com/api/daerahindonesia/kecamatan/'.$data->kecamatan_id)->asJsonResponse()->get();
        $data->man_kecamatan = $response->nama;
        $data->nama_kantor = $data->kantor->nama;
        $data->alamat_kantor = $data->kantor->alamat;
        $data->telp_kantor = $data->kantor->no_telepon;
        $data->ibukota = $data->kantor->ibukota;
        $data->kegiatan = $data->kegiatan->kegiatan;

        if ($data->kuasa_berkas == 'ppat') {
            $data->nama_kuasa = $data->ppat->name;
            $data->nomor_hp_kuasa = $data->ppat->no_telepon;
        }

        $data->tanggal = \Carbon\Carbon::now()->format('l, d F Y');
        $pdf = PDF::loadView('berkasMandiri', compact('data'));
        return $pdf->stream();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Berkas  $berkas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $berkas->fill($request->all());
        // $berkas->save();
        $berkas = Berkas::find($id);
        $berkas->nama_pemohon = $request->nama_pemohon;
        $berkas->kegiatan_id = $request->kegiatan_id;
        $berkas->nomor_hak = $request->nomor_hak;
        $berkas->kabupaten_id = $request->kabupaten_id;
        $berkas->kecamatan_id = $request->kecamatan_id;
        $berkas->desa_id = $request->desa_id;
        $berkas->petugas_ukur_id = $request->petugas_ukur_id;
        $berkas->catatan = $request->catatan;
        $berkas->tanggal_pengukuran = $request->tanggal_pengukuran;
        $berkas->kuasa_berkas = $request->kuasa_berkas;
        
        if ($request->kuasa_berkas == 'masyarakat') {
            $berkas->kuasa_ppat = NULL;
            $berkas->nama_kuasa = $request->namaKuasa;
            $berkas->no_hp_kuasa = $request->noHpKuasa;
        } else {
            $berkas->kuasa_ppat = $request->kuasa_ppat;
            $berkas->nama_kuasa = NULL;
            $berkas->no_hp_kuasa = NULL;
        }

        $berkas->biaya_taktis = $request->biaya_taktis;
        $berkas->biaya_proses = $request->biaya_proses;
        $berkas->no_surat_tugas = $request->no_surat_tugas;
        $berkas->status_proses = $request->status_proses;
        $berkas->update();

        return response()->json($berkas, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Berkas  $berkas
     * @return \Illuminate\Http\Response
     */
    public function konfirmasi_berkas(Request $request, $id)
    {
        $berkas = Berkas::find($id);
        $berkas->status_proses = $request->status_proses;

        $userkey = 'e42bbc8eb418';
        $passkey = 'tdfaqbz0pw';
        $telepon = '082275750031';
        $message = 'Hi John Doe, have a nice day.';

        if ($request->status_proses == 'proses') {
            // $response = Curl::to('https://gsm.zenziva.net/api/sendsms/')
            // ->withData( 
            //     array( 
            //         'userkey' => $userkey,
            //         'passkey' => $passkey,
            //         'nohp' => $telepon,
            //         'pesan' => $message 
            //     )
            // )
            // ->asJsonResponse()->post();
            // Notifikasi ke Petugas
            $notifikasi = new Notifikasi();
            $notifikasi->user_id = $berkas->petugas_ukur_id;
            $notifikasi->message = 'Status pekerjaan sedang diproses';
            $notifikasi->action_user_id = Auth::user()->id;
            $notifikasi->action = 'Proses';
            $notifikasi->status = '1';
            $notifikasi->save();
        }

        $berkas->update();
        return response()->json($berkas, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Berkas  $berkas
     * @return \Illuminate\Http\Response
     */
    public function penugasan(Request $request, $id)
    {
        $arrBulanRomawi = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
        $month = \Carbon\Carbon::parse($request->tanggal_pengukuran)->month;
        $month = $arrBulanRomawi[$month - 1];

        $berkas = Berkas::find($id);
        $berkas->status_proses = 'proses';
        $berkas->petugas_ukur_id = $request->petugas_ukur_id;
        $berkas->tanggal_pengukuran = $request->tanggal_pengukuran;
        $berkas->no_surat_tugas = 'ST/'.$id.'/'.$month.'/2020';

        $berkas->update();

        $response = Curl::to('https://dev.farizdotid.com/api/daerahindonesia/kelurahan/'.$berkas->desa_id)->asJsonResponse()->get();
        $berkas->desa = $response->nama;

        $response = Curl::to('https://dev.farizdotid.com/api/daerahindonesia/kecamatan/'.$berkas->kecamatan_id)->asJsonResponse()->get();
        $berkas->kecamatan = $response->nama;
        $berkas->kegiatan = $berkas->kegiatan->kegiatan;

        if ($berkas->kuasa_berkas == 'ppat') {
            $berkas->type_kuasa = 'PPAT';
            $berkas->nama_kuasa = $berkas->ppat->name;
            $berkas->nomor_hp_kuasa = $berkas->ppat->no_telepon;
        } else {
            $berkas->type_kuasa = 'Masyarakat';
            $berkas->nama_kuasa = $berkas->nama_kuasa;
            $berkas->nomor_hp_kuasa = $berkas->no_hp_kuasa;
        }

        $this->sendMessage('479255374', $berkas);
        return response()->json($berkas, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Berkas  $berkas
     * @return \Illuminate\Http\Response
     */
    public function pembatalan_berkas(Request $request, $id)
    {
        $berkas = Berkas::find($id);
        $berkas->pembatalan_id = $request->pembatalan_id;
        $berkas->alasan = $request->alasan;
        $berkas->status_proses = 'batal';
        $berkas->update();
        return response()->json($berkas, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Berkas  $berkas
     * @return \Illuminate\Http\Response
     */
    public function selesai_berkas(Request $request, $id)
    {
        $berkas = Berkas::find($id);
        // dd($request->file);
        $fileName = time().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('upload'), $fileName);

        $berkas->fileDwg = $fileName;
        $berkas->status_proses = 'selesai';
        $berkas->update();
        return response()->json($berkas, 200);

        // var_dump($request->file->getClientOriginalExtension());die;
            // $file = $request->file('file');
            // $filename = time() . '.' . $file->extension();
            // //MENYIMPAN FILE KE DALAM FOLDER PUBLIC (note: sesuai disk dari filesystem)
            // //DALAM HAL INI KE storage_path
            // $file->storeAs(
            //     'public', $filename
            // );
            // return response()->json(request()->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Berkas  $berkas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $berkas = Berkas::find($id);
        $berkas->delete();
        return response()->json($berkas, 200);
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

    private function sendMessage($chat_id, $data)
    {
        $key = 'bot1333535793:AAG9gCLM1YvbmKBNqtOP4yeJL2owiZ-qj0w'; //AMBIL TOKEN DARI ENV
        //KEMUDIAN KIRIM REQUEST KE TELEGRAM UNTUK MENGAMBIL DATA USER YANG ME-LISTEN BOT KITA
        $chat = $this->getTelegram('https://api.telegram.org/'. $key .'/getUpdates', '');
        //JIKA ADA
        if ($chat['ok']) {
            //SAYA BERASUMSI PESAN INI HANYA DIKIRIM KE ADMIN, MAKA KITA TIDAK PERLU MELOOPING HASIL DARI GET DATA USER
            //CUKUP MENGAMBIL KEY 0 SAJA ATAU LIST YANG PERTAMA
            //UNTUK MENDAPATKAN CHAT_ID
            $chat_id = $chat_id;
            //TEKS YANG DIINGINKAN
            $text = "*Ada permohonan baru dengan:* %0A*Kegiatan*: ". $data->kegiatan ." %0A*Nama Pemohon*: ". $data->nama_pemohon ." %0A*Kecamatan*: " . $data->kecamatan . " %0A*Desa*: ". $data->desa . " %0A*Kuasa Berkas*: ". $data->type_kuasa . " %0A*Nama Kuasa*: ". $data->nama_kuasa ." %0A*Nomor Telepon*: ". $data->nomor_hp_kuasa." %0A_Untuk dapat segera ditindaklanjuti_.";
        
            //DAN KIRIM REQUEST KE TELEGRAM UNTUK MENGIRIMKAN PESAN
            return $this->getTelegram('https://api.telegram.org/'. $key .'/sendMessage', '?chat_id=' . $chat_id . '&text=' . $text. '&parse_mode=markdown');
        }
    }
}
