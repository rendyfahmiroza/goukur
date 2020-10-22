<template>
<div class="container-fluid relative p-0">
    <div class="row d-flex bd-highlight no-gutters">
        <div class="flex-fill b-l height-full white">
            <div class="table-responsive">
                <table class="table table-striped table-hover r-0 mt-5">
                    <tbody>
                        <tr v-for="(item, index) in itemsBerkas" :key="index">
                            <td class="pl-md-5">
                                <div class="avatar avatar-md mr-3 mt-1 float-left">
                                    <img class="w-80px mb-4" src="/goukur/img/dummy/u1.png" alt="">
                                </div>
                                <div>
                                    <div>
                                        <strong>{{item.nama_pemohon}}</strong>
                                    </div>
                                    <small class="d-none d-md-block">Kuasa: {{item.kuasa}}
                                    </small>
                                </div>
                            </td>
                            <td align="right" class="pl-md-5 text-right">
                                <div>
                                    <div>
                                        <strong>{{item.kabupaten}}</strong>
                                    </div>
                                    <small class="d-none d-md-block">{{item.kecamatan}}, {{item.desa}}
                                    </small>
                                </div>
                            </td>
                            <td align="right">
                                <div class="d-none d-lg-block "><a  href="#" class="badge badge-success" role="button" @click="downloadFile(item.fileDwg)">File DWG: Download {{item.fileDwg}}</a>
                                </div>
                            </td>
                            <td align="left">
                                <router-link :to="{ name: 'detail-berkas', params: {id: item.id} }" class="btn-fab btn-fab-sm btn-warning shadow text-white mr-2"><i class="icon-eye"></i></router-link>
                                <a @click="verifikasiData(item.id, index)" href="#" class="btn-fab btn-fab-sm btn-success shadow text-white mr-2"><i class="icon-check"></i></a>
                                <a @click="modalVerifikasi(item.id, item.history_user_id, index)" href="#" class="btn-fab btn-fab-sm btn-danger shadow text-white"><i class="icon-close"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <modal name="verifikasiModal" :scrollable="true" :height='220'>
        <div class="container-fluid pt-3">
            <h3 class="mb-4">Form Perbaikan Kegiatan</h3>
            <div class="row-clearfix">
                <div class="form-group">
                    <label for="exampleFormControlSelect4">Catatan Perbaikan:</label>
                    <textarea class="form-control" v-model="catatanPerbaikan"></textarea>
                </div>
                <div class="row-clearfix">
                    <button @click="verifikasiPostData" type="button" class="btn btn-block btn-primary btn-sm">Simpan Data</button>
                </div>
            </div>
        </div>
    </modal>
</div>
</template>

<script>
export default {
    data() {
        return {
            itemsBerkas: [],
            itemsPetugas: [],
            tanggalPengukuran: '',
            selectedPetugasUkur: '',
            catatanPerbaikan: '',
            id: '',
            history_user_id: '',
            index: '',
        }
    },
    methods: {
        verifikasiData(id, index) {
            if(confirm("Do you really want to verification?")){
                axios.put('/verifikasi/' +id)
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
        modalVerifikasi(id, history_user_id, index) {
            this.id = id
            this.history_user_id = history_user_id
            this.index = index

            this.$modal.show('verifikasiModal')
        },
        verifikasiPostData() {
            let params = {
                berkas_id: this.id,
                history_user_id: this.history_user_id,
                catatan: this.catatanPerbaikan
            }

            if (this.catatanPerbaikan == "") {
                this.$notify({
                    group: 'notif',
                    title: 'Notifikasi',
                    type: 'danger',
                    text: 'Catatan Masih Kosong!'
                });
            } else {
                axios.
                post('/perbaikan-verifikasi/' + this.id, params)
                    .then(res => {
                        if (res.status == 200) {
                            this.$notify({
                                group: 'notif',
                                title: 'Notifikasi',
                                type: 'success',
                                text: 'Berhasil menyimpan data'
                            });
                            this.itemsBerkas.splice(this.index, 1);
                            this.$modal.hide('verifikasiModal')
                        }
                    })
            }
        },
        downloadFile(file) {
            axios.get('/download/' +file, {responseType: 'blob'})
            .then(resp => {
                var fileURL = window.URL.createObjectURL(new Blob([resp.data]));
                var fileLink = document.createElement('a');

                fileLink.href = fileURL;
                fileLink.setAttribute('download', 'file.pdf');
                document.body.appendChild(fileLink);

                fileLink.click();
            })  
            .catch(error => {
                console.log(error);
            })
        },
    },
    mounted() {
        axios.
        get('/berkas-verifikasi')
            .then(response => {
                this.itemsBerkas = response.data
            })
    }
}
</script>
