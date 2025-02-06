# Eventbrite

## Contexte du projet

Ce projet vise à concevoir un clone avancé de la plateforme Eventbrite en utilisant PHP MVC, PostgreSQL et AJAX pour la gestion d'événements. L'objectif est de créer un système complet permettant aux organisateurs de gérer leurs événements, aux participants de réserver des billets et aux administrateurs de superviser l'ensemble du processus.

### Fonctionnalités principales

#### 1. Gestion des utilisateurs
- Inscription et connexion sécurisée (email, mot de passe hashé avec bcrypt)
- Gestion des rôles : Organisateur, Participant, Admin
- Profil utilisateur (avatar, nom, historique des événements créés/participés)
- Notifications (email, alertes sur le site)

#### 2. Gestion des événements
- Création et modification d'événements (titre, description, date, lieu, prix, capacité)
- Gestion des catégories et tags (Conférence, Concert, Sport, etc.)
- Ajout d'images et vidéos promotionnelles
- Validation des événements par un administrateur
- Mise en avant des événements (sponsorisés)

#### 3. Réservation et paiement
- Achat de billets (gratuit, payant, VIP, early bird)
- Paiement sécurisé via Stripe ou PayPal (sandbox mode)
- Génération de QR Code pour validation des billets à l'entrée
- Système de remboursement et annulation de billets
- Téléchargement de billets en PDF après achat

#### 4. Tableau de bord organisateur
- Liste des événements créés (actif, en attente, terminé)
- Statistiques des ventes et des réservations en temps réel
- Export des participants en CSV/PDF
- Gestion des promotions (codes promo, early bird)

#### 5. Back-office Admin
- Gestion des utilisateurs (bannissement, suppression, modification)
- Gestion des événements (validation, suppression, modification)
- Statistiques globales (nombre d'utilisateurs, billets vendus, revenus)
- Modération des commentaires et signalements

#### 6. Interactions dynamiques avec AJAX
- Chargement dynamique des événements (pagination sans rechargement)
- Recherche et filtres avancés (par catégorie, prix, date, lieu)
- Autocomplétion des recherches avec suggestions
- Validation de formulaire en temps réel (email déjà utilisé, mot de passe sécurisé)

## Technologies utilisées

### Backend
- **PHP 8.x** - Gestion du backend
- **PostgreSQL** - Base de données relationnelle optimisée
- **PDO** - Sécurisation des requêtes SQL
- **Twig** - Moteur de templates
- **Composer** - Gestionnaire de dépendances PHP

### Frontend
- **HTML5, CSS3, JavaScript (ES6)** - Interface utilisateur
- **Bootstrap 5** ou **TailwindCSS** - Design responsive
- **AJAX (Fetch API, jQuery)** - Chargement dynamique

### Sécurité et Outils
- **.htaccess** - Sécurisation et réécriture d'URL
- **Session Based Authentication** - Authentification sécurisée (optionnel)
- **Validator & Security classes** - Protection contre XSS, CSRF, SQL Injection
- **Session Management** - Gestion des sessions sécurisées

### Prérequis
1. PHP 8.x
2. PostgreSQL
3. Composer
4. Serveur Web (Apache ou Nginx)
   
### Installation
1. Clonez le repository :
    ```bash
    git clone https://github.com/Salma-007/Eventbrite
    ```

2. Installez les dépendances via Composer :
    ```bash
    cd eventbrite-clone
    composer install
    ```

3. Configurez votre base de données PostgreSQL et mettez à jour les paramètres dans le fichier `.env`.

4. Créez la base de données et les tables en exécutant les migrations :
    ```bash
    php bin/console migrate
    ```

5. Configurez le serveur web (Apache/Nginx) pour pointer vers le dossier `public/`.

6. Lancez le serveur localement (par exemple avec PHP built-in server) :
    ```bash
    php -S localhost:8000 -t public
    ```

## Auteurs

- **Nom de l'auteur** - [Salma El Allali](https://github.com/Salma-007)
- **Collaborateurs** - [Mhamed Ait Hssaine](https://github.com/mhamedaithssaine), [Yahya Afadisse](https://github.com/YahyaAf)

