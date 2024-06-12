@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="display-4">Leads</h1>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <a href="{{ route('leads.create') }}" class="btn btn-primary">Add Lead</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table id="leads-table" class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Agent</th>
                            <th>Stage</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leads as $lead)
                        <tr>
                            <td>{{ $lead->id }}</td>
                            <td>{{ $lead->name }}</td>
                            <td>{{ $lead->email }}</td>
                            <td>{{ $lead->phone }}</td>
                            <td>{{ $lead->message }}</td>
                            <td>{{ $lead->agent ? $lead->agent->name : 'Unassigned' }}</td>
                            <td>{{ $lead->stage }}</td>
                            <td>{{ $lead->created_at }}</td>
                            <td>{{ $lead->updated_at }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-sm btn-warning mr-2">Edit</a>
                                    <form action="{{ route('leads.destroy', $lead->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this lead?')">Delete</button>
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
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $('#leads-table').DataTable();
});
</script>
@endsection
