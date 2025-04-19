<template>
  <div style="display: flex; justify-content: center;">
    <div style="padding: 0.7rem; background-color: #04284a; border: none; border-radius: 10px;">
      <span style="color:white; font-weight: 500; font-size: 1rem;">Perfomance of the Company Employes Charts</span>
    </div>
  </div>
  <div style="display: flex; flex-wrap: wrap; gap: 2rem; justify-content: center; margin-top: 3em;">

    <div style="flex: 0 0 48%; text-align: center;">
      <apexchart width="100%" type="bar" :options="mostWorkedOptions" :series="mostWorkedSeries"></apexchart>
    </div>

    <div style="flex: 0 0 48%; text-align: center;">
      <apexchart width="100%" type="pie" :options="workedPercentageOptions" :series="workedPercentageSeries"></apexchart>
    </div>

    <!-- <div style="flex: 0 0 48%; text-align: center;">
      <apexchart width="100%" type="bar" :options="options" :series="series"></apexchart>
    </div>

    <div style="flex: 0 0 48%; text-align: center;">
      <apexchart width="100%" type="bar" :options="options" :series="series"></apexchart>
    </div> -->

  </div>
</template>

<script>
  import ApexCharts from 'apexcharts'

  export default {
    components: {
      ApexCharts
    },
    data: function () {
      return {
        mostWorkedSeries: [{
          data: [21, 22, 10, 28, 16, 21, 13, 30]
        }],
        mostWorkedOptions: {
          theme: {
            palette: 'palette1'
          },
          title: {
            text: 'Best Perfomances Workers',
            align: 'center',
            style: {
              fontSize: '16px'
            }
          },
          plotOptions: {
            bar: {
                distributed: true
            }
          },
        //   chart: {
        //     events: {
        //       click: function (chart, w ,e){
        //         console.log(chart);
        //         console.log(w);
        //         console.log(e);
        //       }
        //     }
        //   },
          dataLabels: {
            enabled: false
          },
          legend: {
            show: false
          },
          xaxis: {
              categories: [
                ['John', 'Doe'],
                ['Joe', 'Smith'],
                ['Jake', 'Williams'],
                'Amber',
                ['Peter', 'Brown'],
                ['Mary', 'Evans'],
                ['David', 'Wilson'],
                ['Lily', 'Roberts'],
              ],
              labels: {
                style: {
                  fontSize: '12px'
                }
              }
            }
        },

        workedPercentageSeries: [25, 20, 15, 30, 10],
        workedPercentageOptions: {
            chart: {
                type: 'pie',
            },
            theme: {
                palette: 'palette1'
            },
            title: {
                text: 'Work Percentage',
                align: 'center',
                style: {
                    fontSize: '16px'
                }
            },
            labels: ['Ana', 'Luis', 'Carlos', 'Marta', 'Sofía'],
            tooltip: {
                y: {
                    formatter: (val) => `${val}%`
                }
            },
            plotOptions: {
                pie: {
                    distributed: true
                }
            },
        }
      }
    },
    watch: {

    },
    computed: {

    },
    mounted: function () {

    },
    methods: {

    }
  }
</script>
