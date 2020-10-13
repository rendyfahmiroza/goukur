
<div>
    <table width='100%'>
        <tr>
            <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Logo_BPN-KemenATR_%282017%29.png" style="width: 90px; position: absolute; top: -10px; left: -10px" alt="">
            <td style="font-size: 14pt; font-weight: bold; text-align: center ">
                KEMENTERIAN AGRARIA DAN TATA RUANG/<br />
                BADAN PERTANAHAN NASIONAL<br />
                <span style="text-transform: uppercase">{{$data->nama_kantor}}</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center; border-bottom: 1px solid #000; font-size: 10pt ">
                JL. {{$data->alamat_kantor}}- Telp. (0651) {{$data->telp_kantor}}
            </td>
        </tr>
    </table>
    <br />
    <table width='100%'>
        <tr>
            <td style="text-align:center"><b>SURAT TUGAS PENGUKURAN</b></td>
        </tr>
        <tr>
            <td style="text-align: center; font-size: 10pt">
                Nomor : {{$data->no_surat_tugas}}
            </td>
        </tr>
    </table>
    <br />
    <br />

    <div class="kolom-01">
        Dengan ini Kepala Kantor menugaskan kepada:
    </div>
    <div class="kolom-01">
        1.&nbsp;&nbsp;&nbsp;a. Petugas Ukur
        <div class="kolom-02">
        </div>
    </div>

    <div class="kolom-02">
        <table width='100%'>
            <tr>
                <td colspan="3">
                    <table border="1" width='100%' style="border-collapse: collapse">
                        <thead>
                            <tr>
                                <td class="text-center">No.</td>
                                <td class="text-center">Nama / NIP</td>
                                <td class="text-center">Pangkat / Golongan</td>
                                <td class="text-center">Jabatan</td>
                            </tr>
                        </thead>
                        <tr>
                            <td class="text-align-top text-center">1.</td>
                            <td class="text-align-top">{{$data->pengguna->name}}<br/> NIP. {{$data->pengguna->nip}}</td>
                            <td class="text-align-middle">{{$data->pengguna->golongan}}</td>
                            <td class="text-align-middle">Petugas Ukur</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table>
        <tr>
            <td class="text-align-top">b.</td>
            <td class="text-align-top scol-01">Dengan tugas</td>
            <td class="text-align-top" colspan="3">: Untuk melaksanakan Pengukuran dan Pemetaan kegiatan</td>
        </tr>
        </table>
    </div>

    <div class="kolom-01">
        2. Lokasi dan Volume Kegiatan :
    </div>
    <div class="kolom-02">
        <table>
            <tr>
                <td>a.</td>
                <td class="scol-01">Kelurahan</td>
                <td>:</td>
                <td>{{$data->man_desa}}</td>
            </tr>
            <tr>
                <td>b.</td>
                <td>Kecamatan</td>
                <td>:</td>
                <td>{{$data->man_kecamatan}}</td>
            </tr>
            <tr>
                <td>c.</td>
                <td>Volume</td>
                <td>:</td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; m<sup>2</sup>
                </td>
            </tr>
        </table>
    </div>
    <div class="kolom-01">
        3. Waktu :
    </div>
    <div class="kolom-02">
        <table>
            <tr>
                <td>a.</td>
                <td class="scol-01">Mulai Tanggal</td>
                <td>:</td>
                <td>{{$data->man_tanggal_pengukuran}}</td>
            </tr>
            <tr>
                <td>b.</td>
                <td>Sampai Tanggal</td>
                <td>:</td>
                <td>{{$data->man_tanggal_pengukuran_selesai}}</td>
            </tr>
        </table>
    </div>
    <div class="kolom-01">
        4. Biaya dibebankan pada :
    </div>
    <div class="kolom-02">
        <table>
            <tr>
                <td>a.</td>
                <td class="scol-01">DI 305</td>
                <td>:</td>
                <td></td>
            </tr>
            <tr>
                <td>b.</td>
                <td>DI 302</td>
                <td>:</td>
                <td></td>
            </tr>
        </table>
    </div>
    <div class="kolom-01">
        5. Hasil Tugas Supaya Dilaporkan
    </div>

    <div class="kolom-01 text-justify">
        <br />
        Demikian Surat Tugas ini dibuat untuk dilaksanakan dengan penuh tanggung jawab dan dipergunakan sebagaimana mestinya.
    </div>
    <br />
    <br />
    <table width="100%" style="" border="0">
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td width="15%">Dikeluarkan di</td>
            <td width="1">:</td>
            <td width="30%">{{$data->ibukota}}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td>Pada Tanggal</td>
            <td>:</td>
            <td>{{$data->man_tanggal_pengukuran}}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="3" style="text-align:center; border-bottom: 1px solid #000 ">

            </td>
        </tr>
        <tr>
            <td colspan="3" valign='top'>
                <small>
                    Bahwa benar Petugas Ukur telah datang <br />
                    ke lokasi<br />
                    Pada tanggal : {{$data->man_tanggal_pengukuran}}
                </small>
            </td>
            <td colspan="3" style="text-align:center">
                Atas Nama Kepala Kantor Pertanahan
                Kantor Pertanahan {{$data->nama_kantor}} <br>
                Kepala Seksi Infrastruktur Pertanahan
            </td>
        </tr>
        <tr>
            <td colspan="6" style="height: 100px;">

            </td>
        </tr>
        <tr>
            <td colspan="3" valign='top'>
                <small>
                    Mengetahui<br />
                    Nama Pemohon : 
                </small>
            </td>
            <td colspan="3" style="text-align:center">
                {{$data->nama_kasi}}
                <hr />
                NIP. 
            </td>
        </tr>
    </table>
</div>

<style>
table>thead>tr>td {
    text-align: center
}

.scol-01 {
    width: 3cm
}

.kolom-02 {
    width: 100%;
    border: 0px solid gray;
    font-size: 10pt;
    margin-left: 0.5cm;
}

.kolom-01 {
    width: 100%;
    border: 0px solid gray;
    font-size: 10pt;
}

.text-justify {
    text-align: justify;
    text-justify: inter-word;
}

.text-center {
    text-align: center
}

table {
    font-size: 10pt;
}

.text-align-top {
    vertical-align: top
}

.text-align-middle {
    vertical-align: middle;
    text-align: center;
}
</style>
