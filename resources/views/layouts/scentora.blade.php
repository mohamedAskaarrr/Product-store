<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Scentora - Luxury Perfumes')</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- AOS Animation Library -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  @role('Customer')
<div class="container my-3">
    <a href="{{ route('products.fav') }}" class="btn btn-outline-primary btn-gold">
        <i class="fas fa-heart me-1"></i> View Favourites
    </a>
</div>
@endrole


  <style>
    :root {
      --primary-color: #D4AF37;
      --secondary-color: #333;
      --accent-color: #B38F28;
      --text-color: #333;
      --light-bg: #f8f9fa;
      --dark-bg: #343a40;
      --card-bg: #ffffff;
      --card-shadow: 0 4px 6px rgba(0,0,0,0.1);
      --navbar-bg: #ffffff;
      --navbar-text: #333;
      --dropdown-bg: #ffffff;
      --dropdown-text: #333;
      --dropdown-hover-bg: #f8f9fa;
      --dropdown-hover-text: #D4AF37;
      --border-color: #dee2e6;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--light-bg);
      color: var(--text-color);
    }

    .btn-gold {
      background-color: #D4AF37;
      color: #000;
      border: none;
      transition: all 0.3s ease;
    }
    
    .btn-gold:hover {
      background-color: #B38F28;
      color: #000;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    footer {
      background-color: var(--secondary-color);
      color: white;
      padding: 2rem 0;
      margin-top: 3rem;
    }
  </style>
</head>
<body>
  @include('layouts.scentora-menu')

  <div class="container py-4">
    @yield('main-content')
  </div>

  <footer class="text-center">
    <div class="container">
      <p class="mb-0">Scentora &copy; {{ date('Y') }} — Luxury Perfumes</p>
    </div>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
      });
    });
  </script>
</body>
</html> 