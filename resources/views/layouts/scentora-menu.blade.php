<nav class="navbar navbar-expand-lg simple-navbar fixed-top">
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
        @can('show_users')
        <li class="nav-item">
          <a class="nav-link" href="{{route('cryptography')}}">
            <i class="fas fa-shield-alt me-1"></i>Cryptography
          </a>
        </li>
        @endcan
      </ul>
      <ul class="navbar-nav">
        @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
              <i class="fas fa-user-circle me-1"></i>{{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
              <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form action="{{ route('do_logout') }}" method="POST">
                  @csrf
                  <button type="submit" class="dropdown-item text-danger">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                  </button>
                </form>
              </li>
            </ul>
          </li>
        @else
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">
              <i class="fas fa-sign-in-alt me-1"></i>Login
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">
              <i class="fas fa-user-plus me-1"></i>Register
            </a>
          </li>
        @endauth
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
  .simple-navbar {
    background: rgba(44, 30, 30, 0.95) !important;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-bottom: 2px solid rgba(212, 175, 55, 0.3);
    height: 76px;
    min-height: 76px;
    max-height: 76px;
    padding: 0;
    transition: all 0.3s ease;
    z-index: 1030;
  }

  .navbar-brand {
    color: #fffbe6 !important;
    letter-spacing: 1px;
    font-size: 1.4rem !important;
    padding: 0.5rem 1rem;
    border-radius: 12px;
    transition: all 0.3s ease;
  }

  .navbar-brand:hover {
    background: rgba(212, 175, 55, 0.1);
    transform: translateY(-2px);
  }

  .navbar-brand .text-primary {
    color: #D4AF37 !important;
    font-weight: 700;
  }

  .navbar-brand .logo-icon {
    color: #D4AF37 !important;
    font-size: 1.2rem;
  }

  .nav-link {
    color: #fffbe6 !important;
    font-weight: 500;
    padding: 0.7rem 1.2rem !important;
    border-radius: 12px;
    transition: all 0.3s ease;
    font-size: 1.05rem !important;
  }

  .nav-link:hover {
    color: #D4AF37 !important;
    background: rgba(212, 175, 55, 0.1);
    transform: translateY(-2px);
  }

  .dropdown-menu {
    background: rgba(44, 30, 30, 0.95);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(212, 175, 55, 0.3);
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    padding: 0.5rem;
  }

  .dropdown-item {
    color: #fffbe6;
    padding: 0.7rem 1rem;
    border-radius: 8px;
    transition: all 0.3s ease;
  }

  .dropdown-item:hover {
    background: rgba(212, 175, 55, 0.1);
    color: #D4AF37;
    transform: translateX(5px);
  }

  .dropdown-divider {
    border-color: rgba(212, 175, 55, 0.2);
    margin: 0.5rem 0;
  }

  .btn-gold {
    background: linear-gradient(135deg, #D4AF37 0%, #B38F28 100%);
    color: #2c1e1e !important;
    border: none;
    font-weight: 600;
    padding: 0.7rem 1.5rem;
    border-radius: 12px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(212, 175, 55, 0.2);
  }

  .btn-gold:hover {
    background: linear-gradient(135deg, #B38F28 0%, #D4AF37 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
  }

  .badge {
    padding: 0.35em 0.65em;
    font-size: 0.75em;
    font-weight: 600;
    border-radius: 8px;
  }

  .navbar-toggler {
    border: 2px solid rgba(212, 175, 55, 0.3);
    padding: 0.5rem;
    border-radius: 12px;
    transition: all 0.3s ease;
  }

  .navbar-toggler:hover {
    border-color: #D4AF37;
    background: rgba(212, 175, 55, 0.1);
  }

  .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(212, 175, 55, 0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
  }

  @media (max-width: 991.98px) {
    .navbar-collapse {
      background: rgba(44, 30, 30, 0.95);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-radius: 12px;
      padding: 1rem;
      margin-top: 1rem;
      border: 1px solid rgba(212, 175, 55, 0.3);
    }

    .nav-link {
      padding: 0.8rem 1rem !important;
    }

    .btn-gold {
      width: 100%;
      margin-top: 0.5rem;
    }
  }
</style>
