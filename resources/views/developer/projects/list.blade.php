@extends('developer.layout.developer')

@section('title','Projects')
@section('page-title','My Projects')

@section('content')

<div id="app">

    <div class="table-card">

        <h6 class="mb-3">
            <i class="bi bi-kanban"></i> Assigned Projects
        </h6>

        <table class="table table-hover">

            <thead>
                <tr>
                    <th>Title</th>
                    <th>Client</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <tr v-for="project in projects">

                    <td>@{{ project.title }}</td>

                    <td>@{{ project.client?.name }}</td>

                    <td>

                        <span class="badge bg-primary"
                            v-if="project.status=='in_progress'">
                            In Progress
                        </span>

                        <span class="badge bg-success"
                            v-if="project.status=='completed'">
                            Completed
                        </span>

                        <span class="badge bg-warning"
                            v-if="project.status=='pending'">
                            Pending
                        </span>

                    </td>

                    <td>

                        <a :href="'/developer/projects/'+project.id"
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

                const res = await fetch('/developer/projects/data')

                const result = await res.json()

                this.projects = result.data || []

            }

        }

    })
</script>

@endpush