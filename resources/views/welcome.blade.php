<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BilletPro - Plateforme de Vente de Billets</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Segoe UI',sans-serif;background:#f8f9fa}

        /* NAVBAR */
        .navbar-pro{background:#fff;padding:0.9rem 2rem;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 15px rgba(0,0,0,0.08);position:sticky;top:0;z-index:100}
        .navbar-brand-pro{font-weight:900;font-size:1.2rem;color:#1a1a2e;text-decoration:none}
        .navbar-brand-pro span{color:#0288d1}
        .navbar-nav-pro{display:flex;gap:24px;align-items:center;list-style:none;margin:0}
        .navbar-nav-pro a{font-size:0.82rem;color:#555;text-decoration:none;font-weight:500;padding-bottom:3px;transition:color 0.2s}
        .navbar-nav-pro a:hover{color:#0288d1}
        .navbar-nav-pro a.active{color:#0288d1;border-bottom:2px solid #0288d1}
        .btn-nav-login{color:#0288d1;font-size:0.82rem;font-weight:600;text-decoration:none;padding:6px 16px;border:2px solid #0288d1;border-radius:20px;transition:all 0.2s}
        .btn-nav-login:hover{background:#0288d1;color:#fff;text-decoration:none}
        .btn-nav-register{background:#0288d1;color:#fff;font-size:0.82rem;font-weight:700;text-decoration:none;padding:8px 18px;border-radius:20px;transition:all 0.2s}
        .btn-nav-register:hover{background:#0077b6;color:#fff;text-decoration:none}

        /* HERO */
        .hero-section{background:linear-gradient(135deg,#0f0c29 0%,#0f3460 55%,#0288d1 100%);padding:5rem 2rem;position:relative;overflow:hidden;min-height:500px;display:flex;align-items:center}
        .hero-section::before{content:'';position:absolute;top:0;left:0;right:0;bottom:0;background:linear-gradient(135deg,rgba(15,12,41,0.96),rgba(2,136,209,0.3))}
        .hero-content{position:relative;z-index:2;max-width:600px}
        .hero-badge{background:rgba(2,136,209,0.2);border:1px solid rgba(2,136,209,0.5);border-radius:20px;padding:5px 16px;display:inline-block;color:#64b5f6;font-size:0.72rem;font-weight:600;margin-bottom:1.2rem}
        .hero-title{color:#fff;font-size:3rem;font-weight:900;line-height:1.1;margin-bottom:0.8rem}
        .hero-title span{color:#64b5f6}
        .hero-subtitle{color:rgba(255,255,255,0.72);font-size:0.95rem;margin-bottom:2rem;line-height:1.7;max-width:480px}
        .search-bar{background:#fff;border-radius:12px;padding:8px 10px;display:flex;align-items:center;gap:10px;max-width:520px;box-shadow:0 15px 50px rgba(0,0,0,0.3)}
        .search-bar .search-field{display:flex;align-items:center;gap:8px;flex:1;padding:0 10px;border-right:1px solid #eee}
        .search-bar .search-field input{border:none;outline:none;font-size:0.82rem;color:#333;width:100%;background:transparent}
        .search-bar .search-field input::placeholder{color:#aaa}
        .search-bar .date-field{display:flex;align-items:center;gap:8px;padding:0 10px;border-right:1px solid #eee}
        .search-bar .date-field input{border:none;outline:none;font-size:0.82rem;color:#333;width:100px;background:transparent}
        .btn-search{background:#0288d1;color:#fff;border:none;border-radius:8px;padding:10px 22px;font-size:0.82rem;font-weight:700;cursor:pointer;white-space:nowrap;transition:background 0.2s}
        .btn-search:hover{background:#0077b6}

        /* STATS BAR */
        .stats-bar{background:#fff;padding:1.5rem 2rem;display:flex;justify-content:center;gap:0;border-bottom:1px solid #eee;box-shadow:0 2px 10px rgba(0,0,0,0.04)}
        .stat-item-pro{text-align:center;padding:0 3rem;border-right:1px solid #eee}
        .stat-item-pro:last-child{border-right:none}
        .stat-item-pro .num{font-size:1.5rem;font-weight:900;color:#0288d1}
        .stat-item-pro .label{font-size:0.72rem;color:#888;margin-top:2px}

        /* SECTIONS */
        .section-title{font-size:1.5rem;font-weight:900;color:#1a1a2e;margin-bottom:4px}
        .section-subtitle{font-size:0.82rem;color:#888;margin-bottom:1.5rem}
        .section-line{width:40px;height:3px;background:#0288d1;border-radius:2px;margin-bottom:8px}

        /* EVENT CARDS */
        .event-card-big{background:linear-gradient(135deg,#1a1a2e,#0f3460);border-radius:16px;padding:2rem;color:#fff;position:relative;overflow:hidden;min-height:260px;display:flex;flex-direction:column;justify-content:flex-end;cursor:pointer;transition:transform 0.2s}
        .event-card-big:hover{transform:translateY(-5px)}
        .event-card-big::before{content:'';position:absolute;top:0;left:0;right:0;bottom:0;background:linear-gradient(to bottom,transparent 30%,rgba(0,0,0,0.85))}
        .event-card-big .content{position:relative;z-index:2}
        .event-card-big .badge-cat{position:absolute;top:16px;left:16px;z-index:2;background:rgba(2,136,209,0.3);border:1px solid rgba(2,136,209,0.5);border-radius:6px;padding:4px 10px;font-size:0.65rem;color:#64b5f6;font-weight:600}
        .event-card-small{background:#fff;border-radius:12px;padding:1rem;display:flex;gap:12px;align-items:center;box-shadow:0 2px 12px rgba(0,0,0,0.07);cursor:pointer;transition:transform 0.2s;text-decoration:none}
        .event-card-small:hover{transform:translateX(5px);box-shadow:0 5px 20px rgba(2,136,209,0.15)}
        .event-icon{width:60px;height:60px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;flex-shrink:0}
        .event-price-badge{border-radius:8px;padding:5px 10px;font-size:0.7rem;font-weight:700;white-space:nowrap}

        /* CATEGORIES */
        .cat-card{border-radius:14px;padding:1.5rem;text-align:center;color:#fff;cursor:pointer;transition:transform 0.2s,box-shadow 0.2s}
        .cat-card:hover{transform:translateY(-5px);box-shadow:0 10px 30px rgba(0,0,0,0.15)}

        /* CTA */
        .cta-section{background:linear-gradient(135deg,#0f0c29,#0288d1);padding:3rem 2rem;text-align:center}

        /* FOOTER */
        .footer-pro{background:#1a1a2e;padding:3rem 2rem 1.5rem;color:rgba(255,255,255,0.6)}
        .footer-title{color:#fff;font-weight:700;font-size:0.85rem;margin-bottom:1rem}
        .footer-link{display:block;font-size:0.75rem;color:rgba(255,255,255,0.55);text-decoration:none;line-height:2.2;transition:color 0.2s}
        .footer-link:hover{color:#0288d1}
        .footer-bottom{border-top:1px solid rgba(255,255,255,0.1);margin-top:2rem;padding-top:1.2rem;display:flex;justify-content:space-between;font-size:0.72rem}

        @media(max-width:768px){
            .hero-title{font-size:2rem}
            .search-bar{flex-direction:column}
            .stat-item-pro{padding:0 1rem}
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-pro">
    <a href="{{ route('home') }}" class="navbar-brand-pro"><i class="fas fa-ticket-alt mr-2" style="color:#0288d1"></i>Billet<span>Pro</span></a>
    <ul class="navbar-nav-pro">
        <li><a href="{{ route('home') }}" class="active">Découvrir</a></li>
        <li><a href="{{ route('login') }}">Événements</a></li>
        <li><a href="{{ route('login') }}">Catégories</a></li>
        <li><a href="{{ route('login') }}">Contact</a></li>
    </ul>
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('login') }}" class="btn-nav-login mr-3"><i class="fas fa-sign-in-alt mr-1"></i>Connexion</a>
        <a href="{{ route('client.register') }}" class="btn-nav-register"><i class="fas fa-user-plus mr-1"></i>Inscription</a>
    </div>
</nav>

<!-- HERO -->
<section class="hero-section">
    <div class="container-fluid">
        <div class="hero-content">
            <div class="hero-badge">🟢 RÉSERVATIONS OUVERTES · 2026</div>
            <h1 class="hero-title">Vivez<br><span>l'Extraordinaire.</span></h1>
            <p class="hero-subtitle">Accédez à des événements exclusifs, des concerts intimistes et des spectacles de classe mondiale sélectionnés juste pour vous à Djibouti.</p>
            <div class="search-bar">
                <div class="search-field">
                    <i class="fas fa-search" style="color:#0288d1"></i>
                    <input type="text" placeholder="Quel événement ?">
                </div>
                <div class="date-field">
                    <i class="fas fa-calendar" style="color:#0288d1"></i>
                    <input type="date" placeholder="Quand ?">
                </div>
                <button class="btn-search"><i class="fas fa-search mr-1"></i>Rechercher</button>
            </div>
        </div>
    </div>
</section>

<!-- STATS BAR -->
<div class="stats-bar">
    <div class="stat-item-pro"><div class="num">10+</div><div class="label">Billets vendus</div></div>
    <div class="stat-item-pro"><div class="num">50+</div><div class="label">Événements</div></div>
    <div class="stat-item-pro"><div class="num">2+</div><div class="label">Organisateurs</div></div>
    <div class="stat-item-pro"><div class="num">50+</div><div class="label">Clients satisfaits</div></div>
</div>

<!-- ÉVÉNEMENTS À VENIR -->
<<section style="padding:3rem 2rem;background:#f8f9fa">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <div class="section-line"></div>
                <div class="section-title">Événements à Venir</div>
                <div class="section-subtitle">Expériences sélectionnées pour vous à Djibouti</div>
            </div>
            <div class="d-flex gap-2">
                <div style="width:36px;height:36px;border:1px solid #ddd;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:0.85rem">←</div>
                <div style="width:36px;height:36px;background:#0288d1;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:0.85rem;color:#fff">→</div>
            </div>
        </div>

        @if($evenements->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-calendar-times fa-3x text-muted mb-3 d-block"></i>
            <p class="text-muted">Aucun événement disponible pour le moment.</p>
            <a href="{{ route('login') }}" class="btn-nav-register">Créer un événement</a>
        </div>
        @else
        <div class="row">
            <div class="col-md-5 mb-4">
                @php $featured = $evenements->first(); @endphp
                <a href="{{ route('login') }}" class="event-card-big text-decoration-none" style="display:flex;min-height:280px">
                    @if($featured->image)
                        <div style="position:absolute;top:0;left:0;right:0;bottom:0;background:url('{{ asset('uploads/events/'.$featured->image) }}') center/cover no-repeat"></div>
                        <div style="position:absolute;top:0;left:0;right:0;bottom:0;background:linear-gradient(to bottom,transparent 20%,rgba(0,0,0,0.85))"></div>
                    @endif
                    <span class="badge-cat">{{ $featured->categorie ? strtoupper($featured->categorie->nom) : 'ÉVÉNEMENT' }}</span>
                    <div class="content">
                        <div style="font-size:0.75rem;color:rgba(255,255,255,0.6);margin-bottom:4px">{{ $featured->date_evenement ? strtoupper(\Carbon\Carbon::parse($featured->date_evenement)->format('d M, Y')) : '-' }}</div>
                        <div style="font-size:1.2rem;font-weight:800;margin-bottom:8px">{{ str_limit($featured->titre, 40) }}</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div style="font-size:0.75rem;color:rgba(255,255,255,0.7)"><i class="fas fa-map-marker-alt mr-1"></i>{{ str_limit($featured->lieu ? $featured->lieu : '-', 25) }}</div>
                            <div style="background:#0288d1;color:#fff;border-radius:20px;padding:5px 14px;font-size:0.72rem;font-weight:700">{{ $featured->prix == 0 ? 'Gratuit' : number_format($featured->prix, 0).' DJF' }}</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-7">
                <div class="d-flex flex-column gap-3">
                    @foreach($evenements->slice(1) as $e)
                    <a href="{{ route('login') }}" class="event-card-small">
                        @if($e->image)
                            <img src="{{ asset('uploads/events/'.$e->image) }}" style="width:60px;height:60px;border-radius:10px;object-fit:cover;flex-shrink:0">
                        @else
                            <div class="event-icon" style="background:linear-gradient(135deg,#0288d1,#0077b6);flex-shrink:0">
                                <i class="fas fa-calendar-alt" style="color:#fff;font-size:1.2rem"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <div style="font-size:0.68rem;color:#0288d1;font-weight:600;margin-bottom:2px">{{ $e->categorie ? strtoupper($e->categorie->nom) : 'ÉVÉNEMENT' }} · {{ $e->date_evenement ? strtoupper(\Carbon\Carbon::parse($e->date_evenement)->format('d M')) : '' }}</div>
                            <div style="font-size:0.9rem;font-weight:700;color:#1a1a2e;margin-bottom:3px">{{ str_limit($e->titre, 35) }}</div>
                            <div style="font-size:0.72rem;color:#888"><i class="fas fa-map-marker-alt mr-1"></i>{{ str_limit($e->lieu ? $e->lieu : '-', 30) }}</div>
                        </div>
                        <div class="event-price-badge" style="background:#e3f2fd;color:#0288d1">{{ $e->prix == 0 ? 'Gratuit' : number_format($e->prix, 0).' DJF' }}</div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" style="display:inline-flex;align-items:center;gap:8px;border:2px solid #0288d1;color:#0288d1;border-radius:25px;padding:10px 28px;font-size:0.85rem;font-weight:700;text-decoration:none">Explorer tous les événements <i class="fas fa-arrow-right"></i></a>
        </div>
        @endif
    </div>
</section>


<!-- CATÉGORIES -->
<section style="padding:3rem 2rem;background:#fff">
    <div class="container-fluid">
        <div class="section-line"></div>
        <div class="section-title">Parcourir par catégorie</div>
        <div class="section-subtitle">Trouvez l'événement qui vous correspond</div>
        <div class="row mt-3">
            <div class="col-6 col-md-3 mb-3">
                <a href="{{ route('login') }}" class="cat-card text-decoration-none" style="background:linear-gradient(135deg,#0288d1,#0077b6);display:block">
                    <div style="font-size:2rem;margin-bottom:8px">🎵</div>
                    <div style="font-size:0.9rem;font-weight:700">Concerts</div>
                    <div style="font-size:0.7rem;opacity:0.8;margin-top:4px">12événements</div>
                </a>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <a href="{{ route('login') }}" class="cat-card text-decoration-none" style="background:linear-gradient(135deg,#4CAF50,#388E3C);display:block">
                    <div style="font-size:2rem;margin-bottom:8px">⚽</div>
                    <div style="font-size:0.9rem;font-weight:700">Sports</div>
                    <div style="font-size:0.7rem;opacity:0.8;margin-top:4px">10événements</div>
                </a>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <a href="{{ route('login') }}" class="cat-card text-decoration-none" style="background:linear-gradient(135deg,#9C27B0,#7B1FA2);display:block">
                    <div style="font-size:2rem;margin-bottom:8px">🎭</div>
                    <div style="font-size:0.9rem;font-weight:700">Théâtre</div>
                    <div style="font-size:0.7rem;opacity:0.8;margin-top:4px">18 événements</div>
                </a>
            </div>
            <div class="col-6 col-md-3 mb-3">
                <a href="{{ route('login') }}" class="cat-card text-decoration-none" style="background:linear-gradient(135deg,#FF9800,#F57C00);display:block">
                    <div style="font-size:2rem;margin-bottom:8px">🎪</div>
                    <div style="font-size:0.9rem;font-weight:700">Festivals</div>
                    <div style="font-size:0.7rem;opacity:0.8;margin-top:4px">9 événements</div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- COMMENT ÇA MARCHE -->
<section style="padding:3rem 2rem;background:#f8f9fa">
    <div class="container-fluid">
        <div class="text-center mb-4">
            <div class="section-line mx-auto"></div>
            <div class="section-title">Comment ça marche ?</div>
            <div class="section-subtitle">Réservez votre billet en 4 étapes simples</div>
        </div>
        <div class="row text-center">
            <div class="col-md-3 mb-3">
                <div style="width:60px;height:60px;background:#0288d1;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.3rem;font-weight:800;margin:0 auto 1rem">1</div>
                <i class="fas fa-user-plus fa-2x mb-3" style="color:#0288d1"></i>
                <h6 class="font-weight-bold">Créez votre compte</h6>
                <p class="text-muted small">Inscription gratuite en quelques secondes</p>
            </div>
            <div class="col-md-3 mb-3">
                <div style="width:60px;height:60px;background:#0288d1;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.3rem;font-weight:800;margin:0 auto 1rem">2</div>
                <i class="fas fa-search fa-2x mb-3" style="color:#0288d1"></i>
                <h6 class="font-weight-bold">Trouvez un événement</h6>
                <p class="text-muted small">Parcourez et filtrez selon vos préférences</p>
            </div>
            <div class="col-md-3 mb-3">
                <div style="width:60px;height:60px;background:#0288d1;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.3rem;font-weight:800;margin:0 auto 1rem">3</div>
                <i class="fas fa-credit-card fa-2x mb-3" style="color:#0288d1"></i>
                <h6 class="font-weight-bold">Achetez votre billet</h6>
                <p class="text-muted small">Paiement sécurisé en ligne</p>
            </div>
            <div class="col-md-3 mb-3">
                <div style="width:60px;height:60px;background:#0288d1;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.3rem;font-weight:800;margin:0 auto 1rem">4</div>
                <i class="fas fa-qrcode fa-2x mb-3" style="color:#0288d1"></i>
                <h6 class="font-weight-bold">Recevez votre QR Code</h6>
                <p class="text-muted small">Billet électronique généré instantanément</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container">
        <h2 style="color:#fff;font-weight:900;margin-bottom:0.5rem">Accès Prioritaire & Exclusif</h2>
        <p style="color:rgba(255,255,255,0.75);margin-bottom:1.5rem">Rejoignez BilletPro pour ne manquer aucun événement à Djibouti</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('client.register') }}" style="background:#fff;color:#0288d1;border-radius:25px;padding:12px 28px;font-size:0.88rem;font-weight:700;text-decoration:none;transition:all 0.2s"><i class="fas fa-user-plus mr-2"></i>S'inscrire gratuitement</a>
            <a href="{{ route('organisateur.register') }}" style="border:2px solid rgba(255,255,255,0.5);color:#fff;border-radius:25px;padding:12px 28px;font-size:0.88rem;font-weight:700;text-decoration:none"><i class="fas fa-calendar-plus mr-2"></i>Créer un événement</a>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer-pro">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div style="font-weight:900;font-size:1.1rem;color:#fff;margin-bottom:0.8rem"><i class="fas fa-ticket-alt mr-2" style="color:#0288d1"></i>Billet<span style="color:#0288d1">Pro</span></div>
                <p style="font-size:0.75rem;line-height:1.8">La plateforme de référence pour la vente et gestion de billets d'événements à Djibouti.</p>
                <div class="d-flex gap-3 mt-2">
                    <i class="fab fa-facebook" style="color:rgba(255,255,255,0.5);font-size:1.1rem;cursor:pointer"></i>
                    <i class="fab fa-twitter" style="color:rgba(255,255,255,0.5);font-size:1.1rem;cursor:pointer"></i>
                    <i class="fab fa-instagram" style="color:rgba(255,255,255,0.5);font-size:1.1rem;cursor:pointer"></i>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="footer-title">PLATEFORME</div>
                <a href="{{ route('home') }}" class="footer-link">Découvrir</a>
                <a href="{{ route('login') }}" class="footer-link">Événements</a>
                <a href="{{ route('login') }}" class="footer-link">Catégories</a>
            </div>
            <div class="col-md-2 mb-3">
                <div class="footer-title">COMPTE</div>
                <a href="{{ route('login') }}" class="footer-link">Connexion</a>
                <a href="{{ route('client.register') }}" class="footer-link">S'inscrire</a>
                <a href="{{ route('organisateur.register') }}" class="footer-link">Organisateur</a>
            </div>
            <div class="col-md-4 mb-3">
                <div class="footer-title">CONTACT</div>
                <p style="font-size:0.75rem;line-height:2"><i class="fas fa-envelope mr-2" style="color:#0288d1"></i>kadirmohamed801@gmail.com</p>
                <p style="font-size:0.75rem;line-height:2"><i class="fas fa-phone mr-2" style="color:#0288d1"></i>+253 77 28 57 02</p>
                <p style="font-size:0.75rem;line-height:2"><i class="fas fa-map-marker-alt mr-2" style="color:#0288d1"></i>Djibouti, République de Djibouti</p>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© 2026 BilletPro — Université de Djibouti</span>
            <div class="d-flex gap-3">
                <span style="cursor:pointer">Conditions</span>
                <span style="cursor:pointer">Confidentialité</span>
                <span style="cursor:pointer">Cookies</span>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
