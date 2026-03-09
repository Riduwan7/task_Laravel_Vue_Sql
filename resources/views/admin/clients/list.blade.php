@extends('admin.layout.admin')

@section('title','Clients')
@section('page-title','Clients')

@section('content')

<div id="app">

    <div class="table-card">

        <div class="table-card-header d-flex justify-content-between">

            <h6 class="table-card-title">
                <i class="bi bi-person-workspace me-2"></i>Clients
            </h6>

            <button class="btn btn-primary btn-sm" @click="openCreate">
                <i class="bi bi-plus"></i> Add Client
            </button>

        </div>

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>

                    <tr v-for="client in clients" :key="client.id">

                        <td>
                            <strong>@{{ client.name }}</strong>
                        </td>

                        <td>@{{ client.email }}</td>

                        <td>

                            <a :href="'/admin/clients/'+client.id"
                                class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i>
                            </a>

                            <button class="btn btn-sm btn-outline-primary"
                                @click="editClient(client.id)">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <button class="btn btn-sm btn-outline-danger"
                                @click="deleteClient(client.id)">
                                <i class="bi bi-trash"></i>
                            </button>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    <!-- CLIENT MODAL -->

    <div class="modal fade" id="clientModal">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        @{{ form.id ? 'Edit Client' : 'Create Client' }}
                    </h5>

                    <button class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <form @submit.prevent="saveClient">

                        <div class="mb-3">

                            <label class="form-label">Name</label>

                            <input type="text"
                                class="form-control"
                                v-model="form.name">

                        </div>


                        <div class="mb-3">

                            <label class="form-label">Email</label>

                            <input type="email"
                                class="form-control"
                                v-model="form.email">

                        </div>


                        <div v-if="!form.id">

                            <div class="mb-3">

                                <label class="form-label">Password</label>

                                <input type="password"
                                    class="form-control"
                                    v-model="form.password">

                            </div>


                            <div class="mb-3">

                                <label class="form-label">Confirm Password</label>

                                <input type="password"
                                    class="form-control"
                                    v-model="form.password_confirmation">

                            </div>

                        </div>

                    </form>

                </div>


                <div class="modal-footer">

                    <button class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button class="btn btn-primary"
                        @click="saveClient">

                        Save Client

                    </button>

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

            clients: [],

            modal: null,

            form: {
                id: null,
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            }

        },

        mounted() {

            this.modal = new bootstrap.Modal(
                document.getElementById('clientModal')
            )

            this.loadClients()

        },

        methods: {


            async loadClients() {

                const res = await fetch('{{ route("admin.clients.data") }}')

                const result = await res.json()

                this.clients = result.data || []

            },


            openCreate() {

                this.form = {
                    id: null,
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                }

                this.modal.show()

            },


            async editClient(id) {

                const res = await fetch(`/admin/clients/${id}/edit`)

                const result = await res.json()

                this.form = result.data

                this.modal.show()

            },


            async saveClient() {

                let url = '{{ route("admin.clients.store") }}'

                const formData = new FormData()

                formData.append('name', this.form.name)
                formData.append('email', this.form.email)
                formData.append('password', this.form.password)
                formData.append('password_confirmation', this.form.password_confirmation)
                formData.append('role', 'client')


                if (this.form.id) {

                    url = `/admin/clients/${this.form.id}`

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

                    this.loadClients()

                }

            },


            async deleteClient(id) {

                const confirm = await Swal.fire({

                    title: 'Delete client?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33'

                })

                if (!confirm.isConfirmed) return


                const res = await fetch(`/admin/clients/${id}`, {

                    method: 'DELETE',

                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }

                })


                const result = await res.json()

                if (result.success) {

                    Swal.fire('Deleted', result.message, 'success')

                    this.loadClients()

                }

            }

        }

    })
</script>

@endpush