<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Askarr Store')</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Lodash -->
  <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- AOS Animation Library -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <style>
    :root {
      --primary-color: #D4AF37;
      --secondary-color: #B38F28;
      --background-color: #2c1e1e;
      --text-color: #f5f5f5;
      --card-bg: #3a2a2a;
      --accent-color: #FFC107;
      --light-bg: #f8f9fa;
      --dark-bg: #343a40;
      --success-color: #28a745;
      --danger-color: #dc3545;
      --warning-color: #ffc107;
      --info-color: #17a2b8;
      --card-shadow: 0 4px 6px rgba(0,0,0,0.1);
      --navbar-bg: #ffffff;
      --navbar-text: #333;
      --dropdown-bg: #ffffff;
      --dropdown-text: #333;
      --dropdown-hover-bg: #f8f9fa;
      --dropdown-hover-text: #4CAF50;
      --border-color: #dee2e6;
    }
    [data-theme="dark"] {
      --primary-color: #66bb6a;
      --secondary-color: #42a5f5;
      --accent-color: #ffca28;
      --text-color: #e0e0e0;
      --light-bg: #121212;
      --dark-bg: #1e1e1e;
      --success-color: #4caf50;
      --danger-color: #f44336;
      --warning-color: #ff9800;
      --info-color: #03a9f4;
      --card-bg: #1e1e1e;
      --card-shadow: 0 4px 6px rgba(0,0,0,0.3);
      --navbar-bg: #1e1e1e;
      --navbar-text: #e0e0e0;
      --dropdown-bg: #1e1e1e;
      --dropdown-text: #e0e0e0;
      --dropdown-hover-bg: #2d2d2d;
      --dropdown-hover-text: #66bb6a;
      --border-color: #333;
    }
    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--background-color);
      color: var(--text-color);
      min-height: 100vh;
      margin: 0;
      padding: 0;
    }
    .navbar {
      background-color: var(--navbar-bg);
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      padding: 1rem 0;
      transition: background-color 0.3s ease;
    }
    .navbar-brand {
      font-weight: 600;
      color: var(--primary-color);
    }
    .nav-link {
      font-weight: 500;
      color: var(--navbar-text) !important;
      transition: color 0.3s ease;
    }
    .nav-link:hover {
      color: var(--primary-color) !important;
    }
    .dropdown-menu {
      border: none;
      box-shadow: var(--card-shadow);
      border-radius: 8px;
      background-color: var(--dropdown-bg);
      transition: background-color 0.3s ease;
    }
    .dropdown-item {
      padding: 0.5rem 1.5rem;
      transition: all 0.3s ease;
      color: var(--dropdown-text);
    }
    .dropdown-item:hover {
      background-color: var(--dropdown-hover-bg);
      color: var(--dropdown-hover-text);
    }
    .card {
      border: none;
      border-radius: 12px;
      box-shadow: var(--card-shadow);
      transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
      background-color: var(--card-bg);
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 12px rgba(0,0,0,0.15);
    }
    .btn {
      border-radius: 8px;
      padding: 0.5rem 1.5rem;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    .btn-primary {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
    }
    .btn-primary:hover {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
      transform: translateY(-2px);
      opacity: 0.9;
    }
    .alert {
      border-radius: 8px;
      border: none;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .fade-in {
      animation: fadeIn 0.5s ease forwards;
    }
    @media (max-width: 768px) {
      .navbar-nav {
        padding: 1rem 0;
      }
      .card-deck {
        display: block;
      }
      .card {
        margin-bottom: 1rem;
      }
    }
    [data-theme="dark"] .table {
      color: var(--text-color);
    }
    [data-theme="dark"] .table thead th {
      background-color: var(--dark-bg);
      color: var(--text-color);
    }
    [data-theme="dark"] .table tbody tr {
      background-color: var(--card-bg);
    }
    [data-theme="dark"] .table tbody tr:hover {
      background-color: var(--dropdown-hover-bg);
    }
    [data-theme="dark"] .form-control {
      background-color: var(--card-bg);
      border-color: var(--border-color);
      color: var(--text-color);
    }
    [data-theme="dark"] .form-control:focus {
      background-color: var(--card-bg);
      border-color: var(--primary-color);
      color: var(--text-color);
    }
    [data-theme="dark"] .form-select {
      background-color: var(--card-bg);
      border-color: var(--border-color);
      color: var(--text-color);
    }
    [data-theme="dark"] .form-select:focus {
      background-color: var(--card-bg);
      border-color: var(--primary-color);
      color: var(--text-color);
    }
    [data-theme="dark"] .modal-content {
      background-color: var(--card-bg);
      color: var(--text-color);
    }
    [data-theme="dark"] .modal-header {
      border-bottom-color: var(--border-color);
    }
    [data-theme="dark"] .modal-footer {
      border-top-color: var(--border-color);
    }
    [data-theme="dark"] .pagination .page-link {
      background-color: var(--card-bg);
      border-color: var(--border-color);
      color: var(--text-color);
    }
    [data-theme="dark"] .pagination .page-item.active .page-link {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
      color: white;
    }
    [data-theme="dark"] .pagination .page-link:hover {
      background-color: var(--dropdown-hover-bg);
      color: var(--primary-color);
    }
    .login-fullscreen {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: var(--background-color);
    }
    .spline-3d-float {
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 50vw;
      height: 80vh;
      pointer-events: none;
      z-index: 1;
    }
    .login-left, .login-form-wrapper {
      position: relative;
      z-index: 2;
    }
    .login-left {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 2;
      padding-left: 0;
    }
    .login-form-wrapper {
      width: 100%;
      max-width: 400px;
      background: #000 !important;
      border: 1.5px solid #222 !important;
      box-shadow: none !important;
    }
    .form-control-dark, .input-group-text-dark {
      background: #111 !important;
      color: #fff !important;
      border: 1.5px solid #222 !important;
    }
    .btn-custom-primary {
      background: #111 !important;
      color: #fff !important;
      border: 1.5px solid #222 !important;
    }
    .btn-custom-primary:hover {
      background: #222 !important;
      color: #fff !important;
    }
    .register-fullscreen {
      display: none;
    }
    .register-left, .register-right {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .register-right {
    }
    .container {
      min-height: calc(100vh - 76px);
      padding: 2rem 0;
    }
  </style>
  @yield('head')
</head>
<body>
  @include('layouts.scentora-menu')
  
  @if (Request::is('login'))
    @yield('content')
  @else
    <div class="container">
      @yield('content')
    </div>
  @endif

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
      });
      const darkModeToggle = document.getElementById('darkModeToggle');
      const htmlElement = document.documentElement;
      const savedTheme = localStorage.getItem('theme') || 'light';
      htmlElement.setAttribute('data-theme', savedTheme);
      updateDarkModeIcon(savedTheme);
      if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function(e) {
          e.preventDefault();
          const currentTheme = htmlElement.getAttribute('data-theme');
          const newTheme = currentTheme === 'light' ? 'dark' : 'light';
          htmlElement.setAttribute('data-theme', newTheme);
          localStorage.setItem('theme', newTheme);
          updateDarkModeIcon(newTheme);
        });
      }
      function updateDarkModeIcon(theme) {
        if (darkModeToggle) {
          const icon = darkModeToggle.querySelector('i');
          if (theme === 'dark') {
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
            darkModeToggle.innerHTML = '<i class="fas fa-sun me-2"></i>Light Mode';
          } else {
            icon.classList.remove('fa-sun');
            icon.classList.add('fa-moon');
            darkModeToggle.innerHTML = '<i class="fas fa-moon me-2"></i>Dark Mode';
          }
        }
      }
    });
  </script>
  @stack('scripts')
</body>
</html>
