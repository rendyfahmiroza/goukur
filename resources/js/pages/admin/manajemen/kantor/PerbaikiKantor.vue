<template>
<div class="container-fluid relative animatedParent animateOnce p-0">
    <div class="animated fadeInUpShort go">
        <div class="row my-3">
            <div class="col-md-8 offset-md-2">
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
                            <div class="form-row" v-if="$auth.user().hak_akses == 1">
                                <div class="form-group col-md-12 m-0">
                                    <label for="email" class="col-form-label s-12">Kabupaten</label>
                                    <select v-model="selectedKabupaten" class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref" @change="getKecamatan">
                                        <option value="" selected>--Pilih--</option>
                                        <option :value="item.id" v-for="(item, i) in itemsKabupaten" :key="i">{{item.nama}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group m-0">
                                        <label for="name" class="col-form-label s-12">Nama Kantor</label>
                                        <input id="name" v-model="nama" placeholder="*Masukan Nama Kantor" class="form-control r-0 light s-12 " type="text">
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-12 m-0">
                                            <label for="cnic" class="col-form-label s-12">Kepala Kantor</label>
                                            <input id="cnic" v-model="kepala_kantor" placeholder="Masukan Nama Kepala Kantor" class="form-control r-0 light s-12 date-picker" type="text">
                                        </div>
                                        <div class="form-group col-md-6 m-0">
                                            <label for="cnic" class="col-form-label s-12">Kepala Seksi</label>
                                            <input id="cnic" v-model="kasi" placeholder="Masukan Nama Kepala Seksi" class="form-control r-0 light s-12 date-picker" type="text">
                                        </div>
                                        <div class="form-group col-md-6 m-0">
                                            <label for="cnic" class="col-form-label s-12">NIP Kepala Seksi</label>
                                            <input id="cnic" v-model="nip_kasi" placeholder="Masukan NIP Kepala Seksi" class="form-control r-0 light s-12 date-picker" type="text">
                                        </div>
                                        <div class="form-group col-md-12 m-0">
                                            <label for="cnic" class="col-form-label s-12">Alamat Kantor</label>
                                            <input id="cnic" v-model="alamat" placeholder="Masukan Alamat Kantor" class="form-control r-0 light s-12 date-picker" type="text">
                                        </div>
                                        <div class="form-group col-md-6 m-0">
                                            <label for="cnic" class="col-form-label s-12">No Telepon</label>
                                            <input id="cnic" v-model="no_telepon" placeholder="Masukan No Telepon" class="form-control r-0 light s-12 date-picker" type="text">
                                        </div>
                                        <div class="form-group col-md-6 m-0">
                                            <label for="cnic" class="col-form-label s-12">Ibu Kota</label>
                                            <input id="cnic" v-model="ibukota" placeholder="Masukan Ibu Kota" class="form-control r-0 light s-12 date-picker" type="text">
                                        </div>
                                    </div>
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
            nama: '',
            kepala_kantor: '',
            kasi: '',
            nip_kasi: '',
            alamat: '',
            no_telepon: '',
            ibukota: '',

            succ: false, // Notifikasi jika berhasil
            alert: false,

            // Kabupaten
            itemsKabupaten: [],
            selectedKabupaten: '',
            id: '',
        }   
    },
    methods: {
        getKabupaten: function() {
            axios.
                get('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=11')
                .then(response => {
                    this.itemsKabupaten = response.data.kota_kabupaten
                })
        },
        getData: function () {
            // Get data
            axios.
                get('/kantor/'+ this.id)
                .then(res => {
                    this.selectedKabupaten = res.data.kabupaten_id
                    this.nama = res.data.nama
                    this.kepala_kantor = res.data.kepala_kantor
                    this.kasi = res.data.kasi
                    this.nip_kasi = res.data.nip_kasi
                    this.alamat = res.data.alamat
                    this.no_telepon = res.data.no_telepon
                    this.ibukota = res.data.ibukota
                })
        },
        postData: function() {
            let params = {
                kabupaten_id: this.$auth.user().hak_akses == 1 ? this.selectedKabupaten : this.$auth.user().kantah,
                nama: this.nama,
                kepala_kantor: this.kepala_kantor,
                kasi: this.kasi,
                nip_kasi: this.nip_kasi,
                alamat: this.alamat,
                no_telepon: this.no_telepon,
                ibukota: this.ibukota,
            }

            axios.
                put('/kantor/' +this.id, params)
                .then(res => {
                    if (res.status == 200) {
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
                    }
                })
        }
    },
    mounted() {
        this.id = this.$route.params.id;
        this.getKabupaten();
        this.getData();
    }
}
</script>