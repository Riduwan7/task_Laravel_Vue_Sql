@extends('client.layout.client')

@section('title','Dashboard')
@section('page-title','Client Dashboard')

@section('content')

<div id="app">

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="stat-card">

                <div class="stat-icon bg-primary-subtle text-primary">
                    <i class="bi bi-kanban"></i>
                </div>

                <div class="stat-value">@{{ stats.total }}</div>
                <div class="stat-label">Total Projects</div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="stat-card">

                <div class="stat-icon bg-warning-subtle text-warning">
                    <i class="bi bi-clock"></i>
                </div>

                <div class="stat-value">@{{ stats.in_progress }}</div>
                <div class="stat-label">In Progress</div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="stat-card">

                <div class="stat-icon bg-success-subtle text-success">
                    <i class="bi bi-check-circle"></i>
                </div>

                <div class="stat-value">@{{ stats.completed }}</div>
                <div class="stat-label">Completed</div>

            </div>

        </div>

    </div>


    <div class="table-card">

        <h6 class="mb-3">
            <i class="bi bi-kanban"></i> Recent Projects
        </h6>

        <table class="table">

            <thead>
                <tr>
                    <th>Project</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                <tr v-for="p in projects" :key="p.id">

                    <td>@{{ p.title }}</td>

                    <td>

                        <span v-if="p.status=='pending'" class="badge bg-warning">Pending</span>
                        <span v-if="p.status=='in_progress'" class="badge bg-primary">In Progress</span>
                        <span v-if="p.status=='completed'" class="badge bg-success">Completed</span>

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
            projects: [],
            stats: {
                total: 0,
                in_progress: 0,
                completed: 0
            }
        },

        mounted() {
            this.loadProjects()
        },

        methods: {

            async loadProjects() {

                const res = await fetch('/client/projects/data')

                const result = await res.json()

                this.projects = result.data || []

                this.stats.total = this.projects.length

                this.stats.in_progress =
                    this.projects.filter(p => p.status == 'in_progress').length

                this.stats.completed =
                    this.projects.filter(p => p.status == 'completed').length

            }

        }

    })
</script>

@endpush