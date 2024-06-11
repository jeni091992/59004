@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">


        <!-- Content -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>
            <!-- Logout Button -->
            
            <div class="row">
                <div class="col-md-6">
                    <p>Welcome, {{ Auth::user()->name }}!</p>
                </div>
            </div>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                    <button type="submit" class="btn btn-link">Logout</button>
                </form>
            <!-- Page Content Goes Here -->
        </main>
    </div>
</div>
@endsection
