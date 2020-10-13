<template>
<div class="container-fluid relative animatedParent animateOnce p-0">
    <div class="animated fadeInUpShort go">
        <div class="row my-3">
            <div class="col-md-10 offset-md-1 col-sm-12">
                <div v-if="alert" :class="['alert', succ == true ? 'alert-success' : 'alert-danger', 'alert-dismissible']" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    
                    <span v-if="succ">
                        <strong>Berhasil!</strong> Data berhasil disimpan.
                    </span>
                    <span v-else>
                         <strong>Gagal!</strong> Ada Kesalahan dalam penginputan data.
                    </span>
                </div>
                <form action="#">
                    <div class="card no-b">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group m-0">
                                        <label for="name" class="col-form-label s-12">Nama Pemohon</label>
                                        <input id="name" v-model="namaPemohon" placeholder="*Masukan Nama Pemohon" class="form-control r-0 light s-12 " type="text">
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6 m-0">
                                            <label for="cnic" class="col-form-label s-12">Nomor Hak</label>
                                            <input id="cnic" v-model="nomorHak" placeholder="Masukan Nomor Hak" class="form-control r-0 light s-12 date-picker" type="text">
                                        </div>
                                        <div class="form-group col-md-6 m-0">
                                            <label for="dob" class="col-form-label s-12">Tanggal Pengukuran</label>
                                            <div class="input-group">
                                                <input type="date"  v-model="tanggalPengukuran" class="form-control light s-12" />
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 m-0">
                                            <label for="dob" class="col-form-label s-12">Kegiatan</label>
                                            <select v-model="selectedKegiatan" class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref">
                                                <option value="" selected>--Pilih--</option>
                                                <option :value="item.id" v-for="(item, i) in itemsKegiatan" :key="i">{{item.kegiatan}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-3 offset-md-1">
                                    <input hidden id="file" name="file" />
                                    <div class="dropzone dropzone-file-area pt-4 pb-4" id="fileUpload">
                                        <div class="dz-default dz-message">
                                            <span>Drop A file size image of user</span>
                                            <div>You can also click to open file browser</div>
                                        </div>
                                    </div>
                                </div> -->

                            </div>

                            <div class="form-row mt-1">
                                <div class="form-group col-md-4 m-0">
                                    <label for="email" class="col-form-label s-12">Kecamatan</label>
                                    <select v-model="selectedKecamatan" class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref" @change="getDesa">
                                        <option value="" selected>--Pilih--</option>
                                        <option :value="item.id" v-for="(item, i) in itemsKecamatan" :key="i">{{item.nama}}</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4 m-0">
                                    <label for="email" class="col-form-label s-12">Desa</label>
                                    <select v-model="selectedDesa" class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref">
                                        <option value="" selected>--Pilih--</option><option :value="item.id" v-for="(item, i) in itemsDesa" :key="i">{{item.nama}}</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-12 m-0">
                                    <label for="email" class="col-form-label s-12">Petugas Ukur</label>
                                    <select v-model="selectedPetugas" class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref">
                                        <option value="" selected>--Pilih--</option><option :value="item.id" v-for="(item, i) in itemsPetugas" :key="i">{{item.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12 m-0">
                                    <label for="address" class="col-form-label s-12">Alamat</label>
                                    <input v-model="alamat" type="text" class="form-control r-0 light s-12" id="alamat" placeholder="Masukan Alamat">
                                </div>
                                <div class="form-group col-md-12 m-0">
                                    <label for="address" class="col-form-label s-12">Catatan</label>
                                    <textarea v-model="catatan" class="form-control r-0 light s-12" id="exampleFormControlTextarea2" rows="3" placeholder="Masukan Catatan"></textarea>
                                </div>
                                <div class="form-group col-md-12 m-0">
                                    <label for="email" class="col-form-label s-12">Kuasa Berkas</label>
                                    <select v-model="kuasaBerkas" class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref" @change="onChange($event)">
                                        <option value="" selected>--Pilih--</option>
                                        <option value="masyarakat">Masyarakat</option>
                                        <option value="ppat">PPAT</option>
                                    </select>
                                </div>
                                <div v-if="boolPpat" class="form-group col-md-12 m-0">
                                    <label for="email" class="col-form-label s-12">PPAT</label>
                                    <select v-model="selectedPpat" class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref">
                                        <option value="" selected>--Pilih--</option><option :value="item.id" v-for="(item, i) in itemsPpat" :key="i">{{item.name}}</option>
                                    </select>
                                </div>
                                <div v-if="boolPpat == false" class="form-group col-md-12 m-0">
                                    <label for="address" class="col-form-label s-12">No. HP Kuasa Berkas</label>
                                    <input v-model="noHpKuasa" type="text" class="form-control r-0 light s-12" id="alamat" placeholder="Masukan No. Telepon">
                                </div>
                                <div class="form-group col-md-6 m-0">
                                    <label for="address" class="col-form-label s-12">Biaya Taktis</label>
                                    <input v-model="biayaTaktis" type="number" class="form-control r-0 light s-12" id="alamat" placeholder="Masukan Biaya Taktis">
                                </div>
                                <div class="form-group col-md-6 m-0">
                                    <label for="address" class="col-form-label s-12">Biaya Proses</label>
                                    <input v-model="biayaProses" type="number" class="form-control r-0 light s-12" id="alamat" placeholder="Masukan Biaya Proses">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="card-body">
                            <button type="button" @click="postData" class="btn btn-primary btn-lg"><i class="icon-save mr-2"></i>Save Data</button>
                        </div>
                    </div>
                </form>
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
            catatan: '',
            kuasaBerkas: '',
            noHpKuasa: '',
            biayaTaktis: '',
            biayaProses: '',
            noSuratTugas: '',
            statusProses: '',

            succ: false, // Notifikasi jika berhasil
            alert: false,
            id : '',

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
        getKegiatan: function() {
            axios.
                get('/kegiatan')
                .then(response => {
                    this.itemsKegiatan = response.data
                })
        },
        getPetugas: function() {
            axios.
                get('/petugas_kab/' +this.selectedKabupaten)
                .then(response => {
                    this.itemsPetugas = response.data
                })
        },
        getPpat: function() {
            axios.
                get('/ppat_kab/' +this.selectedKabupaten)
                .then(response => {
                    this.itemsPpat = response.data
                })
        },
        getKabupaten: function() {
            axios.
                get('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=11')
                .then(response => {
                    this.itemsKabupaten = response.data.kota_kabupaten
                })
        },
        getKecamatan: function() {
            axios.
                get('https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota='+this.selectedKabupaten)
                .then(response => {
                    console.log()
                    this.itemsKecamatan = response.data.kecamatan
                })
            
            if (this.kuasaBerkas == 'ppat') {
                this.getPpat()
            }
        },
        getDesa: function() {
            axios.
                get('https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan='+this.selectedKecamatan)
                .then(response => {
                    console.log()
                    this.itemsDesa = response.data.kelurahan
                })
        },
        getData: function() {
            axios.
                get('/berkas/'+ this.id)
                .then(res => {
                    console.log(res)
                    this.namaPemohon = res.data.nama_pemohon
                    this.nomorHak = res.data.nomor_hak
                    this.tanggalPengukuran = res.data.tanggal_pengukuran
                    this.selectedKegiatan = res.data.kegiatan_id
                    this.selectedKabupaten = res.data.kabupaten_id
                    this.selectedKecamatan = res.data.kecamatan_id
                    this.selectedDesa = res.data.desa_id
                    this.selectedPetugas = res.data.petugas_ukur_id
                    this.alamat = res.data.alamat
                    this.catatan = res.data.catatan
                    this.kuasaBerkas = res.data.kuasa_berkas
                    this.selectedPpat = res.data.kuasa_ppat
                    this.noHpKuasa = res.data.no_hp_kuasa
                    this.biayaTaktis = res.data.biaya_taktis
                    this.biayaProses = res.data.biaya_proses
                    this.noSuratTugas = res.data.no_surat_tugas
                    this.statusProses = res.data.status_proses

                    this.getKecamatan()
                    this.getDesa()
                    this.getKegiatan()
                    this.getPetugas()
                    this.getPpat()

                    if (res.data.kuasa_berkas == 'ppat') {
                        this.boolPpat = 'true'
                    }
                })
        },
        postData: function() {
            console.log(this.tanggalPengukuran)
            let params = {
                nama_pemohon: this.namaPemohon,
                nomor_hak: this.nomorHak,
                tanggal_pengukuran: this.tanggalPengukuran,
                kegiatan_id: this.selectedKegiatan,
                kabupaten_id: this.selectedKabupaten,
                kecamatan_id: this.selectedKecamatan,
                desa_id: this.selectedDesa,
                petugas_ukur_id: this.selectedPetugas,
                alamat: this.alamat,
                catatan: this.catatan,
                kuasa_berkas: this.kuasaBerkas,
                kuasa_ppat: this.selectedPpat,
                no_hp_kuasa: this.noHpKuasa,
                biaya_taktis: this.biayaTaktis,
                biaya_proses: this.biayaProses,
                no_surat_tugas: this.noSuratTugas,
                status_proses: this.statusProses
            }

            axios.
                put('/berkas/' +this.id, params)
                .then(res => {
                    if (res.status == 200) {
                            this.alert = true
                            this.succ = true

                            this.$notify({
                                group: 'notif',
                                title: 'Notifikasi',
                                text: 'Data Berhasil Diperbaiki!'
                            });
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
                                text: 'Gagal Diperbaiki!'
                            });
                        }
                    })
        }
    },
    mounted() {
        this.id = this.$route.params.id
        this.selectedKabupaten = this.$auth.user().kantah
        this.getKecamatan()
        this.getData()
    }
}
</script>