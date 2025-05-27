@extends('layouts.master')
@section('title', 'Manage Credit Requests')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-gold mb-0">
                <i class="fas fa-credit-card me-2"></i>Credit Requests Management
                <small class="text-light d-block mt-2" style="font-size: 1rem;">Review and manage customer credit requests</small>
            </h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('users') }}" class="btn btn-gold">
                <i class="fas fa-arrow-left me-2"></i>Back to Users
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($requests->isEmpty())
        <div class="card empty-state-card">
            <div class="card-body text-center py-5">
                <i class="fas fa-credit-card fa-3x text-gold mb-3"></i>
                <h4 class="text-gold mb-3">No Credit Requests</h4>
                <p class="text-light mb-4">There are no credit requests to review at this time.</p>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead class="thead-gold">
                            <tr>
                                <th class="border-gold">Request ID</th>
                                <th class="border-gold">Customer</th>
                                <th class="border-gold">Current Credit</th>
                                <th class="border-gold">Requested Amount</th>
                                <th class="border-gold">Reason</th>
                                <th class="border-gold">Status</th>
                                <th class="border-gold">Date</th>
                                <th class="border-gold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                            <tr>
                                <td class="border-gold">#{{ $request->id }}</td>
                                <td class="border-gold">
                                    <div>
                                        <strong>{{ $request->user_name }}</strong>
                                        <br><small class="text-light">{{ $request->user_email }}</small>
                                    </div>
                                </td>
                                <td class="border-gold">
                                    <span class="badge bg-credit">${{ number_format($request->current_credit, 2) }}</span>
                                </td>
                                <td class="border-gold">
                                    <span class="badge bg-gold text-dark">${{ number_format($request->amount, 2) }}</span>
                                </td>
                                <td class="border-gold">
                                    @if($request->reason)
                                        <small>{{ Str::limit($request->reason, 50) }}</small>
                                        @if(strlen($request->reason) > 50)
                                            <button class="btn btn-sm btn-link text-gold p-0 ms-1" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#reasonModal{{ $request->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        @endif
                                    @else
                                        <em class="text-muted">No reason provided</em>
                                    @endif
                                </td>
                                <td class="border-gold">
                                    @switch($request->status)
                                        @case('pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                            @break
                                        @case('approved')
                                            <span class="badge bg-success">Approved</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-secondary">Cancelled</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="border-gold">
                                    {{ \Carbon\Carbon::parse($request->created_at)->format('M d, Y H:i') }}
                                </td>
                                <td class="border-gold">
                                    @if($request->status === 'pending')
                                        <div class="btn-group">
                                            <a href="{{ route('admin.credit.approve', $request->id) }}" 
                                               class="btn btn-success btn-sm"
                                               onclick="return confirm('Are you sure you want to approve this credit request?')">
                                                <i class="fas fa-check"></i> Approve
                                            </a>
                                            <a href="{{ route('admin.credit.reject', $request->id) }}" 
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Are you sure you want to reject this credit request?')">
                                                <i class="fas fa-times"></i> Reject
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-muted">No actions available</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- Reason Modal -->
                            @if($request->reason && strlen($request->reason) > 50)
                            <div class="modal fade" id="reasonModal{{ $request->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-dark text-gold">
                                        <div class="modal-header border-gold">
                                            <h5 class="modal-title">Request Reason - #{{ $request->id }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-light">{{ $request->reason }}</p>
                                        </div>
                                        <div class="modal-footer border-gold">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    body {
        background-color: #2c1e1e;
        color: #f5f5f5;
    }
    .table-dark {
        background-color: #2c1e1e !important;
        color: #f5f5f5 !important;
    }
    .table-dark thead th {
        background-color: #3a2a2a !important;
        color: #D4AF37 !important;
        border-color: #D4AF37 !important;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .table-dark tbody tr {
        background-color: #2c1e1e !important;
        border-color: #D4AF37 !important;
        transition: all 0.3s ease;
    }
    .table-dark tbody tr:hover {
        background-color: #3a2a2a !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(212, 175, 55, 0.1);
    }
    .table-dark td {
        border-color: #D4AF37 !important;
        color: #f5f5f5 !important;
        vertical-align: middle;
    }
    .border-gold {
        border-color: #D4AF37 !important;
    }
    .text-gold {
        color: #D4AF37;
        font-weight: 600;
    }
    .text-light {
        color: #f5f5f5 !important;
    }
    .btn-gold {
        background-color: #D4AF37;
        color: #2c1e1e;
        border: none;
        transition: all 0.3s ease;
        padding: 8px 16px;
        font-weight: 500;
        border-radius: 20px;
    }
    .btn-gold:hover {
        background-color: #B38F28;
        color: #2c1e1e;
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(212, 175, 55, 0.2);
    }
    .badge.bg-credit {
        background-color: #D4AF37;
        color: #2c1e1e;
        font-weight: 500;
        padding: 6px 12px;
        border-radius: 20px;
    }
    .empty-state-card {
        max-width: 600px;
        margin: 0 auto;
        background-color: #3a2a2a;
        border: 1px solid #D4AF37;
        border-radius: 12px;
    }
    .card {
        background-color: #3a2a2a;
        border: 1px solid #D4AF37;
        border-radius: 12px;
    }
    .modal-content {
        background-color: #2c1e1e !important;
        border: 1px solid #D4AF37;
    }
    .modal-header {
        border-bottom-color: #D4AF37;
    }
    .modal-footer {
        border-top-color: #D4AF37;
    }
    .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
</style>
@endsection
