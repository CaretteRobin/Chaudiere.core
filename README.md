# LaChaudièreAgenda.core
## Membres :  
- ## CARETTE Robin, 
- ## OUDER Nathan,
- ## ANDRIEU Paul,
- ## BLONBOU Mathys,
- ## LAMBERT Valentino

## Fonctionnalités

* **Gestion des événements**

  * Création d’un événement via formulaire (titre, description en Markdown, tarif, dates/durée, horaire, images, catégorie)
  * Transformation de la description Markdown en HTML lors de l’affichage
  * Affichage de la liste des événements triés par date (titre, catégorie, date)
  * Filtrage de la liste des événements par catégorie

* **Gestion des catégories**

  * Création et modification d’une catégorie (libellé, description en Markdown)

* **Gestion des utilisateurs et authentification**

  * Formulaire de connexion (identifiant : email + mot de passe)
  * Contrôle d’accès : seules les personnes authentifiées peuvent créer/modifier des événements

* **API JSON publique**

  1. Récupérer la liste des catégories 

     * **Endpoint** : `GET /api/categories`
     * Retourne la liste de toutes les catégories au format JSON
  2. Récupérer la liste des événements

     * **Endpoint** : `GET /api/evenements`
     * Pour chaque événement : titre, date, catégorie + URL pour le détail
     * Liste triée par date
  3. Récupérer la liste des événements d’une catégorie

     * **Endpoint** : `GET /api/categories/{id}/evenements`
     * Structure identique au précédent (titre, date, catégorie, URL détail)
  4. Récupérer le détail d’un événement

     * **Endpoint** : `GET /api/evenements/{id}`
     * Retourne toutes les informations complètes (description HTML, tarif, horaires, images, etc.)
  5. Filtrer les événements par période

     * **Endpoint** : `GET /api/evenements?periode=<passee,courante,futur>`
     * Paramètre `periode` combinable pour inclure événements passés, en cours ou futurs

