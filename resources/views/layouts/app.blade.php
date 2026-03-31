<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BilletPro - Vente de Billets')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary: #ad9ddd;
            --primary-dark: #5428d4;
            --secondary: #F97316;
            --dark: #f5f5fa;
            --light-bg: #f8f9ff;
        }
        body { background: var(--light-bg); font-family: 'Segoe UI', sans-serif; }

        /* NAVBAR */
        .navbar-main {
            background: linear-gradient(135deg, var(--dark) 0%, #fa1ed9 100%);
            box-shadow: 0 2px 20px rgba(218, 60, 155, 0.3);
            padding: 0.8rem 0;
        }
        .navbar-brand { font-weight: 800; font-size: 1.5rem; color: #fff !important; }
        .navbar-brand span { color: var(--secondary); }
        .nav-link { color: rgba(255,255,255,0.85) !important; font-weight: 500; transition: color 0.2s; }
        .nav-link:hover { color: var(--secondary) !important; }
        .btn-nav-primary {
            background: var(--primary); color: #fff !important; border-radius: 25px;
            padding: 0.4rem 1.2rem !important; font-weight: 600;
        }
        .btn-nav-primary:hover { background: var(--primary-dark); }

        /* SIDEBAR */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--dark) 0%, #2653cd 100%);
            width: 260px; position: fixed; top: 0; left: 0; z-index: 100;
            box-shadow: 3px 0 20px rgba(38, 121, 223, 0.2);
            transition: all 0.3s;
        }
        .sidebar-brand {
            padding: 1.5rem; font-size: 1.3rem; font-weight: 800;
            color: #fff; border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; gap: 10px;
        }
        .sidebar-brand span { color: var(--secondary); }
        .sidebar-nav { padding: 1rem 0; }
        .sidebar-nav .nav-link {
            color: rgba(255,255,255,0.75) !important; padding: 0.8rem 1.5rem;
            display: flex; align-items: center; gap: 12px;
            border-left: 3px solid transparent; transition: all 0.2s; font-size: 0.95rem;
        }
        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            color: #fff !important; background: rgba(108,61,244,0.25);
            border-left-color: var(--primary);
        }
        .sidebar-nav .nav-link i { width: 20px; text-align: center; font-size: 1rem; }
        .sidebar-section {
            padding: 0.5rem 1.5rem; font-size: 0.7rem; font-weight: 700;
            color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px; margin-top: 0.5rem;
        }

        /* MAIN CONTENT */
        .main-content { margin-left: 260px; padding: 2rem; min-height: 100vh; }

        /* CARDS */
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 15px rgba(0,0,0,0.07); }
        .card-header { border-radius: 12px 12px 0 0 !important; font-weight: 600; }
        .stat-card {
            border-radius: 15px; color: #fff; padding: 1.5rem;
            position: relative; overflow: hidden;
        }
        .stat-card .icon { font-size: 2.5rem; opacity: 0.25; position: absolute; right: 1rem; top: 1rem; }
        .stat-card .value { font-size: 2rem; font-weight: 800; }
        .stat-card .label { font-size: 0.9rem; opacity: 0.9; }

        /* TABLES */
        .table { border-radius: 10px; overflow: hidden; }
        .table thead th { background: var(--primary); color: #fff; border: none; font-weight: 600; }
        .table-hover tbody tr:hover { background: rgba(108,61,244,0.05); }

        /* BUTTONS */
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .btn-rounded { border-radius: 25px; padding: 0.5rem 1.5rem; font-weight: 600; }

        /* BADGES */
        .badge-valide   { background: #28a745; color: #fff; }
        .badge-utilise  { background: #6c757d; color: #fff; }
        .badge-annule   { background: #dc3545; color: #fff; }
        .badge-reussi   { background: #28a745; color: #fff; }
        .badge-en_attente { background: #442fe0; color: #f2f1f4; }
        .badge-echoue   { background: #dc3545; color: #fff; }

        /* ALERTS */
        .alert { border-radius: 10px; border: none; }

        /* EVENT CARD */
        .event-card { border-radius: 15px; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s; }
        .event-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(108,61,244,0.2); }
        .event-card .card-img-top { height: 180px; object-fit: cover; }
        .event-card .event-img-placeholder {
            height: 180px; background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex; align-items: center; justify-content: center; color: #fff; font-size: 3rem;
        }
        .event-price { background: var(--secondary); color: #fff; padding: 0.3rem 0.8rem; border-radius: 20px; font-weight: 700; }

        /* TOP NAVBAR (dashboard) */
        .top-navbar {
            background: #fff; box-shadow: 0 1px 10px rgba(0,0,0,0.07);
            padding: 0.8rem 2rem; display: flex; align-items: center;
            justify-content: space-between; margin: -2rem -2rem 2rem -2rem;
        }
        .user-avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: var(--primary); color: #fff; display: flex;
            align-items: center; justify-content: center; font-weight: 700;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; }
        }

        /* FOOTER */
        .footer-main {
            background: var(--dark); color: rgba(255,255,255,0.7);
            padding: 2rem 0; margin-top: 3rem; text-align: center;
        }
    </style>
    @yield('styles')
</head>
<body>
@yield('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
