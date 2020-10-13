<template>
<div class="container-fluid animatedParent animateOnce p-0">
    <div class="animated fadeInUpShort go row d-flex bd-highlight no-gutters">
        <div class="flex-fill b-l height-full white">
            <div class="table-responsive" v-if="listPetugas.length > 0">
                <table class="table table-striped table-hover r-0 mt-5">
                    <tbody>
                        <tr v-for="(item, index) in listPetugas" :key="index">
                            <td width="70%" class="pl-md-5">
                                <div class="avatar avatar-md mr-3 mt-1 float-left">
                                    <img class="w-80px mb-4" src="/goukur/img/dummy/u1.png" alt="">
                                </div>
                                <div>
                                    <div>
                                        <small>Nama Petugas:</small> <br/>
                                        <strong class="h6">{{item.name}}</strong>
                                    </div>
                                </div>
                            </td>
                            <td align="right" class="pl-md-5">
                                <div>
                                    <div>
                                        <small><span class="avatar-badge busy"></span><i class="icon-circle text-red mr-2"></i> Jatuh Tempo: </small> 
                                        <strong class="h6">{{item.jatuh_tempo}} Berkas</strong>
                                    </div>
                                    <div>
                                        <small><i class="icon-circle text-yellow mr-2"></i> Proses: </small> 
                                        <strong class="h6">{{item.proses}} Berkas</strong>
                                    </div>
                                </div>
                            </td>
                            <td align="right" class="mr-3 pr-5">
                                <!-- <router-link :to="{ name:'detail-daftar-petugas', params: {id: item.id}}" class="btn-fab btn-fab-sm btn-warning shadow text-white mr-5"><i class="icon-eye"></i></router-link> -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-center p-5 bd-highlight justify-content-center align-items-center" style="position: absolute; top: 50%; left: 50%;transform: translate(-50%, -60%);" v-else>
                <i class="icon-note-important s-128 text-danger"></i>
                <h3 class="mt-3">Belum Ada Data!</h3>
                <p class="h6 mb-3">Untuk melihat data disini, anda harus menambahkan berkas baru</p>
                <router-link :to="{ name: 'tambah-petugas' }" class="btn btn-primary shadow btn-lg"><i class="icon-plus-circle mr-2 "></i>Tambah Data</router-link>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            listPetugas: ''
        }
    },
    methods: {
        firstLetter(word) {
            let str = word.split("")
            return 'avatar-letter-'+ str[0].toLowerCase()
        },
        deleteData(id, index) {
            if(confirm("Do you really want to delete?")){
                axios.delete('/petugas/' +id)
                .then(resp => {
                    this.listPetugas.splice(index, 1);

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
        }
    },
    mounted() {
        axios.
            get('/petugas')
            .then(res => {
                // console.log(res)
                this.listPetugas = res.data
            })
            .catch(err => {
                console.log(err.response)
            })
    }
}
</script>
