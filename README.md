# L-ydiot
 Cette application web est une application bancaire. Elle permet de créer un ou plusieurs comptes et de faire des virements à d'autres utilisateurs. 


## Installation

Récupérer le projet avec 

```git clone git@github.com:Lila-dev-alt/L-ydiot.git ```

Ensuite pour installer les dépendances du projet:

```composer install```

Mettre en place la bdd en local :

``` docker-compose up -d ```

Créer la bdd en local :

``` php bin/console doctrine:database:create ```

Créer un fichier de migrations :

```php bin/console make:migration```

Faire les migrations :

```php bin/console doctrine:migrations:migrate```

Enfin, lancer le serveur :

```symfony server:start -d```


