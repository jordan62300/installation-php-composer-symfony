#  Php , Composer et Symfony sous windows

##  Pour installer php :

<http://www.wampserver.com/>


Pour savoir si php est installé et connaitre sa version tapez dans votre  console :


> php -v


Si une erreur apparait allez dans :


> panneau de configuration > systeme > Parametre systeme avancé > variable d'environnement 


Puis ajoutez une nouvelle variable utilisateur , le nom de la variable : path et la valeur doit etre le chemin de votre php.exe



>C:\wamp64\bin\php\php7.2.14


## Pour installer Composer 


https://getcomposer.org/


Suivre l'installation et verifier si Composer est installé avec la commande 

> composer -V

## Pour installer symfony

Se rendre dans un projet php et taper 

> composer create-project symfony/website-skeleton demo


Pour installer un serveur personnalisé 


>composer require server --dev


Pour lancer le serveur

> php bin/console server:run

## utilisation de symfony





