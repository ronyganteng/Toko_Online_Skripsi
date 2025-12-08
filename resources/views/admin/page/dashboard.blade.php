@extends('admin.layout.index')

@section('content')

{{-- CARD STATISTIK --}}
<div class="row mb-4">

    <div class="col-md-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6 class="text-secondary">Today's Sales</h6>
                <h3 class="fw-bold">{{ $today_sales }} Order</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6 class="text-secondary">Today's Revenue</h6>
                <h3 class="fw-bold">Rp {{ number_format($today_revenue, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6 class="text-secondary">Total Orders</h6>
                <h3 class="fw-bold">{{ $total_orders }} Order</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6 class="text-secondary">Pending Orders</h6>
                <h3 class="fw-bold">{{ $pending_orders }} Order</h3>
            </div>
        </div>
    </div>

</div>

{{-- CHART + LATEST ORDERS --}}
<div class="row mb-4">
    {{-- CHART PENJUALAN --}}
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header fw-bold">Order Status Overview</div>
            <div class="card-body">
                <canvas id="orderChart"></canvas>
            </div>
        </div>
    </div>

    {{-- LAST ORDERS TABLE --}}
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header fw-bold">Latest Orders</div>
            <div class="card-body p-0">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order Code</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status=='paid' ? 'success' : ($order->status=='pending' ? 'warning' : ($order->status=='cancelled' ? 'danger' : 'secondary')) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td>
                                    {{ optional($order->created_at)->format('d-m-Y') ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    Belum ada pesanan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('orderChart');

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Paid', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [
                        {{ $paid_orders }},
                        {{ $pending_orders }},
                        {{ $cancelled_orders }}
                    ],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545']
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endpush
