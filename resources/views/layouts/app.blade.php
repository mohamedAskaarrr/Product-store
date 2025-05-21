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
            --navbar-bg: #2c1e1e;
            --navbar-text: #D4AF37;
            --dropdown-bg: #2c1e1e;
            --dropdown-text: #D4AF37;
            --dropdown-hover-bg: #3a2a2a;
            --dropdown-hover-text: #D4AF37;
            --border-color: #D4AF37;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color) !important;
            color: var(--text-color);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        /* Form Styles */
        .form-control, .form-select {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-color);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background-color: var(--card-bg);
            border-color: var(--primary-color);
            color: var(--text-color);
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
        }

        .form-label {
            color: var(--text-color);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        /* Button Styles */
        .btn-gold {
            background-color: var(--primary-color);
            color: var(--background-color);
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-gold:hover {
            background-color: var(--secondary-color);
            color: var(--background-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(212, 175, 55, 0.2);
        }

        .btn-outline-gold {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-outline-gold:hover {
            background-color: var(--primary-color);
            color: var(--background-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(212, 175, 55, 0.2);
        }

        /* Card Styles */
        .card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        }

        .card-header {
            background-color: rgba(212, 175, 55, 0.1);
            border-bottom: 1px solid var(--border-color);
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Navigation Styles */
        .navbar {
            background-color: var(--navbar-bg);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .nav-link {
            color: var(--navbar-text) !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            transform: translateY(-2px);
        }

        /* Dropdown Styles */
        .dropdown-menu {
            background-color: var(--dropdown-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .dropdown-item {
            color: var(--dropdown-text);
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: var(--dropdown-hover-bg);
            color: var(--dropdown-hover-text);
        }

        /* Auth Pages Styles */
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .auth-card {
            width: 100%;
            max-width: 450px;
            padding: 2rem;
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-header h1 {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        /* Footer Styles */
        footer {
            background-color: var(--background-color) !important;
            color: var(--primary-color) !important;
            padding: 2rem 0;
            margin-top: 3rem;
            border-top: 1px solid var(--border-color);
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .auth-container {
                padding: 1rem;
            }

            .auth-card {
                padding: 1.5rem;
            }

            .btn-gold, .btn-outline-gold {
                width: 100%;
                margin-bottom: 1rem;
            }

            .navbar-nav {
                padding: 1rem 0;
            }
        }
    </style>
</head>
<body>
    @include('layouts.scentora-menu')

    <main class="py-4">
        @yield('content')
    </main>

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