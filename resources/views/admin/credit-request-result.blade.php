@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #D4AF37, #F7E98E); color: #2c1e1e;">
                    <h4 class="mb-0">
                        <i class="fas fa-credit-card me-2"></i>
                        Credit Request Processing Result
                    </h4>
                </div>
                <div class="card-body">
                    @if($success)
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ $message }}
                        </div>
                        
                        @if(!isset($rejected))
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title text-gold">Credit Added Successfully</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Customer:</strong> {{ $user->name }}</p>
                                            <p><strong>Email:</strong> {{ $user->email }}</p>
                                            <p><strong>Request ID:</strong> #{{ $request_id }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Amount Added:</strong> ${{ number_format($amount, 2) }}</p>
                                            <p><strong>New Balance:</strong> ${{ $new_balance }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title text-danger">Request Rejected</h5>
                                    <p><strong>Request ID:</strong> #{{ $request_id }}</p>
                                    <p>The credit request has been rejected and no changes have been made to the customer account.</p>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ $message }}
                        </div>
                        
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title text-danger">Processing Failed</h5>
                                <p><strong>Request ID:</strong> #{{ $request_id }}</p>
                                <p>Please try again or contact the system administrator.</p>
                            </div>
                        </div>
                    @endif
                    
                    <div class="mt-4 text-center">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-gold">
                            <i class="fas fa-arrow-left me-2"></i>
                            Return to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.text-gold {
    color: #D4AF37 !important;
}

.btn-outline-gold {
    color: #D4AF37;
    border-color: #D4AF37;
}

.btn-outline-gold:hover {
    color: #2c1e1e;
    background-color: #D4AF37;
    border-color: #D4AF37;
}
</style>
@endsection
