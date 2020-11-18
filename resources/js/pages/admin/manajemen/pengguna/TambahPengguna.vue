<template>
<div class="animatedParent animateOnce">
    <div class="container-fluid my-3">
        <div class="row">
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
                <div class="card">
                    <div class="card-body b-b">
                        <!-- <h4>Tambah Data Berkas</h4> -->
                        <form class="">
                            <!-- Input -->
                            <div class="body mt-1 pt-2">
                                <div class="row clearfix ">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label class="form-label">* Nama</label>
                                                <input v-model="name" type="text" class="form-control" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">* Username</label>
                                                <input v-model="email" type="text" class="form-control" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">* Password</label>
                                                <input v-model="password" type="password" class="form-control" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">* Re-Password</label>
                                                <input v-model="repassword" type="password" class="form-control" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">* Kabupaten</label>
                                            <select v-model="kantah" class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref">
                                                <option value="" selected>--Pilih--</option>
                                                <option :value="item.id" v-for="(item, i) in itemsKabupaten" :key="i">{{item.nama}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">* No Telepon</label>
                                                <input v-model="no_telepon" type="text" class="form-control" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">* Telegram ID</label>
                                                <input v-model="telegram_id" type="text" class="form-control" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label class="form-label">* Status</label>
                                            <select v-model="status" class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref" required>
                                                <option value="" selected>--Pilih--</option>
                                                <option value="active">Active</option>
                                                <option value="deactive">Deactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label class="form-label">* Hak Akses</label>
                                            <select v-model="hak_akses" class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref" required>
                                                <option value="" selected>--Pilih--</option>
                                                <option value="1">Admin Kanwil</option>
                                                <option value="2">Verifikator Kantah</option>
                                                <option value="3">Operator Kantah</option>
                                            </select>
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
            name: '',
            email: '',
            password: '',
            repassword: '',
            kantah: '',
            no_telepon: '',
            telegram_id: '',
            status: '',
            hak_akses: '',
            succ: false, // Notifikasi jika berhasil
            alert: false,

            itemsKabupaten: [],
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
        postData: function () {
            if (this.password != this.repassword) {
                alert('Password tidak sama!, silahkan diperbaiki')
            } else {
                let params = {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    kantah: this.kantah,
                    hak_akses: this.hak_akses,
                    no_telepon: this.no_telepon,
                    telegram_id: this.telegram_id,
                    status: this.status
                }
                
                // Save data
                axios.
                    post('/pengguna', params)
                    .then(res => {
                        console.log(res)
                        if (res.status == 200) {
                            this.alert = true
                            this.succ = true
                            this.name = ''
                            this.email = ''
                            this.password = ''
                            this.repassword = ''
                            this.kantah = ''
                            this.no_telepon = ''
                            this.telegram_id = ''
                            this.status = ''
                            this.hak_akses = ''

                            this.$notify({
                                group: 'notif',
                                title: 'Notifikasi',
                                text: 'Data Berhasil Disimpan!'
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
        }
    },
    mounted() {
        this.getKabupaten()
    }
}
</script>
