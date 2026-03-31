<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Organisateur - BilletPro')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Segoe UI',sans-serif;background:#f4f6f9;display:flex;min-height:100vh}

        /* SIDEBAR */
        .sidebar{width:230px;background:#fff;border-right:0.5px solid #e0e7ef;display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh;z-index:100}
        .sidebar-brand{padding:1.2rem 1.4rem;border-bottom:0.5px solid #e0e7ef;display:flex;align-items:center;gap:10px}
        .sidebar-brand .logo-icon{width:34px;height:34px;background:#0288d1;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px}
        .sidebar-brand .logo-text{font-size:14px;font-weight:600;color:#0f1824}
        .sidebar-brand .logo-sub{font-size:10px;color:#0288d1}
        .sidebar-nav{padding:1rem 0.8rem;flex:1;overflow-y:auto}
        .nav-section-title{font-size:10px;color:#a0aec0;padding:0 0.6rem;margin-bottom:6px;letter-spacing:0.8px;font-weight:600;text-transform:uppercase}
        .nav-item-pro{padding:9px 12px;display:flex;align-items:center;gap:10px;margin-bottom:2px;border-radius:8px;cursor:pointer;text-decoration:none;transition:all 0.2s}
        .nav-item-pro:hover{background:#f4f6f9;text-decoration:none}
        .nav-item-pro.active{background:#e3f2fd;text-decoration:none}
        .nav-item-pro .nav-icon{width:22px;height:22px;background:#f4f6f9;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0}
        .nav-item-pro.active .nav-icon{background:#0288d1;color:#fff}
        .nav-item-pro .nav-label{font-size:13px;color:#4a5568}
        .nav-item-pro.active .nav-label{color:#0288d1;font-weight:500}
        .nav-item-pro .nav-badge{margin-left:auto;border-radius:10px;padding:2px 7px;font-size:10px;font-weight:500}
        .nav-item-pro.danger .nav-label{color:#e53e3e}
        .nav-item-pro.danger .nav-icon{background:#fff0f0}
        .sidebar-footer{padding:1rem 1.2rem;border-top:0.5px solid #e0e7ef}
        .user-info{display:flex;align-items:center;gap:10px}
        .user-avatar{width:36px;height:36px;border-radius:50%;background:#0288d1;display:flex;align-items:center;justify-content:center;font-size:13px;color:#fff;font-weight:500;flex-shrink:0}
        .user-name{font-size:12px;font-weight:500;color:#0f1824}
        .user-role{font-size:10px;color:#a0aec0}
        .user-status{margin-left:auto;width:8px;height:8px;background:#48bb78;border-radius:50%}
        .sidebar-cta{padding:1rem 1.2rem;border-top:0.5px solid #e0e7ef}

        /* MAIN */
        .main-content{margin-left:230px;flex:1;display:flex;flex-direction:column;min-height:100vh}
        .top-bar{background:#fff;border-bottom:0.5px solid #e0e7ef;padding:0.9rem 1.8rem;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:50}
        .top-bar-title{font-size:17px;font-weight:600;color:#0f1824}
        .top-bar-sub{font-size:12px;color:#a0aec0;margin-top:1px}
        .page-content{padding:1.5rem 1.8rem;flex:1}

        /* BUTTONS */
        .btn-primary-pro{background:#0288d1;color:#fff;border:none;border-radius:8px;padding:8px 16px;font-size:12px;font-weight:500;display:flex;align-items:center;gap:6px;cursor:pointer;text-decoration:none;transition:background 0.2s}
        .btn-primary-pro:hover{background:#0277bd;color:#fff;text-decoration:none}
        .btn-secondary-pro{background:#e3f2fd;color:#0288d1;border:none;border-radius:8px;padding:8px 14px;font-size:12px;font-weight:500;display:flex;align-items:center;gap:6px;cursor:pointer;text-decoration:none;transition:background 0.2s}
        .btn-secondary-pro:hover{background:#bbdefb;color:#0288d1;text-decoration:none}
        .btn-notif{width:36px;height:36px;border-radius:8px;background:#f4f6f9;border:0.5px solid #e0e7ef;display:flex;align-items:center;justify-content:center;font-size:15px;cursor:pointer;position:relative}

        /* STAT CARDS */
        .stat-card{background:#fff;border:0.5px solid #e0e7ef;border-radius:12px;padding:1.1rem;position:relative;overflow:hidden}
        .stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;border-radius:12px 12px 0 0}
        .stat-card.blue::before{background:#0288d1}
        .stat-card.green::before{background:#48bb78}
        .stat-card.orange::before{background:#ed8936}
        .stat-card.purple::before{background:#9f7aea}
        .stat-label{font-size:11px;color:#a0aec0;margin-bottom:8px;font-weight:500;text-transform:uppercase;letter-spacing:0.5px}
        .stat-value{font-size:26px;font-weight:600;color:#0f1824;margin-bottom:4px}
        .stat-badge-up{font-size:11px;background:#e8f5e9;color:#2e7d32;padding:2px 6px;border-radius:4px}
        .stat-badge-down{font-size:11px;background:#fff0e6;color:#c05621;padding:2px 6px;border-radius:4px}
        .stat-badge-neutral{font-size:11px;background:#faf5ff;color:#6b46c1;padding:2px 6px;border-radius:4px}
        .stat-progress{background:#f4f6f9;border-radius:4px;height:3px;margin-top:8px}
        .stat-progress-bar{height:3px;border-radius:4px;background:#0288d1}

        /* TABLE */
        .pro-table{width:100%;border-collapse:collapse}
        .pro-table thead tr{background:#f8fafc}
        .pro-table thead th{padding:9px 14px;text-align:left;font-size:10px;color:#a0aec0;font-weight:500;letter-spacing:0.5px;text-transform:uppercase;border-bottom:0.5px solid #f0f4f8}
        .pro-table tbody tr{border-bottom:0.5px solid #f0f4f8;transition:background 0.15s}
        .pro-table tbody tr:hover{background:#f8fafc}
        .pro-table tbody td{padding:11px 14px;font-size:12px;color:#0f1824}
        .event-icon-cell{width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
        .status-badge{border-radius:6px;padding:3px 10px;font-size:11px;font-weight:500}
        .status-active{background:#e8f5e9;color:#2e7d32}
        .status-coming{background:#e3f2fd;color:#0277bd}
        .status-draft{background:#f4f6f9;color:#718096}
        .status-annule{background:#fff0f0;color:#e53e3e}
        .action-btn{border-radius:6px;padding:4px 8px;font-size:11px;cursor:pointer;border:none}
        .action-edit{background:#e3f2fd;color:#0288d1}
        .action-delete{background:#fff0f0;color:#e53e3e}

        /* ALERTS */
        .alert{border-radius:8px;border:none;font-size:13px}
        .alert-success{background:#e8f5e9;color:#2e7d32}
        .alert-danger{background:#fff0f0;color:#c62828}
        .alert-warning{background:#fff3e0;color:#e65100}

        /* CARDS */
        .pro-card{background:#fff;border:0.5px solid #e0e7ef;border-radius:12px;overflow:hidden}
        .pro-card-header{padding:1rem 1.2rem;border-bottom:0.5px solid #f0f4f8;display:flex;justify-content:space-between;align-items:center;background:#f8fafc}
        .pro-card-title{font-size:14px;font-weight:500;color:#0f1824}
        .pro-card-body{padding:1.2rem}

        /* FORM */
        .form-control{border:0.5px solid #e0e7ef;border-radius:8px;padding:0.6rem 1rem;font-size:13px;transition:border-color 0.2s}
        .form-control:focus{border-color:#0288d1;box-shadow:none;outline:none}
        label{font-size:12px;font-weight:500;color:#4a5568;margin-bottom:4px}

        /* PAGINATION */
        .pagination .page-link{border-color:#e0e7ef;color:#0288d1;font-size:13px}
        .pagination .page-item.active .page-link{background:#0288d1;border-color:#0288d1}
    </style>
    @yield('styles')
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-brand">
        <div class="logo-icon">🎫</div>
        <div>
            <div class="logo-text">BilletPro</div>
            <div class="logo-sub">Organisateur Pro</div>
        </div>
    </div>

    <div class="sidebar-cta">
        <a href="{{ route('organisateur.evenements.create') }}" class="btn-primary-pro" style="justify-content:center;width:100%">
            <i class="fas fa-plus"></i> Créer un événement
        </a>
    </div>

    <div class="sidebar-nav">
        <div class="nav-section-title">Principal</div>
        <a href="{{ route('organisateur.dashboard') }}" class="nav-item-pro {{ request()->routeIs('organisateur.dashboard') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-chart-line" style="font-size:11px"></i></div>
            <span class="nav-label">Tableau de bord</span>
        </a>
        <a href="{{ route('organisateur.evenements') }}" class="nav-item-pro {{ request()->routeIs('organisateur.evenements*') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-calendar-alt" style="font-size:11px"></i></div>
            <span class="nav-label">Mes événements</span>
        </a>

        <div class="nav-section-title mt-3">Ventes</div>
        <a href="{{ route('organisateur.billets') }}" class="nav-item-pro {{ request()->routeIs('organisateur.billets') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-ticket-alt" style="font-size:11px"></i></div>
            <span class="nav-label">Billets vendus</span>
        </a>
        <a href="{{ route('organisateur.paiements') }}" class="nav-item-pro {{ request()->routeIs('organisateur.paiements') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-credit-card" style="font-size:11px"></i></div>
            <span class="nav-label">Paiements</span>
        </a>

        <div class="nav-section-title mt-3">Outils</div>
        <a href="{{ route('organisateur.verification') }}" class="nav-item-pro {{ request()->routeIs('organisateur.verification') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-qrcode" style="font-size:11px"></i></div>
            <span class="nav-label">Scanner QR Code</span>
        </a>

        <div class="nav-section-title mt-3">Compte</div>
        <a href="{{ route('organisateur.profil') }}" class="nav-item-pro {{ request()->routeIs('organisateur.profil') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-user" style="font-size:11px"></i></div>
            <span class="nav-label">Mon profil</span>
        </a>
        <a href="{{ route('organisateur.logout') }}" class="nav-item-pro danger">
            <div class="nav-icon"><i class="fas fa-sign-out-alt" style="font-size:11px"></i></div>
            <span class="nav-label">Déconnexion</span>
        </a>
    </div>

    <div class="sidebar-footer">
        <div class="user-info">
           @if(session('organisateur_photo'))
    <img src="{{ asset('uploads/profils/' . session('organisateur_photo')) }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;flex-shrink:0">
@else
    <div class="user-avatar">{{ strtoupper(substr(session('organisateur_nom','O'),0,2)) }}</div>
@endif
            <div>
                <div class="user-name">{{ session('organisateur_nom','Organisateur') }}</div>
                <div class="user-role">Organisateur</div>
            </div>
            <div class="user-status"></div>
        </div>
    </div>
</div>

<!-- MAIN -->
<div class="main-content">
    <div class="top-bar">
        <div>
            <div class="top-bar-title">@yield('page-title','Dashboard')</div>
            <div class="top-bar-sub">@yield('page-subtitle','')</div>
        </div>
        <div class="d-flex align-items-center gap-2">
            @yield('top-actions')
            <a href="{{ route('organisateur.verification') }}" class="btn-secondary-pro ml-2">
                <i class="fas fa-qrcode"></i> Scanner QR
            </a>
            <a href="{{ route('organisateur.evenements.create') }}" class="btn-primary-pro ml-2">
                <i class="fas fa-plus"></i> Créer un événement
            </a>
            <div class="btn-notif ml-2">
                <i class="fas fa-bell" style="color:#a0aec0;font-size:14px"></i>
            </div>
        </div>
    </div>

    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show mb-3">
                {{ session('warning') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif
        @yield('content')
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>