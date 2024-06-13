<!-- resources/views/deals/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4">Deals</h1>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('deals.create') }}" class="btn btn-primary">Add Deal</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table id="deals-table" class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Value</th>
                            <th>Agent</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deals as $deal)
                        <tr>
                            <td>{{ $deal->id }}</td>
                            <td>{{ $deal->name }}</td>
                            <td>${{ $deal->deal_value }}</td>
                            <td>{{ $deal->agent ? $deal->agent->name : 'Unassigned' }}</td>
                            <td>{{ $deal->created_at }}</td>
                            <td>{{ $deal->updated_at }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Deal Actions">
                                    <a href="{{ route('deals.edit', $deal->id) }}" class="btn btn-sm btn-warning ml-1">Edit</a>
                                    <form action="{{ route('deals.destroy', $deal->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger ml-1" onclick="return confirm('Are you sure you want to delete this deal?');">Delete</button>
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
    $('#deals-table').DataTable({
        responsive: true // Enable responsiveness
    });
});
</script>
@endsection
