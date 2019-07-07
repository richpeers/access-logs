<template>
    <div class="filters-side-bar" :class="{'filters-closed': !show}">
        <div class="close-filter-sidebar" @click="close"><i class="fas fa-times fa-lg"></i></div>

        <h3>Filters</h3>

        <div class="form-group">
            <label for="ip" class="control-label">IP Address</label>
            <input type="text" id="ip" v-model="filters.ip" class="form-control">
        </div>

        <div class="form-group">
            <label for="response_type" class="control-label">Response Type</label>
            <input type="text" id="response_type" v-model="filters.response_type" class="form-control">
        </div>

        <div class="form-group between">
            <label class="control-label">Response Time</label>
            <div class="input-group">
                <input class="form-control" placeholder="Min." type="number" v-model="filters['response_time_greater_than']"/>
                <span class="input-group-addon">-</span>
                <input class="form-control" placeholder="Max." type="number" v-model="filters['response_time_less_than']"/>
            </div>
        </div>

        <div class="form-group">
            <label for="country_of_origin" class="control-label">Country Of Origin</label>
            <input type="text" id="country_of_origin" v-model="filters.country_of_origin" class="form-control">
        </div>

        <div class="form-group">
            <label for="path" class="control-label">Path</label>
            <input type="text" id="path" v-model="filters.path" class="form-control">
        </div>

        <div class="form-group text-center pt-3">
            <div class="btn-group">
                <button class="btn btn-primary" @click.prevent="applyFilters">Apply</button>
                <button class="btn btn-outline-primary" @click.prevent="clearFilters">&nbsp;Clear&nbsp;</button>
            </div>

        </div>

    </div>
</template>

<script>
    export default {
        name: "FiltersSideBar",
        props: {
            value: Object,
            show: Boolean
        },
        computed: {
            filters: {
                get() {
                    return this.value;
                },
                set(value) {
                    this.$emit('input', value);
                }
            }
        },
        methods: {
            applyFilters() {
                this.$emit('apply');
            },
            clearFilters() {
                console.log('go');
                this.$emit('clear-filters');
            },
            close() {
                this.$emit('close');
            },
            filtersClosedClass() {
                return {
                    'filters-closed': !this.show
                }
            }
        }
    }
</script>
