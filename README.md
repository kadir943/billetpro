# BilletPro - Application de Vente de Billets d'Événements
> Université de Djibouti | Projet de fin d'études

---

## 📋 Description
Application web complète de gestion et vente de billets d'événements développée avec **Laravel 5.4**.

## 👥 Acteurs du système
| Rôle | Email | Mot de passe |
|------|-------|-------------|
| Administrateur | admin@billetterie.com | admin123 |
| Organisateur | (inscription) | (inscription) |
| Client | (inscription) | (inscription) |

---

## 🚀 Installation

### Prérequis
- PHP >= 5.6.4
- MySQL >= 5.7
- Composer

### Étapes d'installation

**1. Créer la base de données**
```sql
CREATE DATABASE billetterie_evenements;
```

**2. Configurer le fichier .env**
```env
DB_DATABASE=billetterie_evenements
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

**3. Installer les dépendances**
```bash
composer install
```

**4. Générer la clé**
```bash
php artisan key:generate
```

**5. Exécuter les migrations**
```bash
php artisan migrate
```

**6. Insérer les données initiales (admin + catégories)**
```bash
php artisan db:seed
```

**7. Créer le lien symbolique pour les images**
```bash
php artisan storage:link
```

**8. Lancer le serveur**
```bash
php artisan serve
```

**9. Accéder à l'application**
```
http://localhost:8000
```

---

## 🗂️ Structure des URLs

| Espace | URL |
|--------|-----|
| Accueil | `/` |
| Admin - Connexion | `/admin/login` |
| Admin - Dashboard | `/admin/dashboard` |
| Organisateur - Inscription | `/organisateur/register` |
| Organisateur - Dashboard | `/organisateur/dashboard` |
| Client - Inscription | `/client/register` |
| Client - Dashboard | `/client/dashboard` |

---

## ✅ Fonctionnalités implémentées

### Administrateur
- [x] Connexion sécurisée
- [x] Dashboard avec statistiques globales
- [x] Gestion des clients (liste, suppression)
- [x] Gestion des organisateurs (liste, suppression)
- [x] Supervision des événements
- [x] Gestion des catégories
- [x] Liste des billets vendus
- [x] Supervision des paiements
- [x] Statistiques avec graphiques

### Organisateur
- [x] Inscription et connexion
- [x] Dashboard avec stats personnelles
- [x] Créer/Modifier/Supprimer des événements
- [x] Upload d'images pour les événements
- [x] Voir les billets vendus
- [x] Voir les paiements reçus
- [x] Vérification de billets par QR Code
- [x] Modifier le profil

### Client
- [x] Inscription et connexion
- [x] Dashboard personnalisé
- [x] Parcourir les événements
- [x] Filtrer par catégorie, recherche, prix
- [x] Acheter 1 ou plusieurs billets
- [x] Billet électronique avec QR Code unique
- [x] Voir détail d'un billet
- [x] Imprimer un billet
- [x] Laisser un avis/note sur un événement
- [x] Ajouter/retirer des favoris
- [x] Notifications
- [x] Modifier le profil

---

## 🛠️ Technologies utilisées
- **Backend** : Laravel 5.4 (PHP)
- **Base de données** : MySQL
- **Frontend** : Bootstrap 4, Font Awesome 5
- **QR Code** : API qrserver.com
- **Graphiques** : Chart.js

---

## 👨‍💻 Équipe
- KADIR MOHAMED HOUSSEIN
- FATHY ALI MOHAMED
- MOHAMED DIRIR DJAMA
- MOHAMED ABDOURAHMAN DARAR

**Encadré par :** SOULEIMAN MOUMIN BEILEH
