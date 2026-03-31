<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Employé - BilletPro')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Segoe UI',sans-serif;background:#f4f6f9;display:flex;min-height:100vh}
        .sidebar{width:220px;background:#fff;border-right:0.5px solid #e0e7ef;display:flex;flex-direction:column;position:fixed;top:0;left:0;height:100vh;z-index:100}
        .sidebar-brand{padding:1.2rem 1.4rem;border-bottom:0.5px solid #e0e7ef;display:flex;align-items:center;gap:10px}
        .logo-icon{width:34px;height:34px;background:#0288d1;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px}
        .logo-text{font-size:14px;font-weight:600;color:#0f1824}
        .logo-sub{font-size:9px;color:#a0aec0;text-transform:uppercase;letter-spacing:0.5px}
        .sidebar-nav{padding:1rem 0.8rem;flex:1;overflow-y:auto}
        .nav-item-pro{padding:9px 12px;display:flex;align-items:center;gap:10px;margin-bottom:2px;border-radius:8px;cursor:pointer;text-decoration:none;transition:all 0.2s}
        .nav-item-pro:hover{background:#f4f6f9;text-decoration:none}
        .nav-item-pro.active{background:#e3f2fd;text-decoration:none}
        .nav-item-pro .nav-icon{width:22px;height:22px;background:#f4f6f9;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:11px;flex-shrink:0}
        .nav-item-pro.active .nav-icon{background:#0288d1;color:#fff}
        .nav-item-pro .nav-label{font-size:13px;color:#4a5568}
        .nav-item-pro.active .nav-label{color:#0288d1;font-weight:500}
        .nav-item-pro.danger .nav-label{color:#e53e3e}
        .nav-item-pro.danger .nav-icon{background:#fff0f0}
        .sidebar-footer{padding:0.8rem 1.2rem;border-top:0.5px solid #e0e7ef}
        .main-content{margin-left:220px;flex:1;display:flex;flex-direction:column;min-height:100vh}
        .top-bar{background:#fff;border-bottom:0.5px solid #e0e7ef;padding:0.8rem 1.8rem;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:50}
        .top-bar-title{font-size:17px;font-weight:600;color:#0f1824}
        .page-content{padding:1.5rem 1.8rem;flex:1}
        .btn-primary-pro{background:#0288d1;color:#fff;border:none;border-radius:8px;padding:8px 16px;font-size:12px;font-weight:500;display:inline-flex;align-items:center;gap:6px;cursor:pointer;text-decoration:none;transition:background 0.2s}
        .btn-primary-pro:hover{background:#0277bd;color:#fff;text-decoration:none}
        .btn-secondary-pro{background:#e3f2fd;color:#0288d1;border:none;border-radius:8px;padding:8px 14px;font-size:12px;font-weight:500;display:inline-flex;align-items:center;gap:6px;cursor:pointer;text-decoration:none}
        .stat-card{background:#fff;border:0.5px solid #e0e7ef;border-radius:12px;padding:1.1rem}
        .stat-label{font-size:11px;color:#a0aec0;margin-bottom:6px;font-weight:500}
        .stat-value{font-size:24px;font-weight:600;color:#0f1824}
        .pro-card{background:#fff;border:0.5px solid #e0e7ef;border-radius:12px;overflow:hidden}
        .pro-card-header{padding:1rem 1.2rem;border-bottom:0.5px solid #f0f4f8;display:flex;justify-content:space-between;align-items:center;background:#f8fafc}
        .pro-card-title{font-size:14px;font-weight:500;color:#0f1824}
        .pro-table{width:100%;border-collapse:collapse}
        .pro-table thead tr{background:#f8fafc}
        .pro-table thead th{padding:9px 14px;text-align:left;font-size:10px;color:#a0aec0;font-weight:500;letter-spacing:0.5px;text-transform:uppercase;border-bottom:0.5px solid #f0f4f8}
        .pro-table tbody tr{border-bottom:0.5px solid #f0f4f8;transition:background 0.15s}
        .pro-table tbody tr:hover{background:#f8fafc}
        .pro-table tbody td{padding:11px 14px;font-size:12px;color:#0f1824}
        .action-btn{border-radius:6px;padding:4px 8px;font-size:11px;cursor:pointer;border:none}
        .action-edit{background:#e3f2fd;color:#0288d1}
        .action-delete{background:#fff0f0;color:#e53e3e}
        .status-badge{border-radius:6px;padding:3px 10px;font-size:11px;font-weight:500}
        .status-active{background:#e8f5e9;color:#2e7d32}
        .status-pending{background:#fff3e0;color:#e65100}
        .status-cancelled{background:#fff0f0;color:#e53e3e}
        .alert{border-radius:8px;border:none;font-size:13px}
        .alert-success{background:#e8f5e9;color:#2e7d32}
        .alert-danger{background:#fff0f0;color:#c62828}
        .form-control{border:0.5px solid #e0e7ef;border-radius:8px;padding:0.6rem 1rem;font-size:13px}
        .form-control:focus{border-color:#0288d1;box-shadow:none;outline:none}
        label{font-size:12px;font-weight:500;color:#4a5568;margin-bottom:4px}
    </style>
    @yield('styles')
</head>
<body>
<div class="sidebar">
    <div class="sidebar-brand">
        <div class="logo-icon">✅</div>
        <div>
            <div class="logo-text">BilletPro</div>
            <div class="logo-sub">Espace Vérificateur</div>
        </div>
    </div>
    <div class="sidebar-nav">
        <a href="{{ route('employe.dashboard') }}" class="nav-item-pro {{ request()->routeIs('employe.dashboard') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-chart-line" style="font-size:11px"></i></div>
            <span class="nav-label">Tableau de bord</span>
        </a>
        <a href="{{ route('employe.paiements') }}" class="nav-item-pro {{ request()->routeIs('employe.paiements*') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-credit-card" style="font-size:11px"></i></div>
            <span class="nav-label">Paiements</span>
        </a>
        <a href="{{ route('employe.profil') }}" class="nav-item-pro {{ request()->routeIs('employe.profil') ? 'active' : '' }}">
            <div class="nav-icon"><i class="fas fa-user" style="font-size:11px"></i></div>
            <span class="nav-label">Mon profil</span>
        </a>
        <a href="{{ route('employe.logout') }}" class="nav-item-pro danger">
            <div class="nav-icon"><i class="fas fa-sign-out-alt" style="font-size:11px"></i></div>
            <span class="nav-label">Déconnexion</span>
        </a>
    </div>
    <div class="sidebar-footer">
        <div style="display:flex;align-items:center;gap:10px">
            <div style="width:32px;height:32px;border-radius:50%;background:#0288d1;display:flex;align-items:center;justify-content:center;font-size:12px;color:#fff;font-weight:500">{{ strtoupper(substr(session('employe_nom','E'),0,2)) }}</div>
            <div>
                <div style="font-size:12px;font-weight:500;color:#0f1824">{{ session('employe_nom','Employé') }}</div>
                <div style="font-size:10px;color:#a0aec0">Vérificateur</div>
            </div>
        </div>
    </div>
</div>
<div class="main-content">
    <div class="top-bar">
        <div class="top-bar-title">@yield('page-title','Dashboard')</div>
        <div class="d-flex align-items-center gap-2">
            <div style="width:32px;height:32px;border-radius:50%;background:#0288d1;display:flex;align-items:center;justify-content:center;font-size:12px;color:#fff;font-weight:500">{{ strtoupper(substr(session('employe_nom','E'),0,2)) }}</div>
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
        @yield('content')
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>