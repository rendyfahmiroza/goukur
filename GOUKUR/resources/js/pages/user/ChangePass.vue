<template>
<div class="animatedParent animateOnce">
    <div class="container-fluid animated fadeInUpShort go my-3">
        <div class="row">
            <div class="col-md-12">
                <div v-if="alert" :class="['alert', succ == true ? 'alert-success' : 'alert-danger', 'alert-dismissible']" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    
                    <span v-if="succ">
                        <strong>Berhasil!</strong> Data berhasil disimpan.
                    </span>
                    <span v-else>
                         <strong>Gagal!</strong> Ada Kesalahan dalam penginputan password lama.
                    </span>
                </div>
                <div class="card">
                    <div class="card-body b-b">
                        <!-- <h4>Tambah Data Berkas</h4> -->
                        <form class="">
                            <!-- Input -->
                            <div class="body mt-1 pt-2">
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="">
                                                <label class="form-label">* Password Lama</label>
                                                <input type="password"   v-model="passwordLama" class="form-control">
                                            </div>
                                            <div class="mt-3">
                                                <label class="form-label">* Password Baru</label>
                                                <input type="password" v-model="passwordBaru" class="form-control">
                                            </div>
                                            <div class="mt-3">
                                                <label class="form-label">* Re-Password Baru</label>
                                                <input type="password" v-model="passwordMatch " class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix form-material">
                                    <div class="col-sm-12">
                                        <button @click="postData" type="button" class="btn btn-block btn-primary btn-sm">Simpan Data</button>
                                    </div>
                                </div>
                            </div>
                            <!-- #END# Input -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            passwordLama: '',
            passwordBaru: '',
            passwordMatch: '',
            succ: false, // Notifikasi jika berhasil
            alert: false,
        }
    },
    methods: {
        postData: function () {
            //  Check Password Lama
            if (this.passwordBaru != this.passwordMatch ) {
                this.$notify({
                    group: 'notif',
                    title: 'Notifikasi',
                    type: 'danger',
                    text: 'Password Tidak Sama!'
                });
            } else {
                let params = {
                    passwordLama: this.passwordLama,
                    passwordBaru: this.passwordBaru
                }
                // Save data
                axios.
                    put('/change-pass', params)
                    .then(res => {
                        console.log(res)
                        if (res.status == 200) {
                            this.alert = true
                            this.succ = true
                            this.namaKegiatan = ''
                            this.statusKegiatan = ''
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
            
        }
    }
}
</script>
