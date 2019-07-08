<template>
    <modal :show="show" @close="close">

        <form role="form" method="POST" action="/api/csv-import" @submit.prevent="onSubmit">

            <div class="modal-header">
                <h3 class="modal-title">Import CSV</h3>
            </div>

            <div class="modal-body">
                <p>Uploaded logs will replace existing logs.</p>

                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" name="csv" class="custom-file-input" id="csv" @change="onFileChange($event)">
                        <label class="custom-file-label" for="csv">{{fileLabel}}</label>
                    </div>
                    <div v-if="form.errors.has('csv')" class="invalid-feedback d-block">{{form.errors.get('csv')}}</div>
                </div>
            </div>

            <div class="modal-footer text-right">
                <button class="btn btn-success mr-2" :disabled="form.errors.any()">Import</button>
                <button class="btn btn-danger" type="button" @click.prevent="close">Cancel</button>
            </div>

        </form>

    </modal>
</template>

<script>
    import Form from "../form.js";

    export default {
        name: 'UploadCsvModal',
        props: {
            show: Boolean
        },
        data: () => ({
            form: new Form({
                csv: ''
            }),
            fileLabel: 'Choose csv file',
            uploading: false
        }),
        methods: {
            close() {
                this.$emit('close');
            },
            onFileChange(event) {
                let files = event.target.files || e.dataTransfer.files;

                if (files.length <= 0) {
                    this.fileLabel = 'Choose csv file';
                    return;
                }

                this.form.csv = files[0];
                this.fileLabel = event.target.value;
                this.form.errors.clear('csv');
            },
            onSubmit() {
                this.uploading = true;
                this.form.post('/api/csv-import')
                    .then(response => {
                        this.uploading = false;
                        this.$emit('success', response.count);
                    });
            }
        }
    }
</script>
