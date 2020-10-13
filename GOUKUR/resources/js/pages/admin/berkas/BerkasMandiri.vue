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
                            <td align="right">
                                <small>Tanggal Daftar:</small> <br>
                                {{item.tanggal_input}}
                            </td>
                            <td  align="right" class="pl-md-5 text-right">
                                <div>
                                    <div>
                                        <strong>{{item.kabupaten}}</strong>
                                    </div>
                                    <small class="d-none d-md-block">{{item.kecamatan}}, {{item.desa}}
                                    </small>
                                </div>
                            </td>
                            <td align="right">
                                <button @click="penugasanModal(item.id, item.kabupaten_id, index)" class="btn-fab btn-fab-sm btn-success shadow text-white mr-2"><i class="icon-check"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <modal name="tundaModal" :adaptive="true">
        <div class="container-fluid pt-3">
            <h3 class="mb-4">Form Penugasan</h3>
            <div class="row-clearfix">
                <div class="form-group">
                    <label for="exampleFormControlSelect4">Petugas Ukur:</label>
                    <select v-model="selectedPetugasUkur" class="form-control" id="exampleFormControlSelect4">
                        <option value="" selected>--PILIH--</option>
                        <option :value="item.id" v-for="(item, i) in itemsPetugas" :key="i">{{item.name}}</option>
                    </select>
                </div>
                <div>
                    <div class="form-group">
                        <div class="form-line">
                            <label class="form-label">Tanggal Pengukuran:</label>
                            <input type="date" v-model="tanggalPengukuran" class="form-control light s-12" />
                        </div>
                    </div>
                </div>
                <div class="row-clearfix">
                    <button @click="penugasanPostData" v-if="penugasanBool" type="button" class="btn btn-block btn-primary btn-sm">Simpan Data</button>
                    <p v-else>Loading Simpan...</p>
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
            id: '',
            index: '',
            penugasanBool: true,
        }
    },
    methods: {
        penugasanModal: function(id, kabupaten_id, index) {
            this.index = index
            this.id = id
            axios.
            get('/petugas_kab/' + kabupaten_id)
                .then(response => {
                    this.itemsPetugas = response.data
                })
            this.$modal.show('tundaModal')
        },
        penugasanPostData: function () {
            let params = {
                petugas_ukur_id: this.selectedPetugasUkur,
                tanggal_pengukuran: this.tanggalPengukuran
            }

            if (this.selectedPetugasUkur == "" || this.tanggalPengukuran == '') {
                this.$notify({
                    group: 'notif',
                    title: 'Notifikasi',
                    type: 'danger',
                    text: 'Data Form Masih Kosong!'
                });
            } else {
                this.penugasanBool = false
                axios.
                put('/penugasan/' + this.id, params)
                    .then(res => {
                        if (res.status == 200) {
                            this.$notify({
                                group: 'notif',
                                title: 'Notifikasi',
                                type: 'success',
                                text: 'Berhasil menyimpan data'
                            });
                            this.itemsBerkas.splice(this.index, 1)
                            this.$modal.hide('tundaModal')
                            this.penugasanBool = true
                        }
                    })
            }
        }
    },
    mounted() {
        axios.
        get('/berkas-mandiri')
            .then(response => {
                // console.log(response)
                this.itemsBerkas = response.data
            })
            .catch(err => {

            })
    }
}
</script>
