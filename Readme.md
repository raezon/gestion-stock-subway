# Captures d'application
![screencapture-localhost-8000-2024-07-31-00_58_33](https://github.com/user-attachments/assets/48de4079-5320-4be0-a977-382dd107c683)
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
   Copier le fichier `.env` et renommez-le en `.env.local` :

   ```sh
   cp .env .env.local
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

## Documentation

Pour plus d'informations sur l'utilisation de Symfony, consultez la [documentation officielle](https://symfony.com/doc/current/index.html).

---

Si vous rencontrez des problèmes ou avez des questions, n'hésitez pas à ouvrir une issue ou à me contacter.

Bon développement !
```

Ce fichier `README.md` donne des instructions claires pour installer l'application Symfony, configurer les variables d'environnement, générer et exécuter les migrations, et lancer l'application. Vous pouvez adapter ce modèle en fonction des besoins spécifiques de votre projet.
