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
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="">
                                                <label class="form-label">* Nama Kegiatan</label>
                                                <input v-model="namaKegiatan" type="text" class="form-control" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <label class="form-label">* Status Kegiatan</label>
                                            <select v-model="statusKegiatan" class="custom-select my-1 mr-sm-2 form-control r-0 light s-12" id="inlineFormCustomSelectPref" required>
                                                <option value="" selected>--Pilih--</option>
                                                <option value="active">Active</option>
                                                <option value="deactive">Deactive</option>
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
            namaKegiatan: '',
            statusKegiatan: '',
            succ: false, // Notifikasi jika berhasil
            alert: false,
        }
    },
    methods: {
        postData: function () {
            let params = {
                kegiatan: this.namaKegiatan,
                status: this.statusKegiatan
            }
            
            // Save data
            axios.
                post('/kegiatan', params)
                .then(res => {
                    console.log(res)
                    if (res.status == 200) {
                        this.alert = true
                        this.succ = true
                        this.namaKegiatan = ''
                        this.statusKegiatan = ''

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
}
</script>
