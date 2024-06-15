<!-- resources/views/deals/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="containe">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Deal</div>
                <div class="card-body">
                    <form action="{{ route('deals.update', $deal->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $deal->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $deal->email }}" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $deal->phone }}" required>
                        </div>

                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message">{{ $deal->message }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="agent_id">Agent</label>
                            <select name="agent_id" id="agent_id" class="form-control">
                                <option value="">Select Agent</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}" {{ $deal->agent_id == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="deal_value">Deal Value</label>
                            <input type="number" class="form-control" id="deal_value" name="deal_value" placeholder="$" value="{{ $deal->deal_value }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Deal</button>
                        <a href="{{ route('deals.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
