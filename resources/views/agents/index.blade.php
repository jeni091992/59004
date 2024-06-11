@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4">Agents</h1>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($agents as $agent)
                        <tr>
                            <td>{{ $agent->id }}</td>
                            <td>{{ $agent->name }}</td>
                            <td>{{ $agent->email }}</td>
                            <td>
                                <!-- Example actions, replace with actual actions as needed -->
                                <a href="#" class="btn btn-sm btn-primary">View</a>
                                <a href="{{ route('agents.edit', $agent->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('agents.destroy', $agent->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this agent?');">Delete</button>
                                </form>
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
    $('#agents-table').DataTable();
});
</script>
@endsection
