<template>
    <div class="country-stats pt-2">

        <h4 class="pt-2 pb-2">Proportion of Requests from each Country</h4>

        <div class="row">

            <div class="col-md-7">
                <table class="table table-hover">
                    <thead class="bg-light-grey">
                    <tr>
                        <th>Country Of Origin</th>
                        <th class="text-center">Request Count</th>
                        <th class="text-center">Request %</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(country, index) in Object.entries(requestCountByCountry)">
                        <td>{{country[0]}}</td>
                        <td class="text-center">{{country[1]}}</td>
                        <td class="text-center">{{(country[1] / totalCount) * 100}}</td>
                        <td><div class="dot" :style="'background:' + colourSet[index]"></div></td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-5">
                <country-chart
                        :request-count-by-country="requestCountByCountry"
                ></country-chart>
            </div>

        </div>
    </div>

</template>

<script>
    import CountryChart from "./CountryChart";

    export default {
        name: "CountryRequests",
        components: {CountryChart},
        props: {
            data: {
                type: Array,
                default: () => ([])
            },
            totalCount: Number
        },
        data: () => ({
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
            requestCountByCountry() {
                if (!Object.keys(this.data).length) {
                    return {};
                }

                let obj = this.data.reduce(function (result, log) {
                    const key = log['country_of_origin'];

                    if (!result[key]) {
                        result[key] = 0;
                    }
                    // increment the value
                    result[key]++;
                    // return the transformed array
                    return result;
                }, {});

                let entries = Object.entries(obj);

                return entries.sort((b, a) => a[1] - b[1])
                    .reduce((_sortedObj, [k, v]) => ({
                        ..._sortedObj,
                        [k]: v
                    }), {})
            },
            dataColours() {
                let colours = [];

                for (let i = 0; i < Object.keys(this.requestCountByCountry).length; i++) {

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
