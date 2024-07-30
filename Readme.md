```markdown
# Symfony Application

Ce projet est une application web développée avec le framework Symfony.

## Prérequis

- PHP 8.0 ou supérieur
- Composer
- Symfony CLI (optionnel, mais recommandé)
- Une base de données (MySQL, PostgreSQL, etc.)

## Installation

1. **Cloner le dépôt :**

   ```sh
   git clone https://github.com/votre-utilisateur/votre-projet.git
   cd votre-projet
   ```

2. **Installer les dépendances :**

   ```sh
   composer install
   ```

3. **Configurer les variables d'environnement :**
   Copier le fichier `.env-example` et renommez-le en `.env` :

   ```sh
   cp .env-example .env
   ```

   Modifier le fichier `.env` pour y ajouter les informations de connexion à votre base de données :

   ```dotenv
   DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
   ```

## Création des migrations

1. **Générer une migration :**

   Si vous avez apporté des modifications à vos entités et que vous souhaitez générer une nouvelle migration :

   ```sh
   php bin/console make:migration
   ```

2. **Exécuter les migrations :**

   Pour appliquer les migrations à la base de données :

   ```sh
   php bin/console doctrine:migrations:migrate
   ```

## Lancer l'application

1. **Démarrer le serveur de développement :**

   Vous pouvez utiliser la commande Symfony CLI pour démarrer le serveur de développement :

   ```sh
   symfony server:start
   ```

   Ou utiliser la commande PHP intégrée :

   ```sh
   php -S localhost:8000 -t public
   ```

2. **Accéder à l'application :**

   Ouvrez votre navigateur et allez à l'adresse [http://localhost:8000](http://localhost:8000).

## Utilisation des commandes Symfony

Pour voir toutes les commandes disponibles dans Symfony, utilisez :

```sh
php bin/console
```

## Exemples de Routes

Voici quelques exemples de routes définies dans le projet :

- **Dashboard** : [http://localhost:8000/](http://localhost:8000/)
  - Affiche le tableau de bord principal de l'application.
  
- **Product Test** : [http://localhost:8000/product/test](http://localhost:8000/product/test)
  - Route utilisée pour créer des ingrédients et une recette à des fins de test.

- **Product Show** : [http://localhost:8000/product/show/{id}](http://localhost:8000/product/show/{id})
  - Affiche les détails d'un produit spécifique, où `{id}` est l'identifiant du produit.

- **Product Buy** : [http://localhost:8000/product/buy/{id}](http://localhost:8000/product/buy/{id})
  - Permet d'acheter un produit spécifique, où `{id}` est l'identifiant du produit.

- **Logout** : [http://localhost:8000/logout](http://localhost:8000/logout)
  - Permet de se déconnecter de l'application.

## Capture d'écran

Voici une capture d'écran de l'application en fonctionnement :

![Capture d'écran de l'application](path/to/screenshot.png)

## Documentation

Pour plus d'informations sur l'utilisation de Symfony, consultez la [documentation officielle](https://symfony.com/doc/current/index.html).

---

