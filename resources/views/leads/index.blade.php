<!-- resources/views/leads/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4">Leads</h1>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-end">
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
                            <th>Stage</th>
                            <th>Agent</th>
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
                            <td>{{ $lead->stage }}</td>
                            <td>{{ $lead->agent ? $lead->agent->name : 'Unassigned' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-sm btn-warning ml-1">Edit</a>
                                    <form action="{{ route('leads.destroy', $lead->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger ml-1" onclick="return confirm('Are you sure you want to delete this lead?');">Delete</button>
                                    </form>
                                    @if($lead->stage != 'Closed-Won')
                                    <button class="btn btn-sm btn-success ml-1" onclick="createDeal({{ $lead->id }})">Create Deal</button>
                                    @endif
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
    $('#leads-table').DataTable({
        responsive: true // Enable responsiveness
    });
});

function createDeal(leadId) {
    let dealValue = prompt("Enter the Deal Value $:");
    if (dealValue) {
        // Create a form element
        let form = document.createElement("form");
        form.method = "POST";
        form.action = "/deals";

        // Add CSRF token
        let csrfField = document.createElement("input");
        csrfField.type = "hidden";
        csrfField.name = "_token";
        csrfField.value = "{{ csrf_token() }}";
        form.appendChild(csrfField);

        // Add lead ID field
        let leadIdField = document.createElement("input");
        leadIdField.type = "hidden";
        leadIdField.name = "lead_id";
        leadIdField.value = leadId;
        form.appendChild(leadIdField);

        // Add deal value field
        let dealValueField = document.createElement("input");
        dealValueField.type = "hidden";
        dealValueField.name = "deal_value";
        dealValueField.value = dealValue;
        form.appendChild(dealValueField);

        // Append form to body and submit
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
