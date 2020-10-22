<template>
<div>
    <div id="app">
        <aside class="main-sidebar fixed offcanvas b-r sidebar-tabs" data-toggle='offcanvas' :style="{ width: $auth.user().hak_akses == 1 || $auth.user().hak_akses == 2 ? '330px' : '60px' }">
            <div class="sidebar">
                <div class="d-flex hv-100 align-items-stretch">
                    <div class="teal accent-4 text-white">
                        <div class="nav mt-5 pt-5 flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <!-- ROLE: 1 -->
                            <div v-if="$auth.user().hak_akses == 1">
                                <router-link class="nav-link" to="/dashboard"><i class="icon-dashboard"></i></router-link>
                            </div>

                            <!-- ROLE: 2 -->
                            <div v-if="$auth.user().hak_akses == 2">
                                <router-link class="nav-link" to="/dashboard-operator"><i class="icon-dashboard"></i></router-link>
                                <router-link class="nav-link" :to="{ name: 'berkas-operator' }"><i class="icon-message"></i></router-link>
                            </div>

                            <!-- ROLE: 1 AND 2 -->
                            <div v-if="$auth.user().hak_akses == 1 || $auth.user().hak_akses == 2">
                                <a class="nav-link" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="icon-kitchen"></i></a>
                                <router-link class="nav-link" to="/daftar-petugas"><i class="icon-people_outline"></i></router-link>
                            </div>

                            <!-- ROLE: 3 -->
                            <div v-if="$auth.user().hak_akses == 3">
                                <router-link class="nav-link" to="/dashboard-petugas"><i class="icon-dashboard"></i></router-link>
                                <router-link class="nav-link" :to="{ name: 'berkas-petugas' }"><i class="icon-message"></i></router-link>
                            </div>

                            <!-- ROLE: 4 -->
                            <div v-if="$auth.user().hak_akses == 4">
                                <router-link class="nav-link" :to="{ name: 'berkas-ppat' }"><i class="icon-message"></i></router-link>
                            </div>

                            <!-- <a class="nav-link" id="v-pills-settings-tab" href="#"><i class="icon-settings"></i></a> -->
                            <a href="">
                                <figure class="avatar">
                                    <img src="/goukur/img/dummy/u1.png" alt="">
                                    <span class="avatar-badge online"></span>
                                </figure>
                            </a>
                        </div>
                    </div>
                    <div v-if="$auth.user().hak_akses == 1 || $auth.user().hak_akses == 2" class="tab-content flex-grow-1" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="relative brand-wrapper sticky b-b">
                                <div class="d-flex justify-content-between align-items-center p-3">
                                    <div class="text-center">
                                        <span class="font-weight-bold text-center s-18"><i class="icon-map-marker mr-3"></i> GO-UKUR BPN ACEH.</span>
                                    </div>
                                </div>
                            </div>
                            <ul class="sidebar-menu">
                                <li v-if="$auth.user().hak_akses == 1">
                                    <router-link :to="{ name: 'berkas-baru' }">
                                        <i class="icon icon icon-fiber_new s-24"></i>
                                        <span>Berkas Baru</span>
                                        <!-- <span class="badge r-3 badge-primary pull-right">4</span> -->
                                    </router-link>
                                </li>
                                <li v-if="$auth.user().hak_akses == 1">
                                    <router-link :to="{ name: 'berkas-proses' }">
                                        <i class="icon icon icon-package s-24"></i>
                                        <span>Berkas Proses</span>
                                        <!-- <span class="badge r-3 badge-primary pull-right">4</span> -->
                                    </router-link>
                                </li>
                                <li v-if="$auth.user().hak_akses == 1">
                                    <router-link :to="{ name: 'berkas-tertunda' }">
                                        <i class="icon icon icon-sync_problem s-24"></i>
                                        <span>Berkas Tertunda</span>
                                        <!-- <span class="badge r-3 badge-primary pull-right">4</span> -->
                                    </router-link>
                                </li>
                                <li v-if="$auth.user().hak_akses == 1">
                                    <router-link :to="{ name: 'berkas-verifikasi' }">
                                        <i class="icon icon icon-check s-24"></i>
                                        <span>Berkas Verifikasi</span>
                                        <!-- <span class="badge r-3 badge-primary pull-right">4</span> -->
                                    </router-link>
                                </li>
                                <li v-if="$auth.user().hak_akses == 1">
                                    <router-link :to="{ name: 'berkas-selesai' }">
                                        <i class="icon icon icon-note-checked s-24"></i>
                                        <span>Berkas Selesai</span>
                                        <!-- <span class="badge r-3 badge-primary pull-right">4</span> -->
                                    </router-link>
                                </li>
                                <li v-if="$auth.user().hak_akses == 1">
                                    <router-link :to="{ name: 'berkas-batal' }">
                                        <i class="icon icon icon-note-checked s-24"></i>
                                        <span>Berkas Batal</span>
                                        <!-- <span class="badge r-3 badge-primary pull-right">4</span> -->
                                    </router-link>
                                </li>
                                <li class="treeview"><a href="#" class="">
                                        <i class="icon icon icon-settings s-24"></i>
                                        <span>Manajemen</span>
                                        <!-- <span class="badge r-3 badge-primary pull-right">4</span> -->
                                    </a>
                                    <ul class="treeview-menu active">
                                    <li v-if="$auth.user().hak_akses == 1"><router-link :to="{ name: 'kegiatan' }"><i class="icon icon-circle-o"></i>Kegiatan</router-link>
                                    </li>
                                    <li><router-link :to="{ name: 'ppat' }"><i class="icon icon-circle-o"></i>PPAT</router-link>
                                    </li>
                                    <li><router-link :to="{ name: 'petugas' }"><i class="icon icon-circle-o"></i>Petugas Ukur</router-link>
                                    </li>
                                    <li v-if="$auth.user().hak_akses == 1"><router-link :to="{ name: 'pengguna' }"><i class="icon icon-circle-o"></i>Pengguna</router-link>
                                    </li>
                                    <li><router-link :to="{ name: 'kantor' }"><i class="icon icon-circle-o"></i>Kantor Pertanahan</router-link>
                                    </li>
                                    <li v-if="$auth.user().hak_akses == 1"><router-link :to="{ name: 'pembatalan' }"><i class="icon icon-circle-o"></i>Pembatalan</router-link>
                                    </li></ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <a href="#" data-toggle="push-menu" class="paper-nav-toggle left ml-2 fixed">
            <i></i>
        </a>
        <div class="has-sidebar-left has-sidebar-tabs">
            <!--navbar-->
            <div class="sticky">
                <div class="navbar navbar-expand d-flex justify-content-between bd-navbar white shadow">
                    <div class="relative">
                        <div class="d-flex">
                            <div class="d-none d-md-block">
                                <h1 class="nav-title" style="text-transform:capitalize;">{{currentRouteName}}</h1>
                            </div>
                        </div>
                    </div>
                    <!--Top Menu Start -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages-->
                            <!-- User Account-->
                            <li class="dropdown custom-dropdown user user-menu ">
                                <a href="#" class="nav-link" data-toggle="dropdown">
                                    <i class="icon-more_vert "></i>
                                </a>
                                <div class="dropdown-menu p-4 dropdown-menu-right">
                                    <div class="row box justify-content-between my-4">
                                        <div class="col">
                                            <router-link :to="{ name: 'ubah-profil' }">
                                                <i class="icon-beach_access pink lighten-1 avatar  r-5"></i>
                                                <div class="pt-1">Profile</div>
                                            </router-link>
                                        </div>
                                        <div class="col">
                                            <router-link :to="{ name: 'ubah-password' }">
                                                <i class="icon-perm_data_setting indigo lighten-2 avatar  r-5"></i>
                                                <div class="pt-1">Settings</div>
                                            </router-link>
                                        </div>
                                        <div class="col">
                                            <a @click="logout" href="#">
                                                <i class="icon-close purple lighten-2 avatar r-5"></i>
                                                <div class="pt-1">Logout</div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- <div class="container"> -->
            <notifications class="mt-5 mr-2" group="notif" position="top right"/>
            <router-view></router-view>
            <!-- </div> -->

        </div>
        <!-- Right Sidebar -->
        <aside class="control-sidebar fixed white ">
            <div class="slimScroll">
                <div class="sidebar-header">
                    <h4>Activity List</h4>
                    <a href="#" data-toggle="control-sidebar" class="paper-nav-toggle  active"><i></i></a>
                </div>
                <div class="p-3">
                    <div>
                        <div class="my-3">
                            <small>25% Complete</small>
                            <div class="progress" style="height: 3px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="my-3">
                            <small>45% Complete</small>
                            <div class="progress" style="height: 3px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="my-3">
                            <small>60% Complete</small>
                            `
                            <div class="progress" style="height: 3px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="my-3">
                            <small>75% Complete</small>
                            <div class="progress" style="height: 3px;">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="my-3">
                            <small>100% Complete</small>
                            <div class="progress" style="height: 3px;">
                                <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 bg-primary text-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="font-weight-normal s-14">Sodium</h5>
                            <span class="font-weight-lighter text-primary">Spark Bar</span>
                            <div> Oxygen
                                <span class="text-primary">
                                    <i class="icon icon-arrow_downward"></i> 67%</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <canvas width="100" height="70" data-chart="spark" data-chart-type="bar" data-dataset="[[28,68,41,43,96,45,100,28,68,41,43,96,45,100,28,68,41,43,96,45,100,28,68,41,43,96,45,100]]" data-labels="['a','b','c','d','e','f','g','h','i','j','k','l','m','n','a','b','c','d','e','f','g','h','i','j','k','l','m','n']">
                            </canvas>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="recent-orders" class="table table-hover mb-0 ps-container ps-theme-default">
                        <tbody>
                            <tr>
                                <td>
                                    <a href="#">INV-281281</a>
                                </td>
                                <td>
                                    <span class="badge badge-success">Paid</span>
                                </td>
                                <td>$ 1228.28</td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="#">INV-01112</a>
                                </td>
                                <td>
                                    <span class="badge badge-warning">Overdue</span>
                                </td>
                                <td>$ 5685.28</td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="#">INV-281012</a>
                                </td>
                                <td>
                                    <span class="badge badge-success">Paid</span>
                                </td>
                                <td>$ 152.28</td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="#">INV-01112</a>
                                </td>
                                <td>
                                    <span class="badge badge-warning">Overdue</span>
                                </td>
                                <td>$ 5685.28</td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="#">INV-281012</a>
                                </td>
                                <td>
                                    <span class="badge badge-success">Paid</span>
                                </td>
                                <td>$ 152.28</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="sidebar-header">
                    <h4>Activity</h4>
                    <a href="#" data-toggle="control-sidebar" class="paper-nav-toggle  active"><i></i></a>
                </div>
                <div class="p-4">
                    <div class="activity-item activity-primary">
                        <div class="activity-content">
                            <small class="text-muted">
                                <i class="icon icon-user position-left"></i> 5 mins ago
                            </small>
                            <p>Lorem ipsum dolor sit amet conse ctetur which ascing elit users.</p>
                        </div>
                    </div>
                    <div class="activity-item activity-danger">
                        <div class="activity-content">
                            <small class="text-muted">
                                <i class="icon icon-user position-left"></i> 8 mins ago
                            </small>
                            <p>Lorem ipsum dolor sit ametcon the sectetur that ascing elit users.</p>
                        </div>
                    </div>
                    <div class="activity-item activity-success">
                        <div class="activity-content">
                            <small class="text-muted">
                                <i class="icon icon-user position-left"></i> 10 mins ago
                            </small>
                            <p>Lorem ipsum dolor sit amet cons the ecte tur and adip ascing elit users.</p>
                        </div>
                    </div>
                    <div class="activity-item activity-warning">
                        <div class="activity-content">
                            <small class="text-muted">
                                <i class="icon icon-user position-left"></i> 12 mins ago
                            </small>
                            <p>Lorem ipsum dolor sit amet consec tetur adip ascing elit users.</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        <!-- /.right-sidebar -->
        <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
        <div class="control-sidebar-bg shadow white fixed"></div>
    </div>
</div>
</template>

<style>
.paper-nav-toggle i, .paper-nav-toggle i::after, .paper-nav-toggle i::before {
    color: #fff!important;
    background: #333!important;
}
</style>

<script>
export default {
    data() {
        return {
            itemsPetugas: [],
        }
    },
    computed: {
        letters() {
            let letters = []
            for(let i = "A".charCodeAt(0); i <= "Z".charCodeAt(0); i++) {
                letters.push(String.fromCharCode([i]))
            }
            return letters
        },
        currentRouteName() {
            return this.$route.name.replace("-", " ");
        },
    },
    methods: {
        getPetugas(letter) {
            let itemsPetugas = []
            // console.log(letter)
            for (let i = 0; i < this.itemsPetugas.length; i++) {
                if (this.itemsPetugas[i].name.charAt(0) == letter) {
                    itemsPetugas.push(this.itemsPetugas[i])
                }
            }
            // console.log(itemsPetugas)
            return itemsPetugas
        },
        logout(){
            this.$auth.logout();
        }
    },
    mounted(){
        console.log(this.$auth)
        // Get Petugas
        // axios.get('/petugas')
        //     .then(response => {
        //         console.log(response)
        //         this.itemsPetugas = response.data
        //     })
    }
}
</script>
