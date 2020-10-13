<template>
<div class="container-fluid relative p-0">
    <div class="row d-flex bd-highlight no-gutters">
        <div class="flex-fill b-l height-full white">
            <div class="table-responsive">
                <table class="table table-striped table-hover r-0">
                    <thead>
                        <tr class="no-b">
                            <th>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle r-3 pr-3 pl-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Filter Status
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a @click="filterStatus('proses')" class="dropdown-item" href="#"><i class="icon icon-circle text-yellow mr-2"></i> Proses</a>
                                        <a @click="filterStatus('jatuh-tempo')" class="dropdown-item" href="#"><i class="icon icon-circle text-red mr-2"></i> Jatuh Tempo</a>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in itemsBerkas" :key="index" :class="{ 'red lighten-3' : item.tanggal_pengukuran <= 0 && item.status_proses == 'proses' }">
                            <td class="pl-md-5">
                                <div class="avatar avatar-md mr-3 mt-1 float-left">
                                    <img class="w-80px mb-4" :src="item.type_kuasa == 'ppat' ? '/goukur/img/dummy/u4.png' : '/goukur/img/dummy/u2.png'" alt="">
                                </div>
                                <div>
                                    <div>
                                        <strong>{{item.nama_pemohon}}</strong>
                                    </div>
                                    <small class="d-none d-md-block">Kuasa: {{item.kuasa_berkas}} | No. Telepon: {{item.no_hp_kuasa}} | Alamat: {{item.alamat}}
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
                            <td align="right">
                                <router-link :to="{ name:'perbaiki-berkas-operator', params: {id: item.id}}" v-if="item.status_proses != 'batal' && item.status_proses != 'selesai'" class="btn-fab btn-fab-sm btn-primary shadow text-white mr-3"><i class="icon-pencil"></i></router-link>
                                <router-link :to="{ name: 'detail-berkas', params: {id: item.id} }" class="btn-fab btn-fab-sm btn-warning shadow text-white mr-3"><i class="icon-eye"></i></router-link>
                                <a @click="deleteData(item.id, index)" href="#" v-if="item.status_proses != 'batal' && item.status_proses != 'selesai'" class="btn-fab btn-fab-sm btn-danger shadow text-white mr-3"><i class="icon-close"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--Add New Message Fab Button-->
    <router-link :to="{ name: 'tambah-berkas-operator' }" class="btn-fab btn-fab-md fab-right fab-right-bottom-fixed shadow btn-primary"><i class="icon-add"></i></router-link>
</div>
</template>

<script>
export default {
    data() {
        return {
            itemsBerkas: []
        }
    },
    methods: {
        deleteData(id, index) {
            if(confirm("Do you really want to delete?")){
                axios.delete('/berkas/' +id)
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
            get('/berkas-operator', {params: {filterData: param}})
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
        get('/berkas-operator')
            .then(response => {
                // console.log(response)
                this.itemsBerkas = response.data
            })
            .catch(err => {

            })
    }
}
</script>
