@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Create Lead
                </div>
                <div class="card-body">
                    <form action="{{ route('leads.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>

                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="agent_id">Agent</label>
                            <select name="agent_id" id="agent_id" class="form-control">
                                <option value="">Select Agent</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}" {{ $agent->id == Auth::user()->id ? 'selected' : '' }}>
                                        {{ $agent->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Lead</button>
                        <a href="{{ route('leads.index') }}" class="btn btn-secondary">
                                {{ __('Cancel') }}
                            </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
