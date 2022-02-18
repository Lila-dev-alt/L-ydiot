# L-ydiot
 Cette application web est une application bancaire. Elle permet de créer un ou plusieurs comptes et de faire des virements à d'autres utilisateurs. 

## Pré requis 
- PHP 8
- Symfony CLI
- Git 
- Composer

## Installation

Récupérer le projet avec 

```git clone git@github.com:Lila-dev-alt/L-ydiot.git ```

Ensuite pour installer les dépendances du projet:

```composer install```

Mettre en place la bdd en local :

``` docker-compose up -d ```

Remplir le .env.local en fonction des variables dans le docker-compose:

```DATABASE_URL="postgresql://user:mdp@127.0.0.1:5432/name_app"```
Créer la bdd en local :

``` php bin/console doctrine:database:create ```

Créer un fichier de migrations :

```php bin/console make:migration```

Faire les migrations :

```php bin/console doctrine:migrations:migrate```

Enfin, lancer e serveur :

```symfony server:start -d```


