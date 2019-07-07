<template>
    <a href="#" @click.prevent="orderBy" :class="active">
        {{title}}<i class="fa ml-2" :class="chevron"></i>
    </a>
</template>

<script>
    export default {
        name: "OrderBy",
        props: {
            title: {
                type: String
            },
            value: {
                type: String
            },
            orderedBy: {
                type: String
            },
            order: {
                type: String
            }
        },
        computed: {
            active() {
                return {
                    active: this.orderedBy === this.value
                }
            },
            chevron() {
                return {
                    'fa-chevron-down': this.orderedBy !== this.value || this.order === 'desc',
                    'fa-chevron-up': this.orderedBy === this.value && this.order === 'asc'
                }
            }
        },
        methods: {
            orderBy() {
                this.$emit('order-by', this.value)
            }
        }
    }
</script>
