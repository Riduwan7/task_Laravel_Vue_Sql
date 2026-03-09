@extends('developer.layout.developer')

@section('title','Project')
@section('page-title','Project Details')

@section('content')

<div id="app">

    <div class="table-card mb-4">

        <h5>{{ $project->title }}</h5>

        <p class="text-secondary">
            {{ $project->description }}
        </p>

    </div>


    <div class="table-card mb-4">

        <h6>Add Update</h6>

        <textarea class="form-control mb-3"
            v-model="update_text"></textarea>

        <input type="file"
            class="form-control mb-3"
            ref="file">

        <button class="btn btn-primary"
            @click="submitUpdate">

            Submit Update

        </button>

    </div>



    <div class="table-card">

        <h6>Updates</h6>

        <div v-for="update in updates"
            class="border-bottom py-3">

            <p>@{{ update.description }}</p>

            <div v-if="update.attachments">

                <a v-for="file in update.attachments"
                    :href="'/storage/'+file.file_path"
                    target="_blank">

                    <i class="bi bi-paperclip"></i>
                    @{{ file.file_name }}

                </a>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>
    new Vue({

        el: '#app',

        data: {
            updates: [],
            update_text: ''
        },

        mounted() {
            this.loadUpdates()
        },

        methods: {

            async loadUpdates() {

                const res = await fetch(window.location.href)

                const result = await res.json()

                this.updates = result.data || []

            },


            async submitUpdate() {

                const formData = new FormData()

                formData.append('description', this.update_text)
                formData.append('project_id', '{{ $project->id }}')

                if (this.$refs.file.files[0]) {
                    formData.append('file', this.$refs.file.files[0])
                }

                const res = await fetch('/developer/project-updates', {

                    method: 'POST',

                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },

                    body: formData

                })

                const result = await res.json()

                if (result.success) {

                    Swal.fire('Success', 'Update added', 'success')

                    this.update_text = ''

                    this.loadUpdates()

                }

            }

        }

    })
</script>

@endpush