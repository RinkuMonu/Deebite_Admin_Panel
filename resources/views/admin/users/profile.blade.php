@extends('admin.layout.main')
@section('title', 'User Profile')
@section('page-title', 'User Profile')

@section('content')

<div class="container-fluid">

    <!-- ================= PROFILE CARD ================= -->
    <div class="card shadow-lg border-0 mb-4">
        <div class="card-body p-4">

            <div class="row align-items-center g-4">

                <!-- Avatar -->
                <div class="col-md-2 text-center">
                    <div class="avatar-circle mb-3">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <span class="badge px-3 py-2 {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <!-- User Info -->
                <div class="col-md-5">
                    <h3 class="mb-1 fw-bold">{{ $user->name }}</h3>
                    <p class="text-muted mb-3">{{ $user->email }}</p>

                    <div class="info-item mb-2">
                        <i class="fas fa-phone-alt me-2 text-primary"></i>
                        <strong>Phone:</strong> {{ $user->number ?? 'Not provided' }}
                    </div>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                        <strong>Address:</strong> {{ $user->address ?? 'Not provided' }}
                    </div>
                </div>

                <!-- Extra Info -->
                <div class="col-md-5">
                    <div class="row text-center g-3">
                        <div class="col-4">
                            <div class="stat-box p-2">
                                <h4 class="mb-0 text-primary fw-bold">{{ $user->orders->count() }}</h4>
                                <small class="text-muted">Total Orders</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box p-2">
                                <h4 class="mb-0 text-warning fw-bold">{{ number_format($user->rating ?? 0, 1) }}</h4>
                                <small class="text-muted">Rating</small>
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($user->rating ?? 0))
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box p-2">
                                <h4 class="mb-0 text-info fw-bold">{{ ucfirst($user->role) }}</h4>
                                <small class="text-muted">User Role</small>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="row">
                        <div class="col-6">
                            <div class="location-info">
                                <i class="fas fa-location-arrow me-2 text-secondary"></i>
                                <strong>Latitude:</strong>
                                <span class="text-muted">{{ $user->latitude ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="location-info">
                                <i class="fas fa-location-arrow me-2 text-secondary"></i>
                                <strong>Longitude:</strong>
                                <span class="text-muted">{{ $user->longitude ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    @if($user->is_moving)
                        <div class="mt-2">
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-car me-1"></i> Moving
                            </span>
                        </div>
                    @endif
                </div>

            </div>

            <hr class="my-3">

            <div class="row text-muted small">
                <div class="col-md-6">
                    <i class="far fa-calendar-alt me-1"></i>
                    Member since: {{ $user->created_at->format('F d, Y') }}
                </div>
                <div class="col-md-6 text-md-end">
                    <i class="far fa-clock me-1"></i>
                    Last updated: {{ $user->updated_at->diffForHumans() }}
                </div>
            </div>

        </div>
    </div>


    <!-- ================= ORDER TABLE ================= -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center px-6 py-4 border-b">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-shopping-bag me-2"></i> Order History
                </h5>
                <span class="badge bg-light text-dark px-3 py-2">
                    <i class="fas fa-chart-line me-1"></i> {{ $user->orders->count() }} Total Orders
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            @if($user->orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 15%">Order ID</th>
                                <th style="width: 15%">Total Amount</th>
                                <th style="width: 15%">Status</th>
                                <th style="width: 15%">Payment</th>
                                <th style="width: 20%">Date</th>
                                <th style="width: 15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->orders as $key => $order)
                                <tr>
                                    <td class="fw-bold">{{ $key + 1 }}</td>
                                    <td>
                                        <span class="fw-bold text-primary">
                                            #{{ $order->id }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">
                                            ₹{{ number_format($order->total, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'processing' => 'info',
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                                'delivered' => 'success'
                                            ];
                                            $statusColor = $statusColors[strtolower($order->status)] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $statusColor }} px-3 py-2">
                                            {{ ucfirst($order->status ?: 'Pending') }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $paymentColors = [
                                                'paid' => 'success',
                                                'pending' => 'warning',
                                                'failed' => 'danger',
                                                'refunded' => 'info'
                                            ];
                                            $paymentColor = $paymentColors[strtolower($order->payment_status)] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $paymentColor }} px-3 py-2">
                                            {{ ucfirst($order->payment_status ?: 'Pending') }}
                                        </span>
                                    </td>
                                    <td>
                                        <i class="far fa-calendar-alt me-1 text-muted"></i>
                                        {{ $order->created_at != '0000-00-00 00:00:00' 
                                            ? \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') 
                                            : 'N/A' }}
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary view-order" 
                                                data-id="{{ $order->id }}"
                                                data-total="{{ $order->total }}"
                                                data-status="{{ $order->status }}"
                                                data-payment="{{ $order->payment_status }}"
                                                data-date="{{ $order->created_at }}">
                                            <i class="fas fa-eye me-1"></i> View
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">No orders found for this user</h6>
                    <p class="small text-muted">This user hasn't placed any orders yet</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="order-details">
                    <p><strong>Order ID:</strong> <span id="modal_order_id"></span></p>
                    <p><strong>Total Amount:</strong> <span id="modal_total"></span></p>
                    <p><strong>Status:</strong> <span id="modal_status"></span></p>
                    <p><strong>Payment Status:</strong> <span id="modal_payment"></span></p>
                    <p><strong>Date:</strong> <span id="modal_date"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ================= CUSTOM CSS ================= -->
<style>
.avatar-circle {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    font-size: 42px;
    font-weight: bold;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.avatar-circle:hover {
    transform: scale(1.05);
}

.stat-box {
    background: #f8f9fa;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.stat-box:hover {
    background: #e9ecef;
    transform: translateY(-2px);
}

.stars {
    color: #ffc107;
    font-size: 12px;
    margin-top: 5px;
    letter-spacing: 2px;
}

.location-info {
    padding: 8px;
    background: #f8f9fa;
    border-radius: 8px;
    font-size: 13px;
}

.info-item {
    font-size: 14px;
    color: #555;
}

.info-item i {
    width: 20px;
}

.table th {
    font-weight: 600;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    vertical-align: middle;
    font-size: 14px;
}

.badge {
    font-weight: 500;
    letter-spacing: 0.3px;
}

.card {
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    border-bottom: none;
}

.btn-outline-primary {
    border-radius: 20px;
    padding: 5px 15px;
    font-size: 12px;
}

.btn-outline-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .avatar-circle {
        width: 80px;
        height: 80px;
        font-size: 32px;
    }
    
    .stat-box {
        margin-bottom: 10px;
    }
    
    .location-info {
        margin-bottom: 10px;
    }
    
    .table th, .table td {
        font-size: 12px;
        padding: 8px;
    }
    
    .badge {
        font-size: 10px;
        padding: 4px 8px;
    }
}

/* Animation for table rows */
.table tbody tr {
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
    transform: translateX(2px);
}

/* Custom scrollbar for tables */
.table-responsive::-webkit-scrollbar {
    height: 6px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>

<!-- Add Font Awesome if not already included in your layout -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Bootstrap JS for modal (if not already included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Modal functionality for viewing order details
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-order');
    const modal = new bootstrap.Modal(document.getElementById('orderModal'));
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.getAttribute('data-id');
            const total = this.getAttribute('data-total');
            const status = this.getAttribute('data-status');
            const payment = this.getAttribute('data-payment');
            const date = this.getAttribute('data-date');
            
            document.getElementById('modal_order_id').textContent = '#' + orderId;
            document.getElementById('modal_total').textContent = '₹' + parseFloat(total).toFixed(2);
            document.getElementById('modal_status').innerHTML = getStatusBadge(status);
            document.getElementById('modal_payment').innerHTML = getPaymentBadge(payment);
            document.getElementById('modal_date').textContent = formatDate(date);
            
            modal.show();
        });
    });
    
    function getStatusBadge(status) {
        const colors = {
            'pending': 'warning',
            'processing': 'info',
            'completed': 'success',
            'cancelled': 'danger',
            'delivered': 'success'
        };
        const color = colors[status?.toLowerCase()] || 'secondary';
        return `<span class="badge bg-${color} px-3 py-2">${status || 'Pending'}</span>`;
    }
    
    function getPaymentBadge(payment) {
        const colors = {
            'paid': 'success',
            'pending': 'warning',
            'failed': 'danger',
            'refunded': 'info'
        };
        const color = colors[payment?.toLowerCase()] || 'secondary';
        return `<span class="badge bg-${color} px-3 py-2">${payment || 'Pending'}</span>`;
    }
    
    function formatDate(dateString) {
        if (!dateString || dateString === '0000-00-00 00:00:00') return 'N/A';
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
});
</script>

@endsection