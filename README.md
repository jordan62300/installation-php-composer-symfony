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

## Utilisation de symfony

* Doctrine : Pour gerer l'accès aux données
* Controller : Pour gerer le traitement
* Twig : Pour gerer le rendu

### Controller

Pour creer un controller tapez : 

> php bin/console make:controller

Puis choissisez un nom de class pour votre controller , exemple : 

>BlogController

Cette commande va creer : 

* Un dossier dans blog ayant un fichier .twig dans le dossier templates
* Un fichier BlogController.php dans le dossier src/Controller

Vous pouvez maintenant acceder a la page localhost:8000/blog 

#### Changer la page d'accueil du projet

Dans le controller que vous venez de creer ajoutez : 

>   /**
 * @Route("/", name="home")
 */
public function home() {
    return $this->render('blog/home.html.twig');
}







