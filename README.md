# PlanMaison3D - Plateforme de Vente de Plans de Maisons

## 1. Aperçu du Projet

**PlanMaison3D** est une application web développée avec Laravel 11 qui permet aux utilisateurs de parcourir, d'acheter et de télécharger des plans de maisons modernes. Elle s'adresse à la fois aux particuliers cherchant l'inspiration pour leur future maison et aux professionnels du bâtiment.

Le projet intègre une interface d'administration complète pour la gestion des contenus et des ventes, ainsi qu'un blog pour partager des conseils et des tendances.

## 2. Fonctionnalités Clés

### Pour les Visiteurs et Clients :
- **Catalogue de Plans** : Navigation et recherche parmi une large gamme de plans de maisons.
- **Visualisation 360°** : Visionneuse interactive pour explorer les plans en 3D.
- **Panier d'Achat** : Système de panier simple et efficace.
- **Blog** : Articles et conseils sur la construction et le design.
- **Formulaire de Contact** : Pour toute demande d'information.

### Pour les Administrateurs :
- **Tableau de Bord** : Vue d'ensemble des statistiques clés (ventes, utilisateurs, articles).
- **Gestion des Plans** : CRUD complet pour les plans de maisons.
- **Gestion du Blog** : CRUD pour les articles, catégories et tags.
- **Gestion des Coupons** : Création et gestion de codes promotionnels.

## 3. Structure Technique

- **Framework** : Laravel 11.x
- **Frontend** : Blade, Bootstrap 5, Tailwind CSS (pour la navigation), Vite.js
- **Base de Données** : MySQL

### Structure des Dossiers Principaux :
- `app/Http/Controllers` : Sépare la logique pour l'Admin, l'API, et le site public.
- `app/Models` : Contient tous les modèles Eloquent avec leurs relations.
- `resources/views` : Vues Blade, organisées par fonctionnalité (admin, blog, auth, etc.).
- `routes/web.php` : Regroupe toutes les routes de l'application.

## 4. Installation

1.  **Cloner le dépôt** :
    ```bash
    git clone https://votre-repository/PlanMaison3D.git
    cd PlanMaison3D
    ```

2.  **Installer les dépendances** :
    ```bash
    composer install
    npm install
    ```

3.  **Configurer l'environnement** :
    - Copiez `.env.example` en `.env`.
    - Configurez votre base de données (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

4.  **Générer la clé d'application** :
    ```bash
    php artisan key:generate
    ```

5.  **Lancer les migrations et les seeders** :
    ```bash
    php artisan migrate:fresh --seed
    ```

6.  **Compiler les assets** :
    ```bash
    npm run build
    ```

7.  **Lier le stockage** :
    ```bash
    php artisan storage:link
    ```

## 5. Utilisation

- **Accès au site** : `http://localhost:8000`
- **Accès à l'administration** : `http://localhost:8000/admin`

Pour créer un utilisateur administrateur, vous pouvez utiliser le seeder ou modifier manuellement le rôle d'un utilisateur dans la base de données (`role = 'admin'`).

## 6. Points Clés du Code

- **Route Model Binding** : Les modèles `Post` et `HousePlan` utilisent le `slug` comme clé de route pour des URLs plus propres.
- **Middleware d'Administration** : `app/Http/Middleware/AdminMiddleware.php` protège les routes de l'administration.
- **Services** : Le `CartService` gère la logique du panier d'achat.
- **Composants Blade** : Le logo et les éléments de navigation sont des composants réutilisables.
