<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title') | Task Manager </title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo-circle.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Menambahkan Mona Sans dari GitHub Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mona+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>

    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #3b82f6;
            --secondary-color: #10b981;
            --sidebar-width: 80px;
            --sidebar-expanded-width: 250px;
            --topnav-height: 70px;
            --transition-speed: 0.3s;
        }
        
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            background-color: #f8fafc;
            font-family: "Mona Sans", "Noto Sans", sans-serif !important;
            transition: margin-left var(--transition-speed) ease;
        }

        .btn {
            padding: .25rem .5rem !important;
            font-size: .875rem !important;
        }

        /* ========== SIDEBAR STYLES ========== */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            color: white;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            transition: all var(--transition-speed) ease;
            position: relative;
            z-index: 1000;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            overflow-x: hidden;
        }

        /* Default: collapsed */
        .navbar-nav {
            margin-right: 80px; /* sama dengan var(--sidebar-width) */
            transition: margin-right var(--transition-speed) ease;
        }

        /* Kalau sidebar expanded */
        .sidebar.expanded ~ .content .topnav .navbar-nav {
            margin-right: 250px; /* sama dengan var(--sidebar-expanded-width) */
        }

        .sidebar.expanded {
            width: var(--sidebar-expanded-width);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 16px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-family: "Mona Sans", "Noto Sans", sans-serif;
            transition: all 0.2s ease;
            position: relative;
            white-space: nowrap;
            overflow: hidden;
            border-left: 4px solid transparent;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.05) 100%);
            padding-left: 25px;
            border-left-color: var(--secondary-color);
        }

        .sidebar .nav-link .bi {
            margin-right: 15px;
            font-size: 1.3rem;
            min-width: 24px;
            transition: transform 0.2s ease;
        }

        .sidebar .nav-link:hover .bi {
            transform: scale(1.15);
            color: var(--secondary-color);
        }

        .sidebar .logo-container {
            padding: 20px 15px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            transition: all var(--transition-speed) ease;
            background: rgba(0, 0, 0, 0.1);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar .logo-full {
            display: none;
            filter: brightness(0) invert(1);
            max-width: 180px;
            transition: opacity 0.3s ease;
        }

        .sidebar .logo-mini {
            display: block;
            filter: brightness(0) invert(1);
            max-width: 40px;
            transition: opacity 0.3s ease;
        }

        .sidebar.expanded .logo-full {
            display: block;
        }

        .sidebar.expanded .logo-mini {
            display: none;
        }

        /* Sidebar toggle button - Dipindahkan ke navbar */
        .sidebar-toggle {
            background-color: transparent;
            color: var(--primary-dark);
            border: none;
            border-radius: 4px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-right: 10px;
        }

        .sidebar-toggle:hover {
            background-color: rgba(37, 99, 235, 0.1);
        }

        /* Memperbesar ukuran ikon toggle */
        .sidebar-toggle .bi {
            font-size: 1.5rem;
        }

        /* ========== CONTENT AREA ========== */
        .content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            transition: all var(--transition-speed) ease;
        }

        /* ========== TOP NAVIGATION ========== */
        .topnav {
            flex-shrink: 0;
            width: 100%;
            background: linear-gradient(90deg, #ffffff 0%, #f9fafb 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05) !important;
            height: var(--topnav-height);
            padding: 0 1.5rem;
        }

        .navbar-brand {
            font-weight: 600;
            color: var(--primary-dark);
            font-family: "Mona Sans", "Noto Sans", sans-serif;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
        }

        .navbar-nav .nav-link {
            color: #4b5563;
            font-family: "Mona Sans", "Noto Sans", sans-serif;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-color);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-radius: 8px;
            padding: 0.5rem;
        }

        .dropdown-item {
            border-radius: 6px;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f1f5f9;
            color: var(--primary-dark);
        }

        /* User dropdown specific styles */
        #userDropdown {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        #userDropdown:hover {
            background-color: #f1f5f9;
        }

        /* ========== CARDS & CONTENT ========== */
        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05) !important;
            border-radius: 12px;
        }

        /* ========== FOOTER ========== */
        footer {
            background-color: #ffffff;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05) !important;
            flex-shrink: 0;
        }

        main {
            flex-grow: 1;
            padding: 0 1.5rem 1.5rem;
            margin-top: 100px;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: "Mona Sans", "Noto Sans", sans-serif;
        }
        
        footer, footer a {
            font-family: "Mona Sans", "Noto Sans", sans-serif;
        }

        /* Animation for menu items */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Memastikan nav-item selalu terlihat */
        .sidebar .nav-item {
            opacity: 1;
            transform: translateX(0);
        }

       /* Text akan tersembunyi saat sidebar collapsed */
        .nav-text {
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .sidebar.expanded .nav-text {
            opacity: 1;
        }
        
        .sidebar .nav-item:nth-child(1) { animation-delay: 0.05s; }
        .sidebar .nav-item:nth-child(2) { animation-delay: 0.1s; }
        .sidebar .nav-item:nth-child(3) { animation-delay: 0.15s; }
        .sidebar .nav-item:nth-child(4) { animation-delay: 0.2s; }
        .sidebar .nav-item:nth-child(5) { animation-delay: 0.25s; }
        .sidebar .nav-item:nth-child(6) { animation-delay: 0.3s; }
        .sidebar .nav-item:nth-child(7) { animation-delay: 0.35s; }
        .sidebar .nav-item:nth-child(8) { animation-delay: 0.4s; }
        .sidebar .nav-item:nth-child(9) { animation-delay: 0.45s; }

        .sidebar.expanded .nav-item {
            opacity: 1;
            transform: translateX(0);
        }
        
        .badge-on-bell {
            position: absolute;
            top: 2px; /* Turunkan posisi badge */
            right: -4px; /* Geser sedikit ke kiri agar rapi */
            transform: translate(0, 0); /* Hilangkan translate-middle untuk kontrol lebih */
            font-size: 0.65rem; /* Kurangi ukuran font jika badge terlalu besar */
            padding: 2px 6px; /* Sesuaikan padding agar lebih kecil */
        }

        /* Notification badge (optional) */
        .nav-badge {
            position: absolute;
            right: 15px;
            background-color: var(--secondary-color);
            color: white;
            border-radius: 10px;
            padding: 2px 6px;
            font-size: 0.7rem;
            font-weight: bold;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                position: fixed;
                height: 100%;
                z-index: 1000;
            }
            
            .sidebar.expanded {
                width: var(--sidebar-expanded-width);
            }
            
            .content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    @include('layouts.partials.sidebar')
    
    <div class="content d-flex flex-column">
        @include('layouts.partials.navbar')
        
        <main>
            @yield('content')
        </main>
        
        @include('layouts.partials.footer')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateDateTime() {
            const now = new Date();
            // Changed day names to Indonesian
            const dayNames = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const day = dayNames[now.getDay()];
            
            // Format date in Indonesian style
            const date = now.toLocaleDateString('id-ID', { 
                day: 'numeric', 
                month: 'long', 
                year: 'numeric' 
            });
            
            const time = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });

            document.getElementById('currentDateTime').innerText = `${day}, ${date}  ${time}`;
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);

        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const toggleIcon = document.getElementById('toggleIcon');
            
            // Check if sidebar state is saved in localStorage
            const isSidebarExpanded = localStorage.getItem('sidebarExpanded') === 'true';
            
            // Set initial state
            if (isSidebarExpanded) {
                sidebar.classList.add('expanded');
                toggleIcon.classList.remove('bi-list');
                toggleIcon.classList.add('bi-x');
            }
            
            // Toggle sidebar on button click
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('expanded');
                
                // Update icon
                if (sidebar.classList.contains('expanded')) {
                    toggleIcon.classList.remove('bi-list');
                    toggleIcon.classList.add('bi-x');
                    localStorage.setItem('sidebarExpanded', 'true');
                } else {
                    toggleIcon.classList.remove('bi-x');
                    toggleIcon.classList.add('bi-list');
                    localStorage.setItem('sidebarExpanded', 'false');
                }
            });
        });
    </script>
</body>

</html>