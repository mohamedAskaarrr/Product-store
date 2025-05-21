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


  <style>
    :root {
      --primary-color: #D4AF37;
      --secondary-color: #2c1e1e;
      --accent-color: #B38F28;
      --text-color: #D4AF37;
      --light-bg: #2c1e1e;
      --dark-bg: #2c1e1e;
      --card-bg: #2c1e1e;
      --card-shadow: 0 4px 6px rgba(0,0,0,0.1);
      --navbar-bg: #2c1e1e;
      --navbar-text: #D4AF37;
      --dropdown-bg: #2c1e1e;
      --dropdown-text: #D4AF37;
      --dropdown-hover-bg: #2c1e1e;
      --dropdown-hover-text: #D4AF37;
      --border-color: #D4AF37;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #2c1e1e !important;
      color: #D4AF37 !important;
    }

    .main-center-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
    }

    .container {
      background: none !important;
      box-shadow: none !important;
      border-radius: 0 !important;
      padding: 0 !important;
    }

    .btn-gold {
      background-color: #D4AF37;
      color: #2c1e1e;
      border: none;
      transition: all 0.3s ease;
    }
    
    .btn-gold:hover {
      background-color: #2c1e1e;
      color: #D4AF37;
      border: 1px solid #D4AF37;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(212,175,55,0.1);
    }

    footer {
      background-color: #2c1e1e !important;
      color: #D4AF37 !important;
      padding: 2rem 0;
      margin-top: 3rem;
    }
  </style>
</head>
<body>
  @include('layouts.scentora-menu')

  <div class="main-center-wrapper">
    <div class="container py-4">
      @yield('main-content')
    </div>
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
