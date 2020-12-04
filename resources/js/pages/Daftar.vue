<template>
<div class="container-fluid relative animatedParent animateOnce p-0">
    <notifications class="mt-5 mr-2" group="notif" position="top right" />
    <div class="animated fadeInUpShort go mt-5">
        <div class="col-md-8 offset-md-2 col-sm-12 my-2">
            <form v-if="!loadingPrint" action="#">
                <div class="card no-b">
                    <div class="card-body">
                        <h3>Berkas Mandiri</h3>
                        <hr>
                        <div class="form-row">
                            <div class="form-group col-md-4 m-0">
                                <label for="name" class="col-form-label s-12">Nama Pemohon</label>
                                <input id="name" v-model="namaPemohon" placeholder="*Masukan Nama Pemohon" class="form-control r-0 light s-12 " type="text">
                            </div>
                            <div class="form-group col-md-4 m-0">
                                <label for="cnic" class="col-form-label s-12">Nomor Hak</label>
                                <input id="cnic" v-model="nomorHak" placeholder="Masukan Nomor Hak" class="form-control r-0 light s-12 date-picker" type="text">
                            </div>
                            <div class="form-group col-md-4 m-0">
                                <label for="dob" class="col-form-label s-12">Kegiatan</label>
                                <select v-model="selectedKegiatan" class="custom-select mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref">
                                    <option value="" selected>--Pilih--</option>
                                    <option :value="item.id" v-for="(item, i) in itemsKegiatan" :key="i">{{item.kegiatan}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 m-0">
                                <label for="email" class="col-form-label s-12">Kecamatan</label>
                                <select v-model="selectedKecamatan" class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref" @change="getDesa">
                                    <option value="" selected>--Pilih--</option>
                                    <option :value="item.id" v-for="(item, i) in itemsKecamatan" :key="i">{{item.nama}}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6 m-0">
                                <label for="email" class="col-form-label s-12">Desa</label>
                                <select v-model="selectedDesa" class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref">
                                    <option value="" selected>--Pilih--</option>
                                    <option :value="item.id" v-for="(item, i) in itemsDesa" :key="i">{{item.nama}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12 m-0">
                                <label for="address" class="col-form-label s-12">Alamat</label>
                                <input v-model="alamat" type="text" class="form-control r-0 light s-12" id="alamat" placeholder="Masukan Alamat">
                            </div>
                            <div class="form-group col-md-12 m-0">
                                <label for="email" class="col-form-label s-12">Kuasa Berkas</label>
                                <select v-model="kuasaBerkas" class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref" @change="onChange($event)">
                                    <option value="" selected>--Pilih--</option>
                                    <option value="masyarakat">Masyarakat</option>
                                    <option value="ppat">PPAT</option>
                                </select>
                            </div>
                            <div v-if="boolPpat && kuasaBerkas != ''" class="form-group col-md-12 m-0">
                                <label for="email" class="col-form-label s-12">PPAT</label>
                                <select v-model="selectedPpat" class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref">
                                    <option value="" selected>--Pilih--</option>
                                    <option :value="item.id" v-for="(item, i) in itemsPpat" :key="i">{{item.name}}</option>
                                </select>
                            </div>
                            <div v-if="boolPpat == false  && kuasaBerkas != ''" class="form-group col-md-12 m-0">
                                <label for="address" class="col-form-label s-12">Nama Kuasa Berkas</label>
                                <input v-model="namaKuasa" type="text" class="form-control r-0 light s-12" id="alamat" placeholder="Masukan Nama">
                            </div>
                            <div v-if="boolPpat == false  && kuasaBerkas != ''" class="form-group col-md-12 m-0">
                                <label for="address" class="col-form-label s-12">No. HP Kuasa Berkas</label>
                                <input v-model="noHpKuasa" type="text" class="form-control r-0 light s-12" id="alamat" placeholder="Masukan No. Telepon">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="card-body pt-0" v-if="loadingPrint == false">
                        <button type="button" @click="postData" class="btn btn-primary btn-sm btn-block mt-0"><i class="icon-save mr-2"></i>Simpan Data dan Cetak Surat Tanda Terima</button>
                    </div>
                </div>
            </form>

            <!-- PDF VIEW -->
            <div class="m-md-3" v-if="pdfView">
                <embed :src="srcPdf" width="100%" height="700">
            </div>
            <div class="m-md-3" v-if="loadingPrint">
                <h3>Loading data print...</h3>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            namaPemohon: '',
            nomorHak: '',
            tanggalPengukuran: '',
            kegiatan: '',
            alamat: '',
            // catatan: '',
            kuasaBerkas: '',
            namaKuasa: '',
            noHpKuasa: '',
            // biayaTaktis: '',
            // biayaProses: '',

            succ: false, // Notifikasi jika berhasil
            alert: false,

            // Kabupaten
            itemsKabupaten: [],
            selectedKabupaten: '',

            // Kecamatan
            itemsKecamatan: [],
            selectedKecamatan: '',

            // Desa
            itemsDesa: [],
            selectedDesa: '',

            // Berkas
            itemsKegiatan: [],
            selectedKegiatan: '',

            // Petugas
            itemsPetugas: [],
            selectedPetugas: '',

            // PPAT
            itemsPpat: [],
            selectedPpat: '',
            boolPpat: false,
            boolSimpan: true,
            pdfView: false,
            loadingPrint: false
        }
    },
    methods: {
        onChange(event) {
            console.log(event.target.value)
            if (event.target.value == "ppat") {
                // Call petugas
                this.getPpat()
                this.boolPpat = true
            } else {
                this.boolPpat = false
            }
        },
        getKegiatan: function () {
            axios.
            get('/kegiatan')
                .then(response => {
                    this.itemsKegiatan = response.data
                })
        },
        getPetugas: function () {
            axios.
            get('/petugas_kab/' + this.selectedKabupaten)
                .then(response => {
                    this.itemsPetugas = response.data
                })
        },
        getPpat: function () {
            axios.
            get('/ppat_kab/' + this.selectedKabupaten)
                .then(response => {
                    this.itemsPpat = response.data
                })
        },
        getKecamatan: function () {
            axios.
            get('http://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota=' + this.selectedKabupaten)
                .then(response => {
                    console.log()
                    this.itemsKecamatan = response.data.kecamatan
                })
            // Call petugas
            this.getPetugas()
            if (this.kuasaBerkas == 'ppat') {
                this.getPpat()
            }
        },
        getDesa: function () {
            axios.
            get('http://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan=' + this.selectedKecamatan)
                .then(response => {
                    console.log()
                    this.itemsDesa = response.data.kelurahan
                })
        },
        postData: function () {
            this.loadingPrint = true

            let params = {
                nama_pemohon: this.namaPemohon,
                nomor_hak: this.nomorHak,
                kegiatan_id: this.selectedKegiatan,
                kabupaten_id: this.selectedKabupaten,
                kecamatan_id: this.selectedKecamatan,
                desa_id: this.selectedDesa,
                alamat: this.alamat,
                kuasa_berkas: this.kuasaBerkas,
                kuasa_ppat: this.selectedPpat,
                nama_kuasa: this.namaKuasa,
                no_hp_kuasa: this.noHpKuasa
            }

            if (this.namaPemohon == '' || this.selectedKegiatan == '' || this.selectedKabupaten == '' || this.selectedKecamatan == '' || this.selectedDesa == '' || this.alamat == '' || this.kuasaBerkas == '') {
                this.$notify({
                    group: 'notif',
                    title: 'Notifikasi',
                    type: 'danger',
                    text: 'Masih data yang belum terisi, mohon diperhatikan kembali!'
                });
                this.boolSimpan == false
                this.loadingPrint = false
            } else {
                this.boolSimpan == true
            }

            if (this.kuasaBerkas == 'masyarakat') {
                if (this.namaKuasa == '' || this.noHpKuasa == '') {
                    this.$notify({
                        group: 'notif',
                        title: 'Notifikasi',
                        type: 'danger',
                        text: 'Data kuasa berkas harus diisi!'
                    });
                    this.boolSimpan == false
                    this.loadingPrint = false
                } else {
                    this.boolSimpan == false
                }
            } else if (this.kuasaBerkas == 'ppat') {
                if (this.selectedPpat == '') {
                    this.$notify({
                        group: 'notif',
                        title: 'Notifikasi',
                        type: 'danger',
                        text: 'PPAT harus dipilih terlebih dahulu!'
                    });
                    this.boolSimpan == false
                    this.loadingPrint = false
                } else {
                    this.boolSimpan == true
                }
            }

            if (this.boolSimpan) {
                axios.
                post('/berkas-mandiri', params)
                    .then(res => {
                        if (res.status == 200) {
                            this.namaPemohon = ''
                            this.nomorHak = ''
                            this.alamat = ''
                            this.kuasaBerkas = ''
                            this.namaKuasa = ''
                            this.noHpKuasa = ''
                            this.selectedKabupaten = ''
                            this.selectedKecamatan = ''
                            this.selectedDesa = ''
                            this.selectedKegiatan = ''
                            this.selectedPpat = ''

                            this.$notify({
                                group: 'notif',
                                title: 'Notifikasi',
                                type: 'success',
                                text: 'Data Berhasil Disimpan!'
                            });

                            this.getBerkasPrint(res.data.last_insert_id);
                        }
                    })
                    .catch(err => {
                        console.log(err.response)
                        if (err.response.status == 500) {
                            this.alert = true
                            this.succ = false

                            this.$notify({
                                group: 'notif',
                                title: 'Notifikasi',
                                type: 'danger',
                                text: 'Gagal Disimpan!'
                            });
                        }
                    })
            }
        },
        getBerkasPrint: function (id) {
            axios.
            get('/berkas-mandiri-print/' + id, {
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
                    this.loadingPrint = false
                })
        }
    },
    mounted() {
        this.selectedKabupaten = this.$auth.user().kantah
        this.getKecamatan();
        this.getKegiatan();
    }
}
</script>
