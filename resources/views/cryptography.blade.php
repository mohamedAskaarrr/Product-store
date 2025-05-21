@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="crypto-header text-center mb-5" data-aos="fade-down">
        <h2 class="display-4 text-gold mb-3">
            <i class="fas fa-shield-alt me-2"></i>Cryptography Tools
        </h2>
        <p class="text-light opacity-75">Secure your data with advanced encryption and hashing</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="crypto-card" data-aos="fade-up">
                <div class="card-body p-4">
                    <form method="GET" action="{{ route('cryptography') }}" class="crypto-form">
                        <div class="mb-4">
                            <label class="form-label text-gold">Input Data</label>
                            <textarea name="data" class="form-control crypto-input" rows="3" placeholder="Enter text to process" required>{{ $data }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-gold">Operation</label>
                            <select class="form-control crypto-select" name="action" required>
                                <option value="Encrypt" {{ $action == 'Encrypt' ? 'selected' : '' }}>
                                    <i class="fas fa-lock"></i> Encrypt
                                </option>
                                <option value="Decrypt" {{ $action == 'Decrypt' ? 'selected' : '' }}>
                                    <i class="fas fa-unlock"></i> Decrypt
                                </option>
                                <option value="Hash" {{ $action == 'Hash' ? 'selected' : '' }}>
                                    <i class="fas fa-fingerprint"></i> Hash
                                </option>
                                <option value="Sign" {{ $action == 'Sign' ? 'selected' : '' }}>
                                    <i class="fas fa-signature"></i> Sign
                                </option>
                                <option value="Verify" {{ $action == 'Verify' ? 'selected' : '' }}>
                                    <i class="fas fa-check-circle"></i> Verify
                                </option>
                                <option value="KeySend" {{ $action == 'KeySend' ? 'selected' : '' }}>
                                    <i class="fas fa-paper-plane"></i> KeySend
                                </option>
                                <option value="KeyRecive" {{ $action == 'KeyRecive' ? 'selected' : '' }}>
                                    <i class="fas fa-download"></i> KeyRecive
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-gold w-100 mb-4">
                            <i class="fas fa-cogs me-2"></i>Process
                        </button>

                        @if($result)
                            <div class="result-section">
                                <label class="form-label text-gold">Result</label>
                                <div class="crypto-result">
                                    <div class="input-group">
                                        <textarea class="form-control crypto-output" rows="3" readonly>{{ $result }}</textarea>
                                        <button type="button" class="btn btn-outline-gold" onclick="copyToClipboard(this)">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="status-badge mt-2 {{ $status == 'Failed' ? 'status-failed' : 'status-success' }}">
                                    <i class="fas {{ $status == 'Failed' ? 'fa-times-circle' : 'fa-check-circle' }} me-1"></i>
                                    {{ $status }}
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .crypto-card {
        background: linear-gradient(135deg, var(--card-bg) 0%, #2c1e1e 100%);
        border: 1px solid var(--primary-color);
        border-radius: 15px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .crypto-input, .crypto-output, .crypto-select {
        background-color: rgba(0, 0, 0, 0.2);
        border: 1px solid var(--primary-color);
        color: var(--text-color);
        font-family: 'Courier New', monospace;
        resize: none;
    }

    .crypto-input:focus, .crypto-output:focus, .crypto-select:focus {
        background-color: rgba(0, 0, 0, 0.3);
        border-color: var(--primary-color);
        color: var(--text-color);
        box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
    }

    .crypto-select {
        cursor: pointer;
        padding: 0.75rem;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23D4AF37' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
    }

    .crypto-select option {
        background-color: var(--card-bg);
        color: var(--text-color);
        padding: 1rem;
    }

    .btn-gold {
        background-color: var(--primary-color);
        color: var(--background-color);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-gold:hover {
        background-color: var(--secondary-color);
        transform: translateY(-2px);
    }

    .btn-outline-gold {
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-outline-gold:hover {
        background-color: var(--primary-color);
        color: var(--background-color);
    }

    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .status-success {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid #28a745;
    }

    .status-failed {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 1px solid #dc3545;
    }

    .crypto-result {
        position: relative;
    }

    .crypto-header::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 3px;
        background: linear-gradient(to right, transparent, var(--primary-color), transparent);
    }

    @media (max-width: 768px) {
        .crypto-select {
            font-size: 0.9rem;
        }
    }
</style>

<script>
function copyToClipboard(button) {
    const textarea = button.parentElement.querySelector('textarea');
    textarea.select();
    document.execCommand('copy');
    
    // Visual feedback
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-check"></i>';
    button.classList.add('btn-success');
    button.classList.remove('btn-outline-gold');
    
    setTimeout(() => {
        button.innerHTML = originalText;
        button.classList.remove('btn-success');
        button.classList.add('btn-outline-gold');
    }, 2000);
}
</script>
@endsection
