@extends('admin.layouts.app')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

@section('content')
    <section class="section">
           
       <div class="section-header">
            <h1>Users Call Status</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="/admin/">Call</a>
                </div>
                <div class="breadcrumb-item">Users Call Status</div>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Support Name</th>
                    <th>Staff Name</th>
                    <th>Call Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->support->name }}</td>
                    <td>{{ $user->staff->name }}</td>
                    <td>{{ $user->is_called ? 'Called' : 'Not Called' }}</td>
                    <td>
                        <form action="{{ route('admin.supports.update_call_status', $user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-primary">
                                {{ $user->is_called ? 'Mark as Not Called' : 'Mark as Called' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach --}}
            </tbody>
        </table>



        <div class="container">
    <h2>User List - Call Support</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Support team</th>
                <th>Status</th>
                <th>Engagement Score</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->full_name }}</td>
                <td>{{ $user->mobile }}</td>
                <td>
                    <select name="support_team" class="form-control">
                    <option value="">Select Support Team</option>
                        @foreach($support_team as $team)
                            <option value="{{ $team->id }}" {{ $team->id == $user->support_team_id ? 'selected' : '' }}>{{ $team->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    @if(empty($support_team->status))
                        <select name="status" class="form-control">
                            <option value="" class="bg-secondary text-dark">Select Status</option>
                            <option value="hold" class="bg-primary text-light">Hold</option>
                            <option value="in_progress" class="bg-warning text-dark">In Progress</option>
                            <option value="completed" class="bg-success">Completed</option>
                            <option value="disconnected" class="bg-danger">Disconnected</option>
                        </select>
                    @else
                        @if($support_team->status == 'hold')
                            <span class="badge bg-warning text-dark">Hold</span>
                        @elseif($support_team->status == 'in_progress')
                            <span class="badge bg-warning text-dark">In Progress</span>
                        @elseif($support_team->status == 'completed')
                            <span class="badge bg-success">Completed</span>
                        @else
                            <span class="badge bg-danger">Disconnected</span>
                        @endif
                    @endif
                </td>

                <td>
                    @if($user->engagement_score >= 80)
                        High Engagement ({{ $user->engagement_score }})
                    @elseif($user->engagement_score >= 40)
                        Moderate Engagement ({{ $user->engagement_score }})
                    @else
                        Low Engagement ({{ $user->engagement_score }})
                    @endif
                </td>
                <td>
                    <a href="" class="btn btn-info">View</a>
                    <a href="" class="btn btn-primary">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</section>
@endsection