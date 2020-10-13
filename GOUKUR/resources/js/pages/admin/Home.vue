<template>
<div class="container-fluid relative animatedParent animateOnce my-3">
    <div class="row row-eq-height mt-3">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="card no-b mb-3 bg-danger text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div><i class="icon-package s-18"></i></div>
                            </div>
                            <div class="text-center">
                                <div class="s-48 my-4 font-weight-lighter">{{jatuhTempo}}</div>
                                Jatuh Tempo
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="card no-b mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div><i class="icon-timer text-warning s-18"></i></div>
                            </div>
                            <div class="text-center">
                                <div class="s-48 my-4 font-weight-lighter">{{proses}}</div>
                                Proses
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="card no-b mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div><i class="icon-check text-success s-18"></i></div>
                            </div>
                            <div class="text-center">
                                <div class="s-48 my-4 font-weight-lighter">{{selesai}}</div>
                                Selesai
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="card no-b mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div><i class="icon-close text-danger s-18"></i></div>
                            </div>
                            <div class="text-center">
                                <div class="s-48 my-4 font-weight-lighter">{{batal}}</div>
                                 Batal
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card no-b p-3">
                <div class="card-body">
                    <div class="card-body">
                        <div class="height-300">
                            <doughnut-chart :height="300" :chart-data="dataChartDoughnut"></doughnut-chart>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card no-b my-1">
        <div class="card-body">
          <div class="my-1 height-300">
              <line-chart :height="100" :chart-data="dataChartBar" :options="dataChartBarOption"></line-chart>
          </div>
        </div>
        <div class="card-body">
            <div class="row my-3 no-gutters">
                <div class="col-md-12 mb-3">
                    <h1>Satuan Kerja</h1>
                    Peringkat Satuan Kerja Tertinggi.
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div v-for="(item, index) in dataTertinggi" :key="index" class="col-md-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mb-3">
                                    <h6>{{item.kabupaten}}</h6>
                                    <small>{{item.total}} Completed</small>
                                </div>
                                <!-- <figure class="avatar">
                                    <img src="assets/img/dummy/u12.png" alt=""></figure> -->
                            </div>
                            <div class="progress progress-xs mb-3">
                                <div class="progress-bar" role="progressbar" :style="{ width: item.total+'%' }" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import LineChart from '../../components/LineChart'
import DoughnutChart from '../../components/DoughnutChart'

export default {
    components: {
        LineChart,
        DoughnutChart
    },
    data() {
        return {
            jatuhTempo: 0,
            proses: 0,
            selesai: 0,
            batal: 0,
            kuasaPpat: 0,
            dataTertinggi: [],
            dataChart: [],
            dataChartBar: {},
            dataChartDoughnut: {},
            dataChartBarOption: {
                legend: {
                    display: true,
                },
                scales: {
                    xAxes: [{
                        stacked: true,
                        barThickness: 5,
                        gridLines: {
                            zeroLineColor: 'rgba(255,255,255,0.1)',
                            color: 'rgba(255,255,255,0.1)',
                            display: false,
                        },
                    }],
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            zeroLineColor: 'rgba(255,255,255,0.1)',
                            color: 'rgba(255,255,255,0.1)',
                        }
                    }]

                }
            },
            enabledChart: true,

            // Data Chart
            datacollection: {}
        }
    },
    methods: {
      //
    },
    mounted() {
        // this.$auth.logout()
        this.dataChart = '[[72,12]]';
        axios.
        get('/dashboard')
            .then(response => {
                this.jatuhTempo = response.data.jatuh_tempo;
                this.proses = response.data.proses;
                this.selesai = response.data.selesai;
                this.batal = response.data.batal;
                this.kuasaPpat = response.data.kuasa_ppat;
                this.dataTertinggi = response.data.data_tertinggi;
                this.dataChartBar = {
                    labels: response.data.kabupaten,
                    datasets: [{
                            label: 'Proses',
                            backgroundColor: '#7986cb',
                            borderWidth: 0,
                            data: response.data.data_bar[0]
                        },
                        {
                            label: 'Jatuh Tempo',
                            backgroundColor: '#e2e8f0',
                            borderWidth: 0,
                            data: response.data.data_bar[1]
                        }
                    ]
                }
                this.dataChartDoughnut = {
                    labels: ['Kuasa Masyarakat', 'Kuasa PPAT'],
                    datasets: [
                        {
                            borderColor: [
                            '#03a9f4',
                            '#8f5caf',              
                            ],
                            backgroundColor: [
                            '#03a9f4',
                            '#8f5caf',                
                            ],
                            data: [1000, 500]
                        }
                    ]
                }
            })
    }
}
</script>
