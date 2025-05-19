<nav class="navbar navbar-expand-lg fixed-navbar" style="background-color: #2c1e1e;">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold fs-3" href="{{ route('home') }}">
      <i class="fas fa-spray-can me-2 text-success"></i><span class="text-primary">Scentora</span>
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
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/products') }}">
            <i class="fas fa-spray-can me-1"></i>Fragrances
          </a>
        </li>
        @role('Admin')
        <li class="nav-item">
          <a class="nav-link" href="{{ route('users') }}">
            <i class="fas fa-users me-1"></i>Users
          </a>
        </li>
        @endrole
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
  .navbar {
    background-color: #2c1e1e !important;
  }

  .nav-link {
    color: #f5f5f5 !important;
    font-weight: 500;
    transition: color 0.3s ease, transform 0.3s ease;
  }

  .nav-link:hover {
    color: #D4AF37 !important;
    transform: translateY(-2px);
  }

  .navbar-brand {
    color: #D4AF37 !important;
  }

  .dropdown-menu {
    background-color: #2c1e1e;
    border: 1px solid #D4AF37;
  }

  .dropdown-item {
    color: #222;
  }

  .dropdown-item:hover {
    background-color: #D4AF37;
    color: #222;
  }

  .btn-gold {
    background-color: #D4AF37;
    color: #2c1e1e;
    border: none;
    transition: all 0.3s ease;
  }

  .btn-gold:hover {
    background-color: #B38F28;
    color: #2c1e1e;
    transform: scale(1.05);
  }

  .navbar-credit-box {
    background: #2c1e1e;
    border: 1.5px solid #D4AF37;
    border-radius: 18px;
    color: #D4AF37;
    font-weight: 600;
    font-size: 1rem;
    box-shadow: 0 2px 8px rgba(212, 175, 55, 0.10);
  }
  .credit-icon-navbar {
    background: linear-gradient(135deg, #D4AF37 60%, #b89b76 100%);
    color: #2c1e1e;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin-right: 6px;
  }
  .credit-label-navbar {
    color: #D4AF37;
    font-weight: 600;
    margin-right: 2px;
  }
  .credit-amount-navbar {
    color: #fffbe6;
    font-size: 1.1rem;
    font-weight: 700;
    letter-spacing: 0.5px;
  }
  .fixed-navbar {
    position: fixed !important;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1200;
    box-shadow: 0 2px 12px rgba(212, 175, 55, 0.08);
  }
  body {
    padding-top: 76px; /* Adjust to match navbar height */
  }
</style>
