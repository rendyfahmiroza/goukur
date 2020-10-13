<template>
<div class="animatedParent animateOnce">
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body b-b">
                        <!-- <h4>Tambah Data Berkas</h4> -->
                        <form class="">
                            <!-- Input -->
                            <div class="body mt-1 pt-2">
                                <div class="row clearfix form-material">
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" />
                                                <label class="form-label">* Nama Pemohon</label>
                                            </div>
                                        </div>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" />
                                                <label class="form-label">Nomor Hak</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-clearfix">
                                    <div class="form-group">
                                        <label for="">Kegiatan</label>
                                        <select class="form-control" id="">
                                            <option>--PILIH--</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect4">Kecamatan</label>
                                        <select class="form-control">
                                            <option>--PILIH--</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect4">Desa</label>
                                        <select class="form-control" id="exampleFormControlSelect4">
                                            <option>--PILIH--</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect4">Petugas Ukur</label>
                                        <select class="form-control" id="exampleFormControlSelect4">
                                            <option>--PILIH--</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect4">Tanggal Pengukuran</label>
                                        <div class="input-group">
                                            <input type="text" class="date-time-picker form-control" data-options='{"timepicker":false, "format":"d-m-Y"}' value="2018/06/01" />
                                            <span class="input-group-append">
                                                <span class="input-group-text add-on white">
                                                    <i class="icon-calendar"></i>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-clearfix form-material">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <textarea class="form-control r-0" id="exampleFormControlTextarea2" rows="3"></textarea>
                                            <label class="form-label">Catatan Tambahan</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-clearfix">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect4">Kuasa Berkas</label>
                                        <select class="form-control" id="exampleFormControlSelect4">
                                            <option>--PILIH--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row clearfix form-material">
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" />
                                                <label class="form-label">* Nomor Hp Kuasa</label>
                                            </div>
                                        </div>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" />
                                                <label class="form-label">* Biaya Taktis</label>
                                            </div>
                                        </div>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" />
                                                <label class="form-label">* Biaya Proses</label>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-block btn-primary btn-sm">Simpan Berkas</button>
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

}
</script>
