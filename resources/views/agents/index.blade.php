@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4">Agents</h1>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-end">
            <a href="{{ route('agents.create') }}" class="btn btn-primary">Add Agent</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table id="agents-table" class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contacted</th>
                            <th>Qualified</th>
                            <th>Proposal Sent</th>
                            <th>Negotiation</th>
                            <th>Closed-Won</th>
                            <th>Closed-Lost</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($agents as $agent)
                        <tr>
                            <td>{{ $agent->id }}</td>
                            <td>{{ $agent->name }}</td>
                            <td>{{ $agent->email }}</td>
                            <td>{{ $agent->contacted_count }}</td>
                            <td>{{ $agent->qualified_count }}</td>
                            <td>{{ $agent->proposal_count }}</td>
                            <td>{{ $agent->negotiation_count }}</td>
                            <td>{{ $agent->closed_won_count }}</td>
                            <td>{{ $agent->closed_lost_count }}</td>
                            <td>
                            <div class="btn-group mb-2" role="group" aria-label="Agent Actions">
                                <a href="{{ route('agents.edit', $agent->id) }}" class="btn btn-sm btn-warning mr-2">Edit</a>
                                <form action="{{ route('agents.destroy', $agent->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this agent?');">Delete</button>
                                </form>
                            </div>
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

@section('scripts')
<script>
$(document).ready(function() {
    $('#agents-table').DataTable({
        responsive: true // Enable responsiveness
    });
});
</script>
@endsection
