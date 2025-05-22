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
        background: rgba(17, 17, 17, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(212, 175, 55, 0.2);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .crypto-card:hover {
        transform: translateY(-5px);
    }

    .crypto-input, .crypto-output, .crypto-select {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(212, 175, 55, 0.3);
        color: #fff;
        font-family: 'Fira Code', monospace;
        border-radius: 12px;
        padding: 15px;
        resize: none;
    }

    .crypto-input:focus, .crypto-output:focus, .crypto-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
        outline: none;
    }

    .crypto-select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23D4AF37' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
    }

    .crypto-select option {
        background-color: #1a1a1a;
        color: #fff;
        padding: 15px;
    }

    .btn-gold {
        background: linear-gradient(45deg, var(--primary-color), #e6c158);
        color: #000;
        border: none;
        border-radius: 12px;
        padding: 12px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-gold:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
    }

    .btn-outline-gold {
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .btn-outline-gold:hover {
        background: var(--primary-color);
        color: #000;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 500;
    }

    .status-success {
        background: rgba(40, 167, 69, 0.15);
        color: #2ecc71;
        border: 1px solid rgba(46, 204, 113, 0.3);
    }

    .status-failed {
        background: rgba(172, 159, 160, 0.15);
        color: #e74c3c;
        border: 1px solid rgba(231, 76, 60, 0.3);
    }

    .crypto-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 150px;
        height: 4px;
        background: linear-gradient(to right, transparent, var(--primary-color), transparent);
        border-radius: 2px;
    }

    @media (max-width: 768px) {
        .crypto-card {
            margin: 0 10px;
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