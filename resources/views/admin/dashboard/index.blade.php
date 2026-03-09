@extends('admin.layout.admin')

@section('title','Dashboard')
@section('page-title','Dashboard')

@section('content')

<div id="app">

    {{-- STATS --}}
    <div class="row mb-4">

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon bg-primary-subtle text-primary">
                    <i class="bi bi-people-fill"></i>
                </div>

                <div class="stat-value">@{{ stats.total_users }}</div>
                <div class="stat-label">Total Users</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon bg-success-subtle text-success">
                    <i class="bi bi-code-square"></i>
                </div>

                <div class="stat-value">@{{ stats.total_developers }}</div>
                <div class="stat-label">Developers</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning-subtle text-warning">
                    <i class="bi bi-person-workspace"></i>
                </div>

                <div class="stat-value">@{{ stats.total_clients }}</div>
                <div class="stat-label">Clients</div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon bg-info-subtle text-info">
                    <i class="bi bi-kanban"></i>
                </div>

                <div class="stat-value">@{{ stats.total_projects }}</div>
                <div class="stat-label">Projects</div>
            </div>
        </div>

    </div>



    {{-- RECENT PROJECTS --}}
    <div class="row">

        <div class="col-lg-8 mb-4">

            <div class="table-card">

                <div class="table-card-header d-flex justify-content-between">

                    <h6 class="table-card-title">
                        <i class="bi bi-kanban me-2"></i>
                        Recent Projects
                    </h6>

                    <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>

                </div>


                <div class="table-responsive">

                    <table class="table table-hover">

                        <thead>
                            <tr>
                                <th>Project</th>
                                <th>Developer</th>
                                <th>Client</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr v-for="project in projects" :key="project.id">

                                <td>
                                    <strong>@{{ project.title }}</strong>
                                    <br>
                                    <small class="text-secondary">@{{ project.description }}</small>
                                </td>

                                <td>@{{ project.developer?.name }}</td>

                                <td>@{{ project.client?.name }}</td>

                                <td>

                                    <span v-if="project.status=='pending'" class="badge bg-warning">
                                        Pending
                                    </span>

                                    <span v-if="project.status=='in_progress'" class="badge bg-primary">
                                        In Progress
                                    </span>

                                    <span v-if="project.status=='completed'" class="badge bg-success">
                                        Completed
                                    </span>

                                </td>

                                <td>

                                    <a :href="'/admin/projects/'+project.id+'/edit'"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <button class="btn btn-sm btn-outline-danger"
                                        @click="deleteProject(project.id)">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>



        {{-- QUICK ACTIONS --}}
        <div class="col-lg-4 mb-4">

            <div class="table-card">

                <div class="table-card-header">
                    <h6 class="table-card-title">
                        <i class="bi bi-lightning-charge me-2"></i>
                        Quick Actions
                    </h6>
                </div>

                <div class="row g-3">

                    <div class="col-12">

                        <a href="{{ route('admin.users.index') }}" class="text-decoration-none">

                            <div class="stat-card text-center">

                                <div class="stat-icon mx-auto bg-primary-subtle text-primary">
                                    <i class="bi bi-person-plus"></i>
                                </div>

                                <div class="stat-label">Manage Users</div>

                            </div>

                        </a>

                    </div>



                    <div class="col-12">

                        <a href="{{ route('admin.projects.index') }}" class="text-decoration-none">

                            <div class="stat-card text-center">

                                <div class="stat-icon mx-auto bg-success-subtle text-success">
                                    <i class="bi bi-kanban"></i>
                                </div>

                                <div class="stat-label">Manage Projects</div>

                            </div>

                        </a>

                    </div>



                    <div class="col-12">

                        <div class="stat-card text-center">

                            <div class="stat-icon mx-auto bg-info-subtle text-info">
                                <i class="bi bi-bar-chart"></i>
                            </div>

                            <div class="stat-label">Reports (Coming Soon)</div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection



@push('scripts')

<script>
    const app = new Vue({

        el: '#app',

        data: {

            stats: {
                total_users: 0,
                total_developers: 0,
                total_clients: 0,
                total_projects: 0
            },

            projects: []

        },



        mounted() {

            this.loadStats()
            this.loadProjects()

        },



        methods: {



            async loadStats() {
                const usersRes = await fetch('/admin/users/data')
                const usersData = await usersRes.json()

                const users = usersData.data || []

                this.stats.total_users = users.length

                this.stats.total_developers =
                    users.filter(u => u.role.toLowerCase() === 'developer').length

                this.stats.total_clients =
                    users.filter(u => u.role.toLowerCase() === 'client').length


                const projectRes = await fetch('/admin/projects/data')
                const projectData = await projectRes.json()

                const projects = projectData.data || []

                this.stats.total_projects = projects.length

            },



            async loadProjects() {

                const res = await fetch('/admin/projects/data')

                const data = await res.json()

                this.projects = data.data.slice(0, 5)

            },



            async deleteProject(id) {

                const confirm = await Swal.fire({

                    title: 'Delete project?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33'

                })

                if (!confirm.isConfirmed) return


                const res = await fetch(`/admin/projects/${id}`, {

                    method: 'DELETE',

                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }

                })


                const result = await res.json()

                if (result.success) {

                    Swal.fire('Deleted', result.message, 'success')

                    this.loadProjects()

                }

            }

        }

    })
</script>

@endpush