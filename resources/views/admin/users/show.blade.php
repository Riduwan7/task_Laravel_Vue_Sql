@extends('admin.layout.admin')

@section('title','User Details')
@section('page-title','User Details')

@section('content')

<div class="row">

    <div class="col-md-4">

        <div class="stat-card text-center">

            <div class="stat-icon mx-auto bg-primary-subtle text-primary">
                <i class="bi bi-person"></i>
            </div>

            <h5>{{ $user->name }}</h5>

            <p class="text-secondary">{{ $user->email }}</p>

            <span class="badge bg-info">
                {{ ucfirst($user->role) }}
            </span>

        </div>

    </div>


    <div class="col-md-8">

        <div class="table-card">

            <div class="table-card-header">

                <h6 class="table-card-title">
                    <i class="bi bi-kanban me-2"></i>
                    Assigned Projects
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

                        @foreach($user->developerProjects as $project)

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