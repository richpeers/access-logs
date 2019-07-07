<script>
    import Pagination from './Pagination/Pagination';
    import OrderBy from './OrderBy';

    export default {
        name: "Filters",
        components: {Pagination, OrderBy},
        data: () => ({
            data: {},
            orderedBy: '',
            order: 'desc',
            page: 1,
            appliedFilters: {},
            filtersOpen: false,
        }),
        computed: {
            queryParams() {
                let params = Object.assign({}, {}, this.filters);

                if (this.orderedBy !== '') {
                    params = Object.assign({}, params, {'order': this.orderedBy + ',' + this.order})
                }
                if (this.page !== 1) {
                    params = Object.assign({}, params, {'page': this.page})
                }

                // params = Object.assign({}, params, {'offset': window.offset});

                return params
            },
            queryString() {
                let queryString = Object.keys(this.queryParams)
                    .filter((param) => this.queryParams[param] !== null && this.queryParams[param] !== '')
                    .map(param => `${param}=${this.queryParams[param]}`)
                    .join('&');

                if (queryString.length > 0) {
                    queryString = '?' + queryString
                }

                return queryString
            },
            url() {
                return this.fetchDataURL + this.queryString;
            }
        },
        methods: {
            getUrlParams() {
                let _url = new URL(window.location.href);
                let _params = new URLSearchParams(_url.search);

                return Array.from(_params.keys()).reduce((sum, value) => {
                    return Object.assign({[value]: _params.get(value)}, sum);
                }, {});
            },
            setAppliedFilters() {
                let appliedFilters = Object.entries(this.filters)
                    .filter(([lng, value]) => {
                        return value !== '' && value !== null
                    })
                    .reduce((obj, item) => {
                        obj[item[0]] = item[1];
                        return obj
                    }, {});

                this.appliedFilters = Object.assign({}, {}, appliedFilters);
            },
            getFiltersFromUrlParams() {
                let urlParams = this.getUrlParams();
                Object.entries(urlParams)
                    .filter(([key, value]) => value !== null && value !== '' && Object.keys(this.filters).includes(key))
                    .forEach(([key, value]) => {
                        this.$set(this.filters, key, value);
                    });

                if (urlParams.hasOwnProperty('page')) {
                    this.page = urlParams.page
                }
                if (urlParams.hasOwnProperty('order')) {
                    let parts = urlParams.order.split(',');
                    this.orderedBy = parts[0];
                    this.order = parts[1];
                }
            },
            fetchData() {
                window.axios.get(this.url)
                    .then(response => {
                        this.data = Object.assign({}, {}, response.data);
                        history.pushState({}, 'title', location.protocol + "//" + location.host + location.pathname + this.queryString);
                        this.setAppliedFilters();
                    })
                    .catch(error => console.log(error))
            },
            applyFilters() {
                this.page = 1;
                this.fetchData();
                this.filtersOpen = false;
            },
            clearFilter(filter) {
                this.$set(this.filters, filter, '');
                this.resetOrder();
                this.applyFilters();
            },
            clearAllFilters() {
                Object.keys(this.filters).forEach(filter => this.$set(this.filters, filter, ''));
                this.resetOrder();
                this.applyFilters()
            },
            resetOrder() {
                this.orderedBy = '';
                this.order = 'desc';
            },
            getPaginationPage(page) {
                this.page = page;
                this.fetchData();
            },
            toggleOrder() {
                this.order = this.order === 'asc' ? 'desc' : 'asc';
            },
            orderBy(column) {
                if (this.orderedBy === column) {
                    this.toggleOrder()
                } else {
                    this.orderedBy = column;
                    this.order = 'desc'
                }
                this.applyFilters()
            },
            getAnyOtherData() {
            }
        },
        created() {
            this.getFiltersFromUrlParams();
        },
        mounted() {
            this.fetchData();
            this.getAnyOtherData();
        },
    }
</script>
