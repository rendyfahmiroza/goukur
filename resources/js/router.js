import VueRouter from 'vue-router'

// Berkas
import Berkas from './pages/admin/berkas/Berkas'
import BerkasMandiri from './pages/admin/berkas/BerkasMandiri'
import BerkasTertunda from './pages/admin/berkas/BerkasTertunda'
import BerkasVerifikasi from './pages/admin/berkas/BerkasVerifikasi'
import Detail from './pages/admin/berkas/Detail'
import TambahBerkas from './pages/admin/berkas/TambahBerkass'
import PerbaikiBerkas from './pages/admin/berkas/PerbaikiBerkas'


// Manajemen Kegiatan
import Kegiatan from './pages/admin/manajemen/kegiatan/Kegiatan'
import TambahKegiatan from './pages/admin/manajemen/kegiatan/TambahKegiatan'
import PerbaikiKegiatan from './pages/admin/manajemen/kegiatan/PerbaikiKegiatan'

// Manajemen Operator
import DashboardOperator from './pages/user/DashboardOperator'
import BerkasOperator from './pages/admin/manajemen/operator/Berkas'
import TambahBerkasOperator from './pages/admin/manajemen/operator/TambahBerkas'
import PerbaikiBerkasOperator from './pages/admin/manajemen/operator/PerbaikiBerkas'

// Manajemen Petugas
import DashboardPetugas from './pages/user/DashboardPetugas'
import BerkasPetugas from './pages/admin/manajemen/petugas/Berkas'
import Petugas from './pages/admin/manajemen/petugas/Petugas'
import DaftarPetugas from './pages/admin/manajemen/petugas/DaftarPetugas'
import DetailDaftarPetugas from './pages/admin/manajemen/petugas/DetailDaftarPetugas'
import TambahPetugas from './pages/admin/manajemen/petugas/TambahPetugas'
import PerbaikiPetugas from './pages/admin/manajemen/petugas/PerbaikiPetugas'

// Manajemen Pengguna
import Pengguna from './pages/admin/manajemen/pengguna/Pengguna'
import TambahPengguna from './pages/admin/manajemen/pengguna/TambahPengguna'
import PerbaikiPengguna from './pages/admin/manajemen/pengguna/PerbaikiPengguna'

// Manajemen PPAT
import BerkasPpat from './pages/admin/manajemen/ppat/Berkas'
import Ppat from './pages/admin/manajemen/ppat/PPAT'
import TambahPpat from './pages/admin/manajemen/ppat/TambahPpat'
import PerbaikiPpat from './pages/admin/manajemen/ppat/PerbaikiPpat'

// Manajemen Kantor
import Kantor from './pages/admin/manajemen/kantor/Kantor'
import TambahKantor from './pages/admin/manajemen/kantor/TambahKantor'
import PerbaikiKantor from './pages/admin/manajemen/kantor/PerbaikiKantor'

// Manajemen Pembatalan
import Pembatalan from './pages/admin/manajemen/pembatalan/Pembatalan'
import TambahPembatalan from './pages/admin/manajemen/pembatalan/TambahPembatalan'
import PerbaikiPembatalan from './pages/admin/manajemen/pembatalan/PerbaikiPembatalan'

import Login from './pages/Login'
import HomeAdmin from './pages/App'
import Dashboard from './pages/admin/Home'
import Daftar from './pages/Daftar'
import UbahProfil from './pages/user/ChangeProfil'
import UbahPassword from './pages/user/ChangePass'

