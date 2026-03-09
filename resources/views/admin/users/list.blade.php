@extends('admin.layout.admin')

@section('title','Users')
@section('page-title','Users')

@section('content')

<div id="app">

    <div class="table-card">

        <div class="table-card-header d-flex justify-content-between">

            <h6 class="table-card-title">
                <i class="bi bi-people me-2"></i>Users
            </h6>

            <button class="btn btn-primary btn-sm" @click="openCreate">
                <i class="bi bi-plus"></i> Add User
            </button>

        </div>

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>

                <tbody>

                    <tr v-for="user in users" :key="user.id">

                        <td>
                            <strong>@{{ user.name }}</strong>
                        </td>

                        <td>@{{ user.email }}</td>

                        <td>

                            <span v-if="user.role=='admin'" class="badge bg-danger">
                                Admin
                            </span>

                            <span v-if="user.role=='developer'" class="badge bg-primary">
                                Developer
                            </span>

                            <span v-if="user.role=='client'" class="badge bg-success">
                                Client
                            </span>

                        </td>

                        <td>

                            <button class="btn btn-sm btn-outline-primary"
                                @click="editUser(user.id)">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <button class="btn btn-sm btn-outline-danger"
                                @click="deleteUser(user.id)">
                                <i class="bi bi-trash"></i>
                            </button>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>


    <!-- USER MODAL -->
    <div class="modal fade" id="userModal">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        @{{ form.id ? 'Edit User' : 'Create User' }}
                    </h5>

                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <form @submit.prevent="saveUser">

                        <!-- NAME -->
                        <div class="mb-3">

                            <label class="form-label">Name</label>

                            <input type="text"
                                class="form-control"
                                v-model="form.name">

                        </div>


                        <!-- EMAIL -->
                        <div class="mb-3">

                            <label class="form-label">Email</label>

                            <input type="email"
                                class="form-control"
                                v-model="form.email">

                        </div>


                        <!-- PASSWORD (CREATE ONLY) -->
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


                        <!-- ROLE -->
                        <div class="mb-3">

                            <label class="form-label">Role</label>

                            <select class="form-select"
                                v-model="form.role">

                                <option value="developer">Developer</option>
                                <option value="client">Client</option>

                            </select>

                        </div>

                    </form>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button class="btn btn-primary"
                        @click="saveUser">

                        Save User

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

            users: [],

            modal: null,

            form: {
                id: null,
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                role: 'developer'
            }

        },



        mounted() {

            this.modal = new bootstrap.Modal(
                document.getElementById('userModal')
            )

            this.loadUsers()

        },



        methods: {



            async loadUsers() {

                const res = await fetch('{{ route("admin.users.data") }}')

                const result = await res.json()

                this.users = result.data || []

            },



            openCreate() {

                this.form = {

                    id: null,
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    role: 'developer'

                }

                this.modal.show()

            },



            async editUser(id) {

                const res = await fetch(`/admin/users/${id}/edit`)

                const result = await res.json()

                if (!result.success) return

                this.form = {

                    id: result.data.id,
                    name: result.data.name,
                    email: result.data.email,
                    role: result.data.role

                }

                this.modal.show()

            },



            async saveUser() {

                let url = '{{ route("admin.users.store") }}'

                const formData = new FormData()

                formData.append('name', this.form.name)
                formData.append('email', this.form.email)
                formData.append('password', this.form.password)
                formData.append('password_confirmation', this.form.password_confirmation)
                formData.append('role', this.form.role)



                if (this.form.id) {

                    url = `/admin/users/${this.form.id}`

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

                    this.loadUsers()

                } else {

                    Swal.fire('Error', result.message || 'Something went wrong', 'error')

                }

            },



            async deleteUser(id) {

                const confirm = await Swal.fire({

                    title: 'Delete user?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33'

                })

                if (!confirm.isConfirmed) return


                const res = await fetch(`/admin/users/${id}`, {

                    method: 'DELETE',

                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }

                })


                const result = await res.json()


                if (result.success) {

                    Swal.fire('Deleted', result.message, 'success')

                    this.loadUsers()

                }

            }

        }

    })
</script>

@endpush