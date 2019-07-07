<template>
    <div class="access-logs">

        <top-nav @upload-csv="uploadCsvModal.show = true"></top-nav>

        <filters-side-bar
                :show="showFilters"
                v-model="filters"
                @apply="applyFilters"
                @clear-filters="clearAllFilters"
                @close="closeFilters"
        ></filters-side-bar>

        <div v-show="!showFilters" class="open-side-bar" @click="showFilters = true">
            Filters
        </div>

        <div class="container">

            <div class="applied-filters">
                    <span v-for="(value, filter) in appliedFilters" class="filter">
                        {{filterDisplayRef[filter]}} <i class="fa fa-times-circle" aria-hidden="true" @click.prevent="clearFilter(filter)"></i>
                    </span>
            </div>

            <table class="table table-hover">
                <thead class="bg-light-grey">
                <tr>
                    <th scope="col">
                        <order-by title="IP" value="ip" :ordered-by="orderedBy" :order="order" @order-by="orderBy"></order-by>
                    </th>
                    <th scope="col">
                        <order-by title="Response Type" value="response_type" :ordered-by="orderedBy" :order="order" @order-by="orderBy"></order-by>
                    </th>
                    <th scope="col">
                        <order-by title="Response Time" value="response_time" :ordered-by="orderedBy" :order="order" @order-by="orderBy"></order-by>
                    </th>
                    <th scope="col">
                        <order-by title="Country Of Origin" value="country_of_origin" :ordered-by="orderedBy" :order="order" @order-by="orderBy"></order-by>
                    </th>
                    <th scope="col">
                        <order-by title="Path" value="path" :ordered-by="orderedBy" :order="order" @order-by="orderBy"></order-by>
                    </th>
                </tr>
                </thead>
                <tbody>
                <table-row
                        v-for="(value, index) in data.data"
                        :value="value"
                        :key="'row-' + index"
                ></table-row>
                </tbody>
            </table>

            <pagination :data="data" :limit="3" @pagination-change-page="getPaginationPage"></pagination>

        </div>

        <upload-csv-modal
                v-if="uploadCsvModal.show"
                :show="uploadCsvModal.show"
                @success="uploadSuccess"
                @close="uploadCsvModal.show = false"
        ></upload-csv-modal>

    </div>
</template>

<script>
    import TopNav from "./Layout/TopNav";
    import UploadCsvModal from "./UploadCsvModal";
    import TableRow from "./TableRow";
    import Filters from "./Filters/Filters";
    import FiltersSideBar from "./FiltersSideBar";

    export default {
        name: "AccessLogs",
        extends: Filters,
        components: {
            FiltersSideBar,
            TableRow,
            UploadCsvModal,
            TopNav
        },
        props: {
            value: Array
        },
        data: () => ({
            uploadCsvModal: {
                show: false
            },
            fetchDataURL: '/api/access-logs',
            filters: {
                'ip': '',
                'response_type': '',
                'response_time_greater_than': '',
                'response_time_less_than': '',
                'country_of_origin': '',
                'path': ''
            },
            showFilters: false
        }),
        computed: {
            filterDisplayRef() {
                return {
                    'ip': 'IP: ' + this.appliedFilters['ip'],
                    'response_type': 'Response Type: ' + this.appliedFilters['response_type'],
                    'response_time_greater_than': 'Response Time ≥ ' + this.appliedFilters['response_time_less_than'],
                    'response_time_less_than': 'Response Time ≤ ' + this.appliedFilters['response_time_less_than'],
                    'country_of_origin': this.appliedFilters.country_of_origin,
                    'path': this.appliedFilters.path
                }
            }
        },
        methods: {
            uploadSuccess() {
                this.uploadCsvModal.show = false;
                window.Swal.fire({
                    type: 'success',
                    title: 'CSV Successfully imported',
                    text: 'Existing logs have been replaced'
                });
                this.clearAllFilters();
                this.fetchData();
            },
            applyFilters() {
                this.showFilters = false;
                this.page = 1;
                this.fetchData();
            },
            closeFilters() {
                this.showFilters = false;
            }
        }
    }
</script>