const routes = [      
    {
        path: '/daftar',
        name: 'daftar',
        component: Daftar,
        meta: {
            auth: false
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },
    {
        path: '/berkas-surat-tugas',
        name: 'berkas-surat-tugas',
        component: Berkas,
        meta: {
            auth: true
        }
    },
    {
        path: '/',
        name: 'home.admin',
        component: HomeAdmin,
        children: [
            {
                path: '/dashboard',
                name: 'dashboard',
                component: Dashboard,
                meta: {
                    auth: true
                }
            },
            {
                path: '/dashboard-petugas',
                name: 'dashboard-petugas',
                component: DashboardPetugas,
                meta: {
                    auth: true
                }
            },
            {
                path: '/dashboard-operator',
                name: 'dashboard-operator',
                component: DashboardOperator,
                meta: {
                    auth: true
                }
            },
            {
                path: '/berkas',
                name: 'berkas',
                component: Berkas,
                meta: {
                    auth: true
                }
            },
            {
                path: '/berkas-mandiri',
                name: 'berkas-mandiri',
                component: BerkasMandiri,
                meta: {
                    auth: true
                }
            },
            {
                path: '/berkas-tertunda',
                name: 'berkas-tertunda',
                component: BerkasTertunda,
                meta: {
                    auth: true
                }
            },
            {
                path: '/berkas-verifikasi',
                name: 'berkas-verifikasi',
                component: BerkasVerifikasi,
                meta: {
                    auth: true
                }
            },
            {
                path: '/detail-berkas/:id',
                name: 'detail-berkas',
                component: Detail,
                meta: {
                    auth: true
                }
            },
            {
                path: '/tambah-berkas',
                name: 'tambah-berkas',
                component: TambahBerkas,
                meta: {
                    auth: true
                }
            },
            {
                path: '/perbaiki-berkas/:id',
                name: 'perbaiki-berkas',
                component: PerbaikiBerkas,
                meta: {
                    auth: true
                }
            },
            ,
            {
                path: '/tambah-berkas-operator',
                name: 'tambah-berkas-operator',
                component: TambahBerkasOperator,
                meta: {
                    auth: true
                }
            },
            {
                path: '/perbaiki-berkas-operator/:id',
                name: 'perbaiki-berkas-operator',
                component: PerbaikiBerkasOperator,
                meta: {
                    auth: true
                }
            },
            {
                path: '/kegiatan',
                name: 'kegiatan',
                component: Kegiatan,
                meta: {
                    auth: true
                }
            },
            {
                path: '/tambah-kegiatan',
                name: 'tambah-kegiatan',
                component: TambahKegiatan,
                meta: {
                    auth: true
                }
            },
            {
                path: '/perbaiki-kegiatan/:id',
                name: 'perbaiki-kegiatan',
                component: PerbaikiKegiatan,
                meta: {
                    auth: true
                }
            },
            {
                path: '/pembatalan',
                name: 'pembatalan',
                component: Pembatalan,
                meta: {
                    auth: true
                }
            },
            {
                path: '/tambah-pembatalan',
                name: 'tambah-pembatalan',
                component: TambahPembatalan,
                meta: {
                    auth: true
                }
            },
            {
                path: '/perbaiki-pembatalan/:id',
                name: 'perbaiki-pembatalan',
                component: PerbaikiPembatalan,
                meta: {
                    auth: true
                }
            },
            {
                path: '/petugas',
                name: 'petugas',
                component: Petugas,
                meta: {
                    auth: true
                }
            },
            {
                path: '/daftar-petugas',
                name: 'daftar-petugas',
                component: DaftarPetugas,
                meta: {
                    auth: true
                }
            },
            {
                path: '/detail-daftar-petugas',
                name: 'detail-daftar-petugas',
                component: DetailDaftarPetugas,
                meta: {
                    auth: true
                }
            },
            {
                path: '/tambah-petugas',
                name: 'tambah-petugas',
                component: TambahPetugas,
                meta: {
                    auth: true
                }
            },
            {
                path: '/perbaiki-petugas/:id',
                name: 'perbaiki-petugas',
                component: PerbaikiPetugas,
                meta: {
                    auth: true
                }
            },
            {
                path: '/ppat',
                name: 'ppat',
                component: Ppat,
                meta: {
                    auth: true
                }
            },
            {
                path: '/tambah-ppat',
                name: 'tambah-ppat',
                component: TambahPpat,
                meta: {
                    auth: true
                }
            },
            {
                path: '/perbaiki-ppat/:id',
                name: 'perbaiki-ppat',
                component: PerbaikiPpat,
                meta: {
                    auth: true
                }
            },
            {
                path: '/pengguna',
                name: 'pengguna',
                component: Pengguna,
                meta: {
                    auth: true
                }
            },
            {
                path: '/tambah-pengguna',
                name: 'tambah-pengguna',
                component: TambahPengguna,
                meta: {
                    auth: true
                }
            },
            {
                path: '/perbaiki-pengguna/:id',
                name: 'perbaiki-pengguna',
                component: PerbaikiPengguna,
                meta: {
                    auth: true
                }
            },
            {
                path: '/kantor',
                name: 'kantor',
                component: Kantor,
                meta: {
                    auth: true
                }
            },
            {
                path: '/tambah-kantor',
                name: 'tambah-kantor',
                component: TambahKantor,
                meta: {
                    auth: true
                }
            },
            {
                path: '/perbaiki-kantor/:id',
                name: 'perbaiki-kantor',
                component: PerbaikiKantor,
                meta: {
                    auth: true
                }
            },
            {
                path: '/berkas-petugas',
                name: 'berkas-petugas',
                component: BerkasPetugas,
                meta: {
                    auth: true
                }
            },
            {
                path: '/berkas-ppat',
                name: 'berkas-ppat',
                component: BerkasPpat,
                meta: {
                    auth: true
                }
            },
            {
                path: '/berkas-operator',
                name: 'berkas-operator',
                component: BerkasOperator,
                meta: {
                    auth: true
                }
            },
            {
                path: '/ubah-profil',
                name: 'ubah-profil',
                component: UbahProfil,
                meta: {
                    auth: true
                }
            },
            {
                path: '/ubah-password',
                name: 'ubah-password',
                component: UbahPassword,
                meta: {
                    auth: true
                }
            }
        ],
        meta: {
            auth: true
        }
    },
]

const router = new VueRouter({
    history: true,
    mode: 'history',
    routes 
})

export default router