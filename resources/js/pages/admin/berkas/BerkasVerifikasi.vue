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
                                <div class="d-none d-lg-block"><span class="badge badge-success">File DWG: Download {{item.fileDwg}}</span>
                                </div>
                            </td>
                            <td align="left">
                                <router-link :to="{ name: 'detail-berkas', params: {id: item.id} }" class="btn-fab btn-fab-sm btn-warning shadow text-white mr-2"><i class="icon-eye"></i></router-link>
                                <a @click="verifikasiData(item.id, index)" href="#" class="btn-fab btn-fab-sm btn-success shadow text-white"><i class="icon-check"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
            itemsPetugas: [],
            tanggalPengukuran: '',
            selectedPetugasUkur: '',
            id: '',
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
