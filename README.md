# Quacknet_Symfony

Installation Symfony 4 :
Pour créer le projet, utiliser composer  et une version minimul de PHP 7.1.3 :
$ composer create-project symfony/website-skeleton my_project


La base de données :
Configurer l'accès à la base de données en modifiant les éléments du fichier .env : 
(accès identifiant, mot de passe, nom de la base de données que l'on veut créer)
DATABASE_URL=mysql://username:password@127.0.0.1:3306/db_name

Puis à créer cette même base et le schéma correspondant au projet :

$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:update --force

Créer des entités :
$ php bin/console make:entity

Une fois les entités créées, effectuer les migrations pour mettre à jour les tables de la bdd :

$ php bin/console make:migrate
$ php bin/console doctrine:migrations:migrate


