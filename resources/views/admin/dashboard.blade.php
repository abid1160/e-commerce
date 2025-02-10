@extends('layouts.master')

@section('title','Dashboard')

@section('content')
<div class="content pt-3">
    <div class="row">

        <!-- Total Users Card -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-lg border-0 bg-light">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.user.profile') }}" class="text-white">
                        <h5 class="mb-0"><i class="fas fa-users"></i> Total Users</h5>
                    </a>
                    <h4 class="mb-0">{{ $userCount }} Users</h4>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="lineChartExample"></canvas>
                    </div>
                </div>
                <div class="card-footer bg-white text-muted text-right">
                    <small>Updated just now</small>
                </div>
            </div>
        </div>

        <!-- Total Product Card -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-lg border-0 bg-light">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.product.list') }}" class="text-white">
                        <h5 class="mb-0"><i class="fas fa-boxes"></i> Total Products</h5>
                    </a>
                    <h4 class="mb-0">{{ $productcount }}</h4>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="lineChartExampleWithNumbersAndGrid"></canvas>
                    </div>
                </div>
                <div class="card-footer bg-white text-muted text-right">
                    <small>Last updated 5 mins ago</small>
                </div>
            </div>
        </div>

    </div>

    {{-- order --}}
    <div class="col-lg-6 mb-4">
        <div class="card shadow-lg border-0 bg-light">
            <!-- Card Header -->
            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                <a href="{{ route('admin.order.list') }}" class="text-white text-decoration-none">
                    <h5 class="mb-0"><i class="fas fa-boxes me-2"></i> Total Orders</h5>
                </a>
                <h4 class="mb-0 font-weight-bold">{{ count($order) }} Orders</h4>
            </div>
            <!-- Card Body -->
            <div class="card-body p-4">
                <div class="chart-area">
                    <canvas id="lineChartExample"></canvas>
                </div>
                <!-- Order Status Breakdown -->
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">
                            <i class="fas fa-check-circle text-success me-2"></i> Completed
                        </span>
                        <span class="font-weight-bold">{{ $order->where('status', 'completed')->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">
                            <i class="fas fa-times-circle text-danger me-2"></i> Canceled
                        </span>
                        <span class="font-weight-bold">{{ $order->where('status', 'canceled')->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted">
                            <i class="fas fa-clock text-warning me-2"></i> Pending
                        </span>
                        <span class="font-weight-bold">{{ $order->where('status', 'pending')->count() }}</span>
                    </div>
                </div>
            </div>
            <!-- Card Footer -->
            <div class="card-footer bg-light text-muted text-right p-3 rounded-bottom">
                <small><i class="fas fa-sync-alt me-1"></i> Updated just now</small>
            </div>
        </div>
    </div>
    

    <!-- Employees List Section -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0"><i class="fas fa-users-cog"></i> Employees List</h5>
                        <small>Overview of all employees</small>
                    </div>
                    <span class="badge badge-light">Total: {{ count($employee) }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>City</th>
                                    <th>Phone Number</th>
                                    <th>Role</th>
                                    <th class="text-right">Salary (&#8377;)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employee as $row)
                                    <tr>
                                        <td><i class="fas fa-user-circle text-primary"></i> {{ $row->name }}</td>
                                        <td>{{ $row->city }}</td>
                                        <td>{{ $row->phone_number }}</td>
                                        <td><span class="badge badge-info">{{ $row->role }}</span></td>
                                        <td class="text-right">&#8377; {{ number_format($row->salary, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light text-muted text-right">
                    <small>Last updated today</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
