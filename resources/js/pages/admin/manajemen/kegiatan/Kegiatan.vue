<template>
<div class="container-fluid animatedParent animateOnce p-0">
    <div class="animated fadeInUpShort go row d-flex bd-highlight no-gutters">
        <div class="flex-fill b-l height-full white">
            <div class="table-responsive" v-if="listKegiatan.length > 0">
                <table class="table table-striped table-hover r-0 mt-5">
                    <tbody>
                        <tr v-for="(item, index) in listKegiatan" :key="index">
                            <td class="pl-md-5">
                                <div>
                                    <div>
                                        <small>Nama Kegiatan:</small> <br/>
                                        <strong class="h6">{{item.kegiatan}}</strong>
                                    </div>
                                </div>
                            </td>
                            <td align="right">
                                <router-link :to="{ name:'perbaiki-kegiatan', params: {id: item.id}}" class="btn-fab btn-fab-sm btn-primary shadow text-white mr-2"><i class="icon-pencil"></i></router-link>
                                <a @click="deleteData(item.id, index)" href="#" class="btn-fab btn-fab-sm btn-danger shadow text-white mr-5"><i class="icon-close"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-center p-5 bd-highlight justify-content-center align-items-center" style="position: absolute; top: 50%; left: 50%;transform: translate(-50%, -60%);" v-else>
                <i class="icon-note-important s-128 text-danger"></i>
                <h3 class="mt-3">Belum Ada Data!</h3>
                <p class="h6 mb-3">Untuk melihat data disini, anda harus menambahkan berkas baru</p>
                <router-link :to="{ name: 'tambah-kegiatan' }" class="btn btn-primary shadow btn-lg"><i class="icon-plus-circle mr-2 "></i>Tambah Data</router-link>
            </div>
        </div>
    </div>

    <!--Add New Message Fab Button-->
    <router-link :to="{ name: 'tambah-kegiatan' }" class="btn-fab btn-fab-md fab-right fab-right-bottom-fixed shadow btn-primary"><i class="icon-add"></i></router-link>
</div>
</template>

<script>
export default {
    data() {
        return {
            listKegiatan: ''
        }
    },
    methods: {
        firstLetter(word) {
            let str = word.split("")
            return 'avatar-letter-'+ str[0].toLowerCase()
        },
        deleteData(id, index) {
            if(confirm("Do you really want to delete?")){
                axios.delete('/kegiatan/' +id)
                .then(resp => {
                    this.listKegiatan.splice(index, 1);

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
            get('/kegiatan')
            .then(res => {
                // console.log(res)
                this.listKegiatan = res.data
            })
            .catch(err => {
                console.log(err.response)
            })
    }
}
</script>
