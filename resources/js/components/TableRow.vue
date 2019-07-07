<template>
    <tr>
        <td>{{value.ip}}</td>
        <td :class="responseType">{{value.response_type}}</td>
        <td>{{value.response_time}}</td>
        <td>{{value.country_of_origin}}</td>
        <td>{{value.path}}</td>
    </tr>
</template>

<script>
    export default {
        name: "TableRow",
        props: {
            value: Object
        },
        computed: {
            responseType() {
                return {
                    'text-danger font-weight-bold': this.value.response_type === 500
                }
            }
        }
    }
</script>
