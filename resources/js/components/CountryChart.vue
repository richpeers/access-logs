<template>
    <div class="small">
        <pie-chart :chart-data="chartData" :options="options"></pie-chart>
    </div>
</template>

<script>
    import PieChart from '../PieChart.js'

    export default {
        components: {
            PieChart
        },
        props: {
            requestCountByCountry: {
                type: Object,
                default: () => ({})
            }
        },
        data: () => ({
            options: {
                // legend: {
                //     display: false
                // },
            },
            colourSet: [
                '#165c7d',
                '#00BF6F',
                '#ff585d',
                '#6574cd',
                '#9561e2',
                '#f66d9b',
                '#f6993f',
                '#ffed4a',
                '#4dc0b5',
                '#6cb2eb',
            ]
        }),
        computed: {
            chartData() {
                return {
                    labels: Object.keys(this.requestCountByCountry),
                    datasets: [{
                        data: this.dataValues,
                        backgroundColor: this.dataColours,
                    }]

                }
            },
            dataValues() {
                return Object.values(this.requestCountByCountry)
            },
            dataColours() {
                let colours = [];

                for (let i = 0; i < this.dataValues.length; i++) {

                    if (typeof this.colourSet[i] === 'undefined') {

                        let lastDigitOfIndex = i % 10;
                        colours.push(this.colourSet[lastDigitOfIndex]);

                        continue;
                    }

                    colours.push(this.colourSet[i]);
                }

                return colours;
            }
        }
    }
</script>

<style>
    .small {
        max-width: 70%;
        margin: 0 auto;
    }
</style>
