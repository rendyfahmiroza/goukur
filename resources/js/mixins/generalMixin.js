import Vue from 'vue'

Vue.mixin({
    filters: {
        formatRupiah(angka, prefix) {
            var number_string = angka.toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				let separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    },
    methods: {
        getPetugas: function() {
            axios.
                get('/petugas_kab/' +this.selectedKabupaten)
                .then(response => {
                    this.itemsPetugas = response.data
                })
        },
        getKabupaten: function(param) {
            axios.
                get('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=11')
                .then(response => {
                    this.itemsKabupaten = response.data.kota_kabupaten
                })
        },
        getKecamatan: function(param) {
            return axios.
                get('https://dev.farizdotid.com/api/daerahindonesia/kecamatan/' +param)
                .then(response => {
                    return response.data.nama
                })
        },
        getDesa: function(param) {
            axios.
                get('https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan=' +param)
                .then(response => {
                    console.log()
                    this.itemsDesa = response.data.kelurahan
                })
        }
    }
  })