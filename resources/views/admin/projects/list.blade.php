@extends('admin.layout.admin')

@section('title','Projects')
@section('page-title','Projects')

@section('content')

<div id="app">

    <div class="table-card">

        <div class="table-card-header d-flex justify-content-between">

            <h6 class="table-card-title">
                <i class="bi bi-kanban me-2"></i>Projects
            </h6>

            <button class="btn btn-primary btn-sm" @click="openCreate">
                <i class="bi bi-plus"></i> Add Project
            </button>

        </div>


        <div class="table-responsive">

            <table class="table table-hover">

                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Developer</th>
                        <th>Client</th>
                        <th>Status</th>
                        <th width="120">Action</th>
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

                            <button class="btn btn-sm btn-outline-primary"
                                @click="editProject(project.id)">
                                <i class="bi bi-pencil"></i>
                            </button>

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

    @include('admin.projects.modal')

</div>

@endsection



@push('scripts')

<script>
    const app = new Vue({

        el: '#app',

        data: {

            projects: [],

            developers: [],
            clients: [],

            modal: null,

            form: {
                id: null,
                title: '',
                description: '',
                developer_id: '',
                client_id: '',
                status: 'pending'
            }

        },

        mounted() {

            this.modal = new bootstrap.Modal(
                document.getElementById('projectModal')
            )

            this.loadProjects()
            this.loadDevelopers()
            this.loadClients()

        },

        methods: {


            async loadProjects() {

                const res = await fetch('{{ route("admin.projects.data") }}')
                const result = await res.json()

                this.projects = result.data || []

            },



            async loadDevelopers() {

                const res = await fetch('/admin/developers/list')

                const result = await res.json()

                this.developers = result

            },

            async loadClients() {

                const res = await fetch('/admin/clients/list')

                const result = await res.json()

                this.clients = result

            },



            openCreate() {

                this.form = {
                    id: null,
                    title: '',
                    description: '',
                    developer_id: '',
                    client_id: '',
                    status: 'pending'
                }

                this.modal.show()

            },



            async editProject(id) {

                const res = await fetch(`/admin/projects/${id}/edit`)
                const result = await res.json()

                if (!result.success) return

                this.form = result.data

                this.modal.show()

            },



            async saveProject() {

                let url = '{{ route("admin.projects.store") }}'
                let method = 'POST'

                const formData = new FormData()

                formData.append('title', this.form.title)
                formData.append('description', this.form.description)
                formData.append('developer_id', this.form.developer_id)
                formData.append('client_id', this.form.client_id)
                formData.append('status', this.form.status)


                if (this.form.id) {

                    url = `/admin/projects/${this.form.id}`

                    formData.append('_method', 'PUT')

                }

                const res = await fetch(url, {

                    method: 'POST',

                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },

                    body: formData

                })

                const result = await res.json()

                if (result.success) {

                    this.modal.hide()

                    Swal.fire('Success', result.message, 'success')

                    this.loadProjects()

                }

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