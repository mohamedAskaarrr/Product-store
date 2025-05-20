<nav class="navbar navbar-expand-lg" style="background-color: var(--light-bg);">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold fs-3" href="{{ route('home') }}">
      <i class="fas fa-spray-can me-2 text-success"></i><span class="text-primary">Scentora</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        @can('purchase_products')
        <li class="nav-item">
          <a class="nav-link" href="{{ route('products_list') }}">
            <i class="fas fa-shopping-bag me-1"></i>Shop
          </a>
        </li>
        @endcan
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/about') }}">
            <i class="fas fa-info-circle me-1"></i>About Us
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/products') }}">
            <i class="fas fa-spray-can me-1"></i>Fragrances
          </a>
        </li>
      </ul>
      <ul class="navbar-nav">
        @guest
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/login') }}">
            <i class="fas fa-sign-in-alt me-1"></i>My Account
          </a>
        </li>
        @else
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
        @can('purchase_products')
        <li class="nav-item ms-2">
          <a class="btn btn-gold" href="{{ route('products.basket') }}">
            <i class="fas fa-shopping-cart me-1"></i>Basket
          </a>
        </li>
        @endcan
      </ul>
    </div>
  </div>
</nav>

<style>
  .btn-gold {
    background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
    color: #fff;
    border: none;
    transition: all 0.3s ease;
    border-radius: 25px;
    padding: 8px 16px;
  }

  .btn-gold:hover {
    background: var(--primary-color);
    color: white;
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
  }

  .navbar-brand {
    font-family: 'Poppins', sans-serif;
    letter-spacing: 1px;
    color: var(--primary-color) !important;
  }

  .nav-link {
    font-weight: 500;
    color: var(--text-color) !important;
    transition: color 0.3s ease, transform 0.3s ease;
  }

  .nav-link:hover {
    color: var(--primary-color) !important;
    transform: translateY(-2px);
  }

  .dropdown-menu {
    border-radius: 10px;
    box-shadow: 0px 8px 20px rgba(0,0,0,0.1);
  }

  .dropdown-item {
    color: var(--text-color);
    transition: background-color 0.3s ease;
  }

  .dropdown-item:hover {
    background-color: var(--primary-color);
    color: white;
  }
</style>

@auth
  <span style="color: green;">You are logged in</span>
@endauth
@guest
  <span style="color: red;">You are a guest</span>
@endguest
