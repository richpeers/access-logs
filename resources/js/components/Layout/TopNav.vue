<template>
    <nav class="navbar navbar-expand-sm navbar-dark bg-primary fixed-top">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand" href="#">Access Logs</a>

                <div class="navbar-nav">
                    <a class="nav-item nav-link" href="https://github.com/richpeers/access-logs" target="_blank"><i class="fab fa-github fa-2x"></i></a>
                    <a class="nav-item nav-link" href="https://www.linkedin.com/in/richpeers" target="_blank"><i class="fab fa-linkedin fa-2x"></i></a>
                </div>

                <div class="navbar-nav ml-auto">
                    <div class="nav-item">
                        <button class="btn btn-secondary font-weight-bold" type="button" @click="uploadCsv">Import CSV</button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "TopNav",
        methods: {
            uploadCsv() {
                this.$emit('upload-csv');
            }
        }
    }
</script>
