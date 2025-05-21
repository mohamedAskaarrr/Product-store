<nav class="navbar navbar-expand-lg simple-navbar fixed-navbar" style="background-color: #2c1e1e;">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="{{ route('home') }}">
      <i class="fas fa-spray-can me-2 logo-icon"></i><span class="text-primary">Scentora</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('products_list') }}">
            <i class="fas fa-shopping-bag me-1"></i>Shop
          </a>
        </li>            
        <li class="nav-item">
          <a class="nav-link" href="{{ route('about') }}">
            <i class="fas fa-info-circle me-1"></i>About Us
          </a>
        </li>        
        @can('show_users')
        <li class="nav-item">
          <a class="nav-link" href="{{ route('users') }}">
            <i class="fas fa-users me-1"></i>Users
          </a>
        </li>
        @endcan
      </ul>
      <ul class="navbar-nav">
        @guest
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/login') }}">
            <i class="fas fa-sign-in-alt me-1"></i>My Account
          </a>
        </li>
        @else
        <!-- Credit Section -->
        <li class="nav-item d-flex align-items-center me-3">
          <div class="navbar-credit-box d-flex align-items-center px-3 py-1">
            <span class="credit-icon-navbar me-2"><i class="fa-solid fa-wallet"></i></span>
            <span class="credit-label-navbar">Credit:</span>
            <span class="credit-amount-navbar ms-2">${{ number_format(Auth::user()->credit ?? 0, 2) }}</span>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-bs-toggle="dropdown">
            <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end" style="background-color: var(--card-bg);">
            <li>
              <a class="dropdown-item" href="{{ url('/profile') }}">
                <i class="fas fa-id-card me-2"></i>Profile
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ url('/settings') }}">
                <i class="fas fa-cog me-2"></i>Settings
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item" href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
              </a>
              <form id="logout-form" action="{{ url('/logout') }}" method="GET" class="d-none">
                @csrf
              </form>
            </li>
          </ul>
        </li>
        @endguest
        <li class="nav-item ms-2">
          <a class="btn btn-gold" href="{{ route('products.basket') }}">
            <i class="fas fa-shopping-cart me-1"></i>Basket
            @auth
              @php
                $basketCount = \App\Models\Basket::where('user_id', auth()->id())->sum('quantity');
              @endphp
              @if($basketCount > 0)
                <span class="badge bg-danger">{{ $basketCount }}</span>
              @endif
            @endauth
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<style>
  .simple-navbar, .container-fluid, .navbar, .container, body, html {
    background: #2c1e1e !important;
    background-color: #2c1e1e !important;
  }
  .simple-navbar {
    height: 76px;
    min-height: 76px;
    max-height: 76px;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    border-bottom: 2px solid #D4AF37;
    border-radius: 0;
    box-shadow: none;
    transition: background 0.3s;
    display: flex;
    align-items: center;
  }
  body {
    padding-top: 76px !important;
  }
  .container-fluid {
    background: #2c1e1e !important;
    background-color: #2c1e1e !important;
  }
  .navbar-brand {
    color: #fffbe6 !important;
    letter-spacing: 1px;
    font-size: 1.2rem !important;
  }
  .navbar-brand .text-primary {
    color: #D4AF37 !important;
  }
  .navbar-brand .fa-spray-can {
    color: #EEE8D5!important;
  }
  .nav-link, .dropdown-item {
    color: #fffbe6 !important;
    font-weight: 600;
    transition: color 0.2s;
    font-size: 1.1rem !important;
  }
  .nav-link:hover, .dropdown-item:hover {
    color: #D4AF37 !important;
    background: none !important;
  }
  .dropdown-menu {
    background: #2c1e1e;
    border: 1.5px solid #D4AF37;
    border-radius: 10px;
    box-shadow: 0 4px 16px rgba(212,175,55,0.10);
  }
  .btn-gold, .navbar-credit-box {
    background: #D4AF37;
    color: #2c1e1e !important;
    border: none;
    font-weight: 700;
    border-radius: 22px;
    box-shadow: none;
    transition: background 0.2s, color 0.2s;
  }
  .btn-gold:hover {
    background: #B38F28;
    color: #2c1e1e !important;
  }
  .navbar-credit-box {
    border: 2px solid #fffbe6;
    background: #D4AF37;
    color: #2c1e1e;
    font-weight: 700;
    border-radius: 22px;
    box-shadow: none;
    margin-right: 10px;
  }
  .credit-icon-navbar {
    background: #fffbe6;
    color: #D4AF37;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin-right: 6px;
    box-shadow: none;
  }
  .credit-label-navbar {
    color: #D4AF37;
    font-weight: 600;
    margin-right: 2px;
  }
  .credit-amount-navbar {
    color: #2c1e1e;
    font-size: 1.1rem;
    font-weight: 700;
    letter-spacing: 0.5px;
  }
  .navbar-toggler {
    border: 2px solid #D4AF37;
    background: #fffbe6;
    color: #2c1e1e;
    border-radius: 12px;
  }
  .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(212,175,55,0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
  }
  .fixed-navbar {
    position: fixed !important;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1200;
    box-shadow: 0 2px 12px rgba(212, 175, 55, 0.08);
  }
  .navbar, .simple-navbar, .fixed-navbar, .container-fluid {
    height: 76px !important;
    min-height: 76px !important;
    max-height: 76px !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    box-shadow: none !important;
    border-bottom: 2px solid #D4AF37 !important;
    display: flex !important;
    align-items: center !important;
  }
  /* Force consistent navbar and nav-link font sizes everywhere */
  .navbar, .simple-navbar, .fixed-navbar, .container-fluid {
    font-size: 1.1rem !important;
  }
  .navbar-brand, .navbar-brand span, .navbar-brand .text-primary {
    font-size: 1.2rem !important;
    line-height: 1.2 !important;
    font-weight: 700 !important;
  }
  .nav-link, .dropdown-item {
    font-size: 1.1rem !important;
    line-height: 1.2 !important;
    font-weight: 500 !important;
  }
</style>
