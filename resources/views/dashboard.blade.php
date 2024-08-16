@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <div class="row">
                        @if(auth()->user()->is_admin)
                            <div class="col-md-4">
                                <div class="card text-white bg-primary mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Manage Users</h5>
                                        <p class="card-text">Manage user accounts.</p>
                                        <a href="{{ route('users.index') }}" class="btn btn-light">Manage Users</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card text-white bg-success mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Transactions</h5>
                                        <p class="card-text">View all transactions.</p>
                                        <a href="{{ route('transactions.index') }}" class="btn btn-light">View Transactions</a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-4">
                            <div class="card text-white bg-warning mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Traffic by Location</h5>
                                    <p class="card-text">Analyze traffic based on user locations.</p>
                                    <a href="{{route('traffic.index')}}" class="btn btn-light">View Traffic</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card text-white bg-info mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Payments</h5>
                                    <p class="card-text">Create and manage payments.</p>
                                    <a href="{{route('payment.form')}}" class="btn btn-light">Manage Payments</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add more content as needed -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
