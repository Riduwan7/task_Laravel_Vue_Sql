<div class="modal fade" id="projectModal">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    @{{ form.id ? 'Edit Project' : 'Create Project' }}

                </h5>

                <button class="btn-close" data-bs-dismiss="modal"></button>

            </div>


            <div class="modal-body">

                <form>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Project Title *</label>

                            <input type="text"
                                class="form-control"
                                v-model="form.title">

                        </div>



                        <div class="col-md-6 mb-3">

                            <label class="form-label">Status</label>

                            <select class="form-select"
                                v-model="form.status">

                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>

                            </select>

                        </div>



                        <div class="col-md-12 mb-3">

                            <label class="form-label">Description</label>

                            <textarea class="form-control"
                                rows="3"
                                v-model="form.description"></textarea>

                        </div>



                        <div class="col-md-6 mb-3">

                            <label class="form-label">Developer *</label>

                            <select class="form-select" v-model="form.developer_id" required>

                                <option value="">Select Developer</option>

                                <option v-for="dev in developers"
                                    :value="dev.id">

                                    @{{ dev.name }}

                                </option>

                            </select>

                        </div>



                        <div class="col-md-6 mb-3">

                            <label class="form-label">Client *</label>

                            <select class="form-select" v-model="form.client_id" required>

                                <option value="">Select Client</option>

                                <option v-for="client in clients"
                                    :value="client.id">

                                    @{{ client.name }}

                                </option>

                            </select>

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
                    @click="saveProject">

                    Save Project

                </button>

            </div>

        </div>

    </div>

</div>