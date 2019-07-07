<template>
    <div class="country-stats pt-2">

        <h4 class="pt-2 pb-2">Proportion of Requests from each Country</h4>

        <div class="row">
            <div class="col-md-6">
                <table class="table table-hover">
                    <thead class="bg-light-grey">
                    <tr>
                        <th>Country Of Origin</th>
                        <th class="text-center">Request Count</th>
                        <th class="text-center">Request %</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(count, country) in requestCountByCountry">
                        <td>{{country}}</td>
                        <td class="text-center">{{count}}</td>
                        <td class="text-center">{{(count / totalCount) * 100}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
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
            }
        }
    }
</script>
