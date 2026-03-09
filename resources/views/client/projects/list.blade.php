@extends('client.layout.client')

@section('title','Projects')
@section('page-title','My Projects')

@section('content')

<div id="app">

    <div class="table-card">

        <h6 class="mb-3">
            <i class="bi bi-kanban"></i> My Projects
        </h6>

        <table class="table table-hover">

            <thead>
                <tr>
                    <th>Title</th>
                    <th>Developer</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <tr v-for="project in projects">

                    <td>@{{ project.title }}</td>

                    <td>@{{ project.developer?.name }}</td>

                    <td>

                        <span v-if="project.status=='pending'" class="badge bg-warning">Pending</span>
                        <span v-if="project.status=='in_progress'" class="badge bg-primary">In Progress</span>
                        <span v-if="project.status=='completed'" class="badge bg-success">Completed</span>

                    </td>

                    <td>

                        <a :href="'/client/projects/'+project.id"
                            class="btn btn-sm btn-outline-primary">

                            View

                        </a>

                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection


@push('scripts')

<script>
    new Vue({

        el: '#app',

        data: {
            projects: []
        },

        mounted() {
            this.loadProjects()
        },

        methods: {

            async loadProjects() {

                const res = await fetch('/client/projects/data')

                const result = await res.json()

                this.projects = result.data || []

            }

        }

    })
</script>

@endpush