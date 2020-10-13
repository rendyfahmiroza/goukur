
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
            <td style="text-align:center"><b>SURAT TANDA TERIMA</b></td>
        </tr>
    </table>
    <br />
    <br />

    <div class="kolom-01">
        Telah diterima oleh:
    </div>
    <div class="kolom-01">
        1. Identitas :
    </div>
    <div class="kolom-02">
        <table width="100%">
            <tr width="100%">
                <td>a.</td>
                <td width="30%">Nama Pemohon</td>
                <td width="1%">:</td>
                <td width="100%" style="border-bottom: 1px dotted #333">{{$data->nama_pemohon}}</td>
            </tr>
            <tr width="100%">
                <td>a.</td>
                <td width="30%">Kegiatan</td>
                <td width="1%">:</td>
                <td width="100%" style="border-bottom: 1px dotted #333">{{$data->kegiatan}}</td>
            </tr>
        </table>
    </div>
    <br>

    <div class="kolom-01">
        2. Lokasi Kegiatan :
    </div>
    <div class="kolom-02">
        <table width="100%">
            <tr width="100%">
                <td>a.</td>
                <td width="30%">Kelurahan</td>
                <td width="1%">:</td>
                <td width="100%" style="border-bottom: 1px dotted #333">{{$data->man_desa}}</td>
            </tr>
            <tr>
                <td>b.</td>
                <td width="30%">Kecamatan</td>
                <td width="1%">:</td>
                <td width="100%" style="border-bottom: 1px dotted #333">{{$data->man_kecamatan}}</td>
            </tr>
        </table>
    </div>
    <br>

    <div class="kolom-01">
        3. Kuasa Berkas :
    </div>
    <div class="kolom-02">
        <table width="100%">
            <tr width="100%">
                <td width="1%">a.</td>
                <td width="30%">Nama Kuasa</td>
                <td width="1%">:</td>
                <td width="100%" style="border-bottom: 1px dotted #333">{{$data->nama_kuasa}}</td>
            </tr>
            <tr>
                <td width="1%">b.</td>
                <td width="30%">Nomor Handphone</td>
                <td width="1%">:</td>
                <td width="100%" style="border-bottom: 1px dotted #333">{{$data->no_hp_kuasa}}</td>
            </tr>
        </table>
    </div>
    <br>
    <div class="kolom-01">
        Pemberitahuan selanjutnya untuk survey dan pengukuran oleh petugas ukur akan segera di informasikan melalui nomor ponsel anda, maka untuk tetap mengaktifkan nomor ponsel anda.
    </div>


    <br><br><br>
    <table width="100%" style="" border="0">
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td width="15%">Dikeluarkan di</td>
            <td width="1">:</td>
            <td width="15%">{{$data->ibukota}}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td width="15%">Tanggal</td>
            <td width="1">:</td>
            <td width="25%">{{$data->tanggal}}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="3" style="text-align:center; border-bottom: 1px dotted #000 ">
            </td>
        </tr>
        <tr>
            <td colspan="3" valign='top'>
                
            </td>
            <td colspan="3" style="text-align:center">
                Diketahui Petugas <br><br><br><br><br><br>
                (_______________________)
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
</style>
