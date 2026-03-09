@extends('client.layout.client')

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


    <div class="table-card">

        <h6>Project Updates</h6>

        <div v-for="update in updates" class="border-bottom py-3">

            <p>@{{ update.description }}</p>

            <div v-if="update.attachments">

                <a v-for="file in update.attachments"
                    :href="'/storage/'+file.file_path"
                    target="_blank"
                    class="d-block">

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
            updates: []
        },

        mounted() {
            this.loadUpdates()
        },

        methods: {

            async loadUpdates() {

                const res = await fetch(window.location.href)

                const result = await res.json()

                this.updates = result.data || []

            }

        }

    })
</script>

@endpush