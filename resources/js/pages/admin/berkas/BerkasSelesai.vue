<template>
<div class="container-fluid relative animatedParent animateOnce p-0">
    <div class="animated fadeInUpShort go row d-flex bd-highlight no-gutters">
        <div class="flex-fill b-l height-full white">
            <div class="table-responsive mt-3" v-if="itemsBerkas.length > 0">
                <table class="table table-striped table-hover r-0">
                    <tbody>
                        <tr v-for="(item, index) in itemsBerkas" :key="index" :class="{ 'red lighten-3' : item.tanggal_pengukuran <= 0 && item.status_proses == 'proses' }">
                            <td class="pl-md-5">
                                <div class="avatar avatar-md mr-3 mt-1 float-left">
                                    <img class="w-80px mb-4" :src="item.type_kuasa == 'ppat' ? '/goukur/img/dummy/u4.png' : '/goukur/img/dummy/u2.png'" alt="">
                                </div>
                                <div>
                                    <div>
                                        <strong>Pemohon: {{item.nama_pemohon}}</strong>
                                    </div>
                                    <small class="d-none d-md-block"><a  href="#" class="badge badge-success" role="button" @click="downloadFile(item.fileDwg)">File DWG: Download {{item.fileDwg}}</a>
                                    </small>
                                </div>
                            </td>
                            <td align="right">
                                <span v-if="item.status_proses == 'selesai'">
                                    <span class="icon icon-circle s-12  mr-2 text-success"></span> Selesai
                                </span>
                                <span v-if="item.status_proses == 'proses'">
                                    <span class="icon icon-circle s-12  mr-2 text-warning"></span> Proses
                                </span>
                                <span v-if="item.status_proses == 'batal'">
                                    <span class="icon icon-circle s-12  mr-2 text-danger"></span> Batal
                                </span>
                                <span class="badge-pill badge-success s-12  ml-2" v-if="item.status_proses != 'batal' && item.status_proses != 'selesai'"> {{ item.tanggal_pengukuran }} Hari</span>
                            </td>
                            <td>
                                <router-link :to="{ name:'perbaiki-berkas', params: {id: item.id}}" v-if="item.status_proses != 'batal' && item.status_proses != 'selesai'" class="btn-fab btn-fab-sm btn-primary shadow text-white mr-2"><i class="icon-pencil"></i></router-link>
                                <router-link :to="{ name: 'detail-berkas', params: {id: item.id} }" class="btn-fab btn-fab-sm btn-warning shadow text-white mr-2"><i class="icon-eye"></i></router-link>
                                <a @click="deleteData(item.id, index)" href="#" v-if="item.status_proses != 'batal' && item.status_proses != 'selesai'" class="btn-fab btn-fab-sm btn-danger shadow text-white"><i class="icon-close"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-center p-5 bd-highlight justify-content-center align-items-center" style="position: absolute; top: 50%; left: 50%;transform: translate(-50%, -50%);" v-else>
                <i class="icon-note-important s-128 text-danger"></i>
                <h3 class="mt-3">Belum Ada Berkas!</h3>
                <p class="h6">Untuk melihat data disini, anda harus menambahkan berkas baru</p>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            itemsBerkas: [],

            // Kabupaten
            itemsKabupaten: [],
            clickIndex: ''
        }
    },
    methods: {
        getKabupaten: function () {
            axios.
            get('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=11')
                .then(response => {
                    this.itemsKabupaten = response.data.kota_kabupaten
                })
        },
        getData: function (event) {
            // Reset
            console.log(event.target.value)
            this.itemsBerkas = []
            axios.
            get('/berkas_kab/' + event.target.value)
                .then(response => {
                    this.itemsBerkas = response.data
                })
        },
        deleteData(id, index) {
            if (confirm("Do you really want to delete?")) {
                axios.delete('/berkas/' + id)
                    .then(resp => {
                        this.itemsBerkas.splice(index, 1);
                        this.$notify({
                            group: 'notif',
                            title: 'Notifikasi',
                            text: 'Data Berhasil Dihapus!'
                        });
                    })
                    .catch(error => {
                        console.log(error);
                    })
            }
        },
        filterStatus(param) {
            axios.
            get('/berkas-selesai', {
                    params: {
                        filterData: param
                    }
                })
                .then(response => {
                    // console.log(response)
                    this.itemsBerkas = response.data
                })
                .catch(err => {

                })
        }
    },
    mounted() {
        axios.
        get('/berkas-selesai')
            .then(response => {
                // console.log(response)
                this.itemsBerkas = response.data
            })
            .catch(err => {

            })
        this.getKabupaten();
    }
}
</script>
