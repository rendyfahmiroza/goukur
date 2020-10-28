<template>
<div class="container-fluid relative animatedParent animateOnce p-0">
    <div class="animated fadeInUpShort go">
        <div class="row no-gutters">
            <div class="col-md-12 b-l">
                <div class="m-md-3">
                    <div class="invoice white shadow">
                        <div class="p-5" v-if="loaded">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="font-weight-bold float-left">GO-UKUR.</h1>
                                    <div class="float-right">
                                        <h3 class="font-weight-bold">
                                            <span v-if="statusProses == 'baru'" class="badge amber accent-1 font-weight-500">Berkas Baru!</span>
                                            <span v-if="statusProses == 'selesai'" class="badge badge-success">Selesai</span>
                                            <span v-if="statusProses == 'proses'" class="badge badge-warning">Proses</span>
                                            <span v-if="statusProses == 'batal'" class="badge badge-danger">Batal</span>
                                            <span v-if="statusProses == 'tunda'" class="badge badge-warning">Berkas ini ditunda</span>
                                            <span v-if="statusProses == 'verifikasi'" class="badge badge-info text-white">Verifikasi Operator</span>
                                        </h3>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>

                            <!-- info row -->
                            <div class="row my-3 ">
                                <div class="col-sm-7">
                                    <span class="font-weight-bold">Data Pemohon:</span>
                                    <address>
                                        <strong>Nama: {{namaPemohon}}</strong><br>
                                        Kabupaten: {{kabupaten}}<br>
                                        Kecamatan: {{kecamatan}}<br>
                                        Desa: {{desa}}, {{alamat}}<br>
                                        Kuasa: <strong>{{kuasaBerkas}}</strong><br>
                                        <span v-if="boolPpat">Nama Kuasa PPAT: {{namaKuasa}}<br></span>
                                        <span>No Hp Kuasa: {{noHpKuasa}}<br></span>
                                    </address>
                                    <hr>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td style="width:100px" class="font-weight-normal">Surat Tugas:</td>
                                                <td><button @click="showSuratTugas" type="button" class="btn btn-outline-primary btn-xs">{{noSuratTugas}}</button></td>
                                            </tr>
                                            <tr>
                                                <td style="width:100px" class="font-weight-normal">Petugas:</td>
                                                <td>{{petugas}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <span class="font-weight-bold">File Ukur (.Dwg):</span>
                                    <ul class="mt-3 mailbox-attachments clearfix">
                                        <li>
                                            <div class="mailbox-attachment-info">
                                                <a href="#" class="mailbox-attachment-name"><i class="icon-paperclip"></i>
                                                    {{fileName}}</a>
                                                <button @click="downloadFile(fileName)" class="btn btn-outline-success btn-xs float-right r-3"><i class="icon-document-file-dwg"></i></button>
                                                <span class="mailbox-attachment-size">File Ukur
                                                </span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-5">
                                    <address>
                                    <strong class="text-info">Tanggal Pengukuran:</strong> {{tanggalPengukuran}}</br>
                                    <strong class="text-danger">Tanggal Jatuh Tempo:</strong> {{manTanggalPengukuran}}</br>
                                    </address>
                                    <p v-if="pembatalan != null" class="text-muted well well-sm no-shadow mt-3">
                                        <strong>Alasan Pembatalan: <h5 class="h5">{{pembatalan}}</h5></strong>
                                    </p>
                                    <p class="mt-3"><strong>Catatan perbaikan oleh operator:</strong></p>
                                    <ul v-if="verifikasi" class="timeline mt-1">
                                        <li v-for="(v, index) in verifikasi" :key="index">
                                            <i class="ion icon-user yellow"></i>
                                            <div class="timeline-item  card">
                                                <div class="card-header white">
                                                    <h6><a href="#">Catatan #{{index+1}}</a> {{v.catatan}}<span class="float-right"><i class="ion icon-clock-o"></i> {{v.tanggal}}</span></h6>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul v-if="verifikasi.length == 0" class="timeline mt-1">
                                        <li>
                                            <i class="ion icon-user yellow"></i>
                                            <div class="timeline-item  card">
                                                <div class="card-header white">
                                                    <h6>Belum ada Catatan oleh Operator<span class="float-right"><i class="ion icon-clock-o"></i> -</span></h6>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12" v-if="statusProses != 'batal' && statusProses != 'selesai'">
                                    <button v-if="$auth.user().hak_akses == 3" @click="$modal.show('selesaiModal')" type="button" class="btn btn-success btn-lg float-right"><i class="icon icon-upload"></i> Upload DWG
                                    </button>
                                    <button v-if="$auth.user().hak_akses == 3" @click="pembatalanModal" type="button" class="btn btn-danger btn-lg float-right mr-2"><i class="icon icon-close"></i> Batalkan
                                    </button>
                                    <!-- <button v-if="($auth.user().hak_akses == 1 || $auth.user().hak_akses == 2) && (statusProses != 'batal' && statusProses != 'tunda')" @click="konfirmasiBerkas('tunda')" type="button" class="btn btn-warning btn-lg  float-right mr-2"><i class="icon icon-schedule"></i> Tunda
                                    </button> -->
                                    <!-- <button v-if="($auth.user().hak_akses == 1 || $auth.user().hak_akses == 2) && statusProses == 'tunda'" @click="konfirmasiBerkas('proses')" type="button" class="btn btn-warning btn-lg  float-right mr-2"><i class="icon icon-schedule"></i> Proses Kembali
                                    </button> -->
                                </div>
                            </div>
                        </div>
                        <div class="active text-center p-5" v-else>
                            Loading ...
                        </div>
                    </div>
                </div>
                <div class="m-md-3" v-if="pdfView">
                    <embed :src="srcPdf" width="100%" height="700">
                </div>
            </div>
        </div>
    </div>
    <modal name="tundaModal" :adaptive="true">
        <div class="container-fluid pt-3">
            <h3 class="mb-4">Form Pembatalan</h3>
            <div class="row-clearfix">
                <div class="form-group">
                    <label for="exampleFormControlSelect4">Alasan Pembatalan:</label>
                    <select v-model="selectedPembatalan" class="form-control" id="exampleFormControlSelect4">
                        <option value="" selected>--PILIH--</option>
                        <option :value="item.id" v-for="(item, i) in itemsPembatalan" :key="i">{{item.pembatalan}}</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div v-if="selectedPembatalan == 'lainnya'">
                    <div class="form-group">
                        <div class="form-line">
                            <label class="form-label">Alasan Lain:</label>
                            <input type="text" v-model="alasan" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row-clearfix">
                    <button @click="pembatalanPostData" type="button" class="btn btn-block btn-primary btn-sm">Simpan Data</button>
                </div>
            </div>
        </div>
    </modal>
    <modal name="selesaiModal" :adaptive="true">
        <div class="container-fluid pt-3">
            <h3 class="mb-4">Form Selesai</h3>
            <div class="row-clearfix">
                <div>
                    <div class="form-group">
                        <div class="form-line">
                            <label class="form-label">File Upload (*DWG):</label>
                            <input type="file" ref="file" name="file" @change="selectFile" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row-clearfix">
                    <button @click="selesaiPostData" type="button" class="btn btn-block btn-primary btn-sm">Simpan Data</button>
                </div>
            </div>
        </div>
    </modal>
</div>
</template>

<script>
import mixin from '../../../mixins/generalMixin'

export default {
    data() {
        return {
            namaPemohon: '',
            nomorHak: '',
            tanggalPengukuran: '',
            manTanggalPengukuran: '',
            kegiatan: '',
            alamat: '',
            catatan: '',
            kuasaBerkas: '',
            suratTugas: '',
            namaKuasa: '',
            noHpKuasa: '',
            biayaTaktis: '',
            biayaProses: '',
            totalBiaya: '',
            noSuratTugas: '',
            statusProses: '',
            kabupaten: '',
            kecamatan: '',
            desa: '',
            petugas: '',
            fileName: '',
            pembatalan: '',
            srcPdf: '',
            pdfView: false,
            loaded: true,
            boolPpat: false,
            verifikasi: [],

            // Form
            itemsPembatalan: [],
            selectedPembatalan: '',
            alasan: '',
            file: []
        }
    },
    computed: {
        // 
    },
    methods: {
        selectFile(event) {
            // `files` is always an array because the file input may be in multiple mode
            this.file = this.$refs.file.files[0]
            // console.log(this.file)
        },
        pembatalanModal: function () {
            axios
                .get('/pembatalan')
                .then(res => {
                    // console.log(res)
                    this.itemsPembatalan = res.data
                })
            this.$modal.show('tundaModal')
        },
        pembatalanPostData: function () {
            let params = {
                pembatalan_id: this.selectedPembatalan,
                alasan: this.alasan
            }

            if (this.selectedPembatalan == "") {
                this.$notify({
                    group: 'notif',
                    title: 'Notifikasi',
                    type: 'danger',
                    text: 'Pilihan Pembatalan Masih Kosong!'
                });
            } else {
                axios.
                put('/pembatalan-berkas/' + this.id, params)
                    .then(res => {
                        if (res.status == 200) {
                            this.statusProses = 'batal'
                            this.$notify({
                                group: 'notif',
                                title: 'Notifikasi',
                                type: 'success',
                                text: 'Berhasil merubah status!'
                            });
                            this.$modal.hide('tundaModal')
                        }
                    })
            }
        },
        selesaiPostData: function () {
            const config = {
                headers: {
                    'Content-Type': "multipart/form-data; charset=utf-8; boundary=" + Math.random().toString().substr(2),
                }
            }

            // form data
            let formData = new FormData();
            formData.append('file', this.file);
            formData.append('data', 'test');

            if (this.file == "") {
                this.$notify({
                    group: 'notif',
                    title: 'Notifikasi',
                    type: 'danger',
                    text: 'File Upload Masih Kosong!'
                });
            } else {
                axios.
                post('/selesai-berkas/' + this.id, formData, config)
                    .then(res => {
                        if (res.status == 200) {
                            this.statusProses = 'selesai'
                            this.$notify({
                                group: 'notif',
                                title: 'Notifikasi',
                                type: 'success',
                                text: 'Berhasil menyelesaikan berkas!'
                            });
                            this.fileName = res.data.fileDwg
                            this.$modal.hide('selesaiModal')
                        }
                    })
            }
        },
        downloadFile: function (file) {
            axios.get('/download/' + file, {
                responseType: 'arraybuffer'
            }).then(res => {
                let blob = new Blob([res.data], {
                    type: 'application/*'
                })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = file
                link._target = 'blank'
                link.click();
            })
        },
        getData: function () {
            axios.
            get('/berkas/' + this.id)
                .then(res => {
                    console.log(res)
                    this.namaPemohon = res.data.nama_pemohon
                    this.nomorHak = res.data.nomor_hak
                    this.tanggalPengukuran = res.data.man_tanggal_pengukuran
                    this.manTanggalPengukuran = res.data.man_tanggal_pengukuran_berakhir
                    this.kegiatan = res.data.kegiatan_id
                    this.kabupaten = res.data.man_kabupaten_id
                    this.kecamatan = res.data.man_kecamatan_id
                    this.desa = res.data.man_desa_id
                    this.petugas = res.data.man_petugas_ukur
                    this.alamat = res.data.alamat
                    this.catatan = res.data.catatan
                    this.kuasaBerkas = res.data.kuasa_berkas
                    this.noHpKuasa = res.data.no_hp_kuasa
                    this.biayaTaktis = res.data.biaya_taktis
                    this.biayaProses = res.data.biaya_proses
                    this.totalBiaya = res.data.total_biaya
                    this.noSuratTugas = res.data.no_surat_tugas
                    this.statusProses = res.data.status_proses
                    this.pembatalan = res.data.batal
                    this.verifikasi = res.data.verifikasi
                    this.fileName = res.data.file

                    if (res.data.kuasa_berkas == 'ppat') {
                        this.boolPpat = true;
                        this.namaKuasa = res.data.nama_kuasa_ppat
                    } else {
                        this.boolPpat = false;
                    }
                })
        },
        konfirmasiBerkas: function (param) {
            this.statusProses = param
            console.log(param)
            let params = {
                status_proses: param
            }

            axios.
            put('/konfirmasi-berkas/' + this.id, params)
                .then(res => {
                    if (res.status == 200) {
                        // this.alert = true
                        // this.succ = true
                    }
                })
        },
        showSuratTugas: function() {
            axios.
                get('/berkas-surat-tugas/' + this.$route.params.id, {
                        responseType: 'blob'
                    })
                    .then(response => {
                        const url = window.URL.createObjectURL(new Blob([response.data], {
                            type: 'application/pdf'
                        }));
                        const link = document.createElement('a');
                        link.href = url;
                        link.setAttribute('download', 'remaining_fee.pdf'); //or any other extension
                        document.body.appendChild(link);
                        // link.click();
                        this.srcPdf = link
                        this.pdfView = true
                        this.loaded = true
                    })
        }
    },
    mounted() {
        this.id = this.$route.params.id
        this.getData()
    }
}
</script>
