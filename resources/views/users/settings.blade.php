@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="min-height: 80vh;">
    <h2 class="mb-4 text-gold">Settings</h2>
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 mb-3">
            <div class="list-group settings-sidebar">
                <button class="list-group-item list-group-item-action active" id="account-tab" onclick="showSettingsSection('account')">
                    <i class="fas fa-user me-2"></i>Account
                </button>
                <button class="list-group-item list-group-item-action" id="notifications-tab" onclick="showSettingsSection('notifications')">
                    <i class="fas fa-bell me-2"></i>Notifications
                </button>
                <button class="list-group-item list-group-item-action" id="preferences-tab" onclick="showSettingsSection('preferences')">
                    <i class="fas fa-sliders-h me-2"></i>Preferences
                </button>
                <button class="list-group-item list-group-item-action" id="store-tab" onclick="showSettingsSection('store')">
                    <i class="fas fa-map-marker-alt me-2"></i>Store Locator
                </button>
                <button class="list-group-item list-group-item-action" id="privacy-tab" onclick="showSettingsSection('privacy')">
                    <i class="fas fa-user-secret me-2"></i>Privacy
                </button>
                <button class="list-group-item list-group-item-action" id="support-tab" onclick="showSettingsSection('support')">
                    <i class="fas fa-headset me-2"></i>Support
                </button>
            </div>
        </div>
        <!-- Main Content -->
        <div class="col-md-9">
            <div id="settings-content" class="card p-4 settings-card">
                <!-- Account Section -->
                <div id="account-section" class="settings-section">
                    <h4 class="text-gold mb-3">Account</h4>
                    <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <a href="{{ route('users_edit', Auth::user()->id) }}" class="btn btn-gold me-2 mb-2">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                    <a href="{{ route('edit_password', Auth::user()->id) }}" class="btn btn-gold mb-2">
                        <i class="fas fa-key"></i> Change Password
                    </a>
                </div>
                <!-- Notifications Section -->
                <div id="notifications-section" class="settings-section d-none">
                    <h4 class="text-gold mb-3">Notifications</h4>
                    <p>Manage your notification preferences for offers and order updates.</p>
                    <form action="{{ route('settings.update') }}" method="POST" id="notifications-form">
                        @csrf
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="emailOffers" name="email_offers" 
                                {{ Auth::user()->email_offers ? 'checked' : '' }}>
                            <label class="form-check-label" for="emailOffers">Email me about special offers</label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="orderUpdates" name="order_updates"
                                {{ Auth::user()->order_updates ? 'checked' : '' }}>
                            <label class="form-check-label" for="orderUpdates">Order status updates</label>
                        </div>
                        <button type="submit" class="btn btn-gold mt-3">Save Changes</button>
                    </form>
                </div>
                <!-- Preferences Section -->
                <div id="preferences-section" class="settings-section d-none">
                    <h4 class="text-gold mb-3">Preferences</h4>
                    <form action="{{ route('settings.update') }}" method="POST" id="preferences-form">
                        @csrf
                        <div class="mb-3">
                            <label for="currencySelect" class="form-label">Currency</label>
                            <select class="form-select" id="currencySelect" name="currency">
                                <option value="USD" {{ Auth::user()->currency === 'USD' ? 'selected' : '' }}>$ USD</option>
                                <option value="EUR" {{ Auth::user()->currency === 'EUR' ? 'selected' : '' }}>€ EUR</option>
                                <option value="EGP" {{ Auth::user()->currency === 'EGP' ? 'selected' : '' }}>E£ EGP</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="languageSelect" class="form-label">Language</label>
                            <select class="form-select" id="languageSelect" name="language">
                                <option value="en" {{ Auth::user()->language === 'en' ? 'selected' : '' }}>English</option>
                                <option value="ar" {{ Auth::user()->language === 'ar' ? 'selected' : '' }}>Arabic</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="themeSelect" class="form-label">Theme</label>
                            <select class="form-select" id="themeSelect" name="theme">
                                <option value="dark" {{ Auth::user()->theme === 'dark' ? 'selected' : '' }}>Dark</option>
                                <option value="light" {{ Auth::user()->theme === 'light' ? 'selected' : '' }}>Light</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-gold">Save Changes</button>
                    </form>
                </div>
                <!-- Store Locator Section -->
                <div id="store-section" class="settings-section d-none">
                    <h4 class="text-gold mb-3">Store Locator</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-store me-2 text-gold"></i>City Stars Mall, Nasr City, Cairo</li>
                        <li class="mb-2"><i class="fas fa-store me-2 text-gold"></i>Mall of Egypt, 6th of October City, Giza</li>
                        <li class="mb-2"><i class="fas fa-store me-2 text-gold"></i>Cairo Festival City Mall, New Cairo, Cairo</li>
                        <li class="mb-2"><i class="fas fa-store me-2 text-gold"></i>San Stefano Mall, Alexandria</li>
                    </ul>
                </div>
                <!-- Privacy Section -->
                <div id="privacy-section" class="settings-section d-none">
                    <h4 class="text-gold mb-3">Privacy</h4>
                    <p>Manage your privacy settings and data preferences.</p>
                    <form action="{{ route('settings.update') }}" method="POST" id="privacy-form">
                        @csrf
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="dataSharing" name="data_sharing"
                                {{ Auth::user()->data_sharing ? 'checked' : '' }}>
                            <label class="form-check-label" for="dataSharing">Allow sharing my data for personalized offers</label>
                        </div>
                        <button type="submit" class="btn btn-gold mt-3">Save Changes</button>
                    </form>
                </div>
                <!-- Support Section -->
                <div id="support-section" class="settings-section d-none">
                    <h4 class="text-gold mb-3">Support</h4>
                    <p>Contact our support team or check our FAQs.</p>
                    <div>
                        <i class="fas fa-phone"></i> +1-800-123-4567
                    </div>
                    <div>
                        <i class="fas fa-envelope"></i> support@scentshop.com
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
body {
    background-color: #2c1e1e;
    color: #f5f5f5;
}
.settings-card {
    background-color: #2c1e1e;
    border: 1px solid #D4AF37;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.settings-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.2);
}
.text-gold {
    color: #D4AF37 !important;
    font-weight: 600;
}
.settings-sidebar .list-group-item {
    background-color: #231818;
    color: #f5f5f5;
    border: none;
    border-radius: 0;
    margin-bottom: 2px;
    font-weight: 500;
    transition: background 0.2s, color 0.2s;
}
.settings-sidebar .list-group-item.active, .settings-sidebar .list-group-item:focus {
    background-color: #D4AF37;
    color: #2c1e1e;
}
.settings-sidebar .list-group-item:hover {
    background-color: #B38F28;
    color: #2c1e1e;
}
/* Make all text in the settings card gold for better visibility */
.settings-card, .settings-card label, .settings-card p, .settings-card .form-check-label, .settings-card ul, .settings-card li, .settings-card .form-label {
    color: #D4AF37 !important;
}
/* Gold toggle switch for notifications */
.form-switch .form-check-input:checked {
    background-color: #D4AF37 !important;
    border-color: #D4AF37 !important;
    box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25) !important;
}
.form-switch .form-check-input {
    background-color: #231818 !important;
    border-color: #D4AF37 !important;
    box-shadow: none !important;
}
.form-switch .form-check-input:focus {
    box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25) !important;
}
/* Remove blue track by targeting the ::before pseudo-element (for Bootstrap 5) */
.form-switch .form-check-input::before {
    background-color: #231818 !important;
    border-radius: 1rem;
}
.form-switch .form-check-input:checked::before {
    background-color: #D4AF37 !important;
}
/* Make the toggle thumb (circle) white */
.form-switch .form-check-input::after {
    background-color: #fff !important;
    border-radius: 50%;
    box-shadow: none !important;
}
/* Gold checkbox for privacy section */
.form-check-input[type="checkbox"]:checked {
    background-color: #D4AF37 !important;
    border-color: #D4AF37 !important;
}
.form-check-input[type="checkbox"] {
    border-color: #D4AF37 !important;
    background-color: #231818 !important;
}
</style>

<script>
function showSettingsSection(section) {
    // Hide all sections
    document.querySelectorAll('.settings-section').forEach(function(el) {
        el.classList.add('d-none');
    });
    // Remove active from all tabs
    document.querySelectorAll('.settings-sidebar .list-group-item').forEach(function(el) {
        el.classList.remove('active');
    });
    // Show selected section
    document.getElementById(section + '-section').classList.remove('d-none');
    // Set active tab
    document.getElementById(section + '-tab').classList.add('active');
}
// Currency selector logic using localStorage
const currencySelect = document.getElementById('currencySelect');
if (currencySelect) {
    const savedCurrency = localStorage.getItem('currency');
    if (savedCurrency) {
        currencySelect.value = savedCurrency;
    }
    currencySelect.addEventListener('change', function() {
        localStorage.setItem('currency', this.value);
    });
}
// Show Account section by default
showSettingsSection('account');

// Add form submission handlers
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Settings saved successfully!');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    });
});
</script>
@endsection 