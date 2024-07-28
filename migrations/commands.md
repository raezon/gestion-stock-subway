### Generate new migrations
php bin/console doctrine:migrations:generate
### create entity
php bin/console make:entity User
### Create migrations
php bin/console make:migration

php bin/console doctrine:migrations:migrate
php bin/console doctrine:schema:update --force --complete --dump-sql
php bin/console doctrine:schema:create
