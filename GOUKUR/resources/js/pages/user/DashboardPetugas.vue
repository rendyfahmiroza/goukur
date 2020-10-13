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
                                <div><i class="icon-timer s-18"></i></div>
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
                                <div><i class="icon-user-circle-o s-18"></i></div>
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
                                <div><i class="icon-user-times s-18"></i></div>
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
</div>
</template>

<script>
import DoughnutChart from '../../components/DoughnutChart'

export default {
    components: {
        DoughnutChart
    },
    data() {
        return {
            jatuhTempo: 0,
            proses: 0,
            selesai: 0,
            batal: 0,
            dataTertinggi: [],
            dataChart: [],
            dataChartBar: {},
            dataChartDoughnut: {},
            enabledChart: true,

            // Data Chart
            datacollection: {}
        }
    },
    methods: {
      //
    },
    mounted() {
        axios.
        get('/dashboard-petugas')
            .then(response => {
                this.jatuhTempo = response.data.jatuh_tempo;
                this.proses = response.data.proses;
                this.selesai = response.data.selesai;
                this.batal = response.data.batal;
                this.dataTertinggi = response.data.data_tertinggi;
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
