@extends('admin.layout.admin')

@section('title','Client Details')
@section('page-title','Client Details')

@section('content')

<div class="row">

    <div class="col-md-4">

        <div class="stat-card text-center">

            <div class="stat-icon mx-auto bg-success-subtle text-success">
                <i class="bi bi-person-workspace"></i>
            </div>

            <h5>{{ $client->name }}</h5>

            <p class="text-secondary">{{ $client->email }}</p>

            <span class="badge bg-success">
                Client
            </span>

        </div>

    </div>


    <div class="col-md-8">

        <div class="table-card">

            <div class="table-card-header">

                <h6 class="table-card-title">
                    <i class="bi bi-kanban me-2"></i>
                    Client Projects
                </h6>

            </div>


            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($client->clientProjects as $project)

                        <tr>

                            <td>{{ $project->title }}</td>

                            <td>

                                @if($project->status=='pending')
                                <span class="badge bg-warning">Pending</span>
                                @endif

                                @if($project->status=='in_progress')
                                <span class="badge bg-primary">In Progress</span>
                                @endif

                                @if($project->status=='completed')
                                <span class="badge bg-success">Completed</span>
                                @endif

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection