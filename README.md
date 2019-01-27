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

Dans le controller que vous venez de creer ajoutez cette ligne de code 

```PHP
  /**
 * @Route("/", name="home")
 */
public function home() {
    return $this->render('blog/home.html.twig');
}
```

Puis creez un fichier home.html.twig dans le dossier blog se trouvant dans templates

Vous pouvez maintenant modifier cette page avec du code html

### Twig

Pour afficher le contenue d'une variable dans une balise h1 :

```Twig
<h1>{{title}}</h1>
```

Pour mettre une condition : 

```Twig
{% if age > 18 %}
<p> Tu es majeur </p>
{% endif }
<p> Tu es mineur </p>
{% endif %}
```

#### Bootstrap avec twig

Pour eviter de devoir mettre le lien de bootstrap dans chaque fichier twig , le fichier : base.html.twig permert de transmettre une information aux autres fichier .twig 


Pour rajouter boostrap mettez le lien de bootstrap dans le fichier base.html.twig

Vous devriez obtenir :

```Twig
<title>{% block title %}Welcome!{% endblock %}</title>
        <link rel="stylesheet" href="https://bootswatch.com/4/flatly/bootstrap.min.css">
        {% block stylesheets %}{% endblock %}
```

Pour que les fichiers .twig hérite du fichier .twig de base ( et donc de bootstrap) ajoutez cette ligne de code : 

> {% extends 'base.html.twig' %}

Pour ajoutez du contenue a cette page, ajoutez les blocks qui se trouvent dans le fichier base.html.twig 

exemple :  

```Twig
{% block body %}
<h1> Salut </h1>
{% endblock %}
```








