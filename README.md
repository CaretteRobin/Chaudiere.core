# La Chaudière - Backend API

Ce projet constitue la partie serveur de l’application La Chaudière, réalisée dans le cadre de la SAE S4 DWM. Il s’agit d’une API RESTful développée en PHP avec le microframework Slim et Eloquent ORM, en respectant une architecture logicielle claire et modulaire.

## Objectif

Proposer une API pour la gestion d’un agenda culturel local, permettant d’administrer, consulter, filtrer, trier et publier des événements via un backend structuré. L’API est conçue pour interagir avec un front web et une application mobile Flutter.

---

## Fonctionnalités réalisées

L'ensemble des fonctionnalités prévues dans le sujet ont été intégralement développées :

1. **Lister tous les événements publiés**
    - Endpoint : `/api/evenements`
    - Trie par date croissante par défaut

2. **Filtrer les événements par période**
    - Périodes : passée, actuelle, à venir
    - Exemple : `/api/evenements?periode=actuelle`

3. **Filtrer les événements par catégorie**
    - Exemple : `/api/evenements?categorie=Concert`

4. **Rechercher un événement par son titre exact**
    - Exemple : `/api/evenements?title=Rock à La Chaudière`

5. **Afficher le détail complet d’un événement**
    - Endpoint : `/api/evenements/{id}`
    - Retourne tous les champs, y compris l’image et l’utilisateur créateur

6. **Créer un événement (avec validation)**
    - Endpoint : `/api/evenements` (POST)
    - Champs : titre, description, prix, date, heure, catégorie, etc.

7. **Publier/dépublier un événement**
    - Utilisateur authentifié uniquement
    - Changement du champ `is_published`

8. **Supprimer un événement (soft delete)**
    - Modification du champ `is_deleted`

9. **Associer une image à un événement**
    - Chaque événement peut posséder une image stockée localement
    - Récupérée dans l’attribut `image_url` de l’API

10. **Tri des événements via l’API**
    - `/api/evenements?sort=titre`
    - `/api/evenements?sort=date-asc`
    - `/api/evenements?sort=date-desc`
    - `/api/evenements?sort=categorie`

---

## Fonctionnalités supplémentaires

En plus des exigences du cahier des charges, les éléments suivants ont été ajoutés :

- Intégration des images d’événements via une table `images` en base de données, liées aux événements par une clé étrangère.
- Retour de l’URL de l’image dans toutes les routes concernées.
- Gestion centralisée des erreurs (404, 500) avec messages JSON adaptés.
- Système de validation de données en entrée.
- Structure d’URL REST claire et cohérente.

---

## Architecture du projet

Le projet suit une architecture hexagonale (ou ports & adapters), séparée en plusieurs couches distinctes :

### 1. Couche `webui/`

Contient les actions Slim (routes) qui capturent la requête HTTP, la transmettent au service adéquat, et retournent une réponse JSON.

- `actions/Event/` : actions liées aux événements (`GetSortedEventsAction`, `CreateEventAction`, etc.)
- `actions/Auth/` : connexion, inscription (si présent)

### 2. Couche `core/`

Regroupe le cœur métier de l’application :

- `domain/` : entités (Event, Category, User, Image)
- `application/` :
    - `services/` : logique métier combinée (EventService)
    - `usecase/` : cas d’utilisation unitaires
    - `dto/` : objets de transfert de données
    - `exception/` : exceptions personnalisées

### 3. Couche `infra/`

Fournit les implémentations concrètes :

- `persistence/Eloquent/` : Repositories basés sur Eloquent ORM
- `model/` : Modèles Eloquent mappés sur les tables SQL

### 4. `config/`

Contient :
- Le container de dépendances PHP-DI
- La configuration des routes
- La configuration Eloquent

---

## Technologies utilisées

- PHP 8+
- Slim Framework 4
- Eloquent ORM (Illuminate)
- Composer (autoloader & dépendances)
- MySQL
- PHP-DI
- Faker (pour peuplement de données de test)

---

## Base de données

Le projet utilise une base MySQL comportant les tables suivantes :

- `events`
- `categories`
- `users`
- `images`

Les relations sont assurées via des UUIDs (`CHAR(36)`), et les timestamps (`created_at`) sont générés automatiquement.

---

## Lancement du projet

1. Installer les dépendances PHP via Composer :

```bash
composer install
```

2. Configurer la base de données dans `.env` ou `config/database.php`

3. Lancer le serveur de développement :

```bash
php -S localhost:8000 -t public
```

4. Accéder à l’API :

```
http://localhost:8000/api/evenements
```

---

## Auteur

Projet réalisé par un groupe d'étudiants de BUT Informatique - Parcours DWM, dans le cadre de la SAE S4.

