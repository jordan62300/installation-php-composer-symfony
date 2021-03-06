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

Ne pas oublier de rentrer dans le dossier demo qui vient de se creer 

> cd demo


Pour installer un serveur personnalisé 


>composer require server --dev


Pour lancer le serveur

> php bin/console server:run

## Utilisation de symfony

## Partie I

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

Puis renseignez la function présente dans le fichier BlogController avec les variables et leurs valeurs

```PHP
  /**
 * @Route("/", name="home")
 */
public function home() {
    return $this->render('blog/home.html.twig',[
        'title' => 'Bienvenue mes amis',
        'age' => 17
    ]);
}
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

### Doctrine 

Doctrin est l'ORM de symfony et permert de creer , modifier , supprimer , ajoutez des données etc dans nos tables 

Les outils de Doctrine :

* Entity : Représente une table (creation etc)
* Manager : Permet de manipuler une ligne (insertion , supression etc)
* Repository : Permet de faire des selections (faire des SELECT façon sql)

Les migrations dans symfony :

Elles permettent d'exporter nos bases de données en faisant tourner le script une fois

Les fixtures dans symfony : 

Ca permet d'ajouter des fausses données dans nos tables , permettant de travailler directement sur elle ( utile pour s'entrainer)

#### Creation d'une BDD 

Pour creer une BDD aller dans le fichier .env

a l'intérieur trouvez la ligne : 

> DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name

et modifiez la avec vos login phpmyadmin : 

> DATABASE_URL=mysql://root:@127.0.0.1:3306/blog

Puis utilisez la commande : 

> php bin/console doctrine:database:create

#### Creation d'une table

Pour creer une table tapez dans la console : 

> php bin/console make:entity

puis entrez son nom , exemple : Article

Cela creer deux fichier :

* src/Entity/Article.php qui représente notre table
* src/Repository/ArticleRepository.php qui permert de faire des selections sur nos tables

Ajoutez ensuite vos champs un par un et définissez ses propriétés , exemple : title 

#### Migration

Migrer notre entity pour ajouter la table et ses données dans phpmyadmin 

Creer la version :

> php bin/console make:migration

Faire la migration 

> php bin/console doctrine:migrations:migrate

### Fixture

Pour creer une fixture nous devons installer le composant de creation de fixture :

> composer require orm-fixtures --dev

Puis utiliser fixture :

> php bin/console make:fixtures

Entrez ensuite le nom de votre fixture , exemple : ArticleFixtures

dans le dossier DataFixtures le fichier ArticleFixtures.php se creer

dans ce fichier nous pouvons creer des Articles , ajouter ce code :

```PHP
use App\Entity\Article;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        for($i = 1;$i <= 10; $i++){
            $article = new Article();
            $article->setTitle("Titre de l'article n°$i")
                    ->setContent("<p>Contenu de l'article n°$i</p>")
                    ->setImage("http://placehold.it/350x150")
                    ->setCreatedAt(new \DateTime());

            $manager->persist($article);
        }

        $manager->flush();
    }
}
```


Le use permet de savoir ou est la classe dont on fait une instance

Nous pouvons ajouter du contenu grace aux set disponible dans la table se trouvant dans le dossier entity

le $manager->persist($article) permet de faire persister l'article dans le temps

le $manager->flush() permet de faire les requetes sql et de balancer les données dans la table

_La commande qui permet d'envoyer les données:_

> php bin/console doctrine:fixtures:load


### Exploiter les données de la BDD

Pour faire des selections nous avons besoin d'un repository
Pour faire des manipulations nous avons besoin d'un manager

Pour avoir accès au repository dans le controller pour selectionner les données nous créeons dans le fichier du controller ( ici BlogController.php) une variable repo et on récupere le repository

```PHP
 $repo = $this->getDoctrine()->getRepository(Article::class);
 ```

 Ne pas oublier de mettre l'accès a la class

 ```PHP
 use App\Entity\Article;
 ```

 Pour trouver un article en particulier

ici on cherche l'article 10
 ```PHP
 $article = $repo->find(10)
 ```
Ou pour trouver un article ayant le titre correspondant
  ```PHP
 $article = $repo->findOneByTitle('Titre de l\'article');
 ```

Ou trouver les articles ayant le titre correspondant
  ```PHP
 $article = $repo->findTitle('Titre de l\'article');
 ```

 Ou pour selectionner tous les articles

  ```PHP
 $article = $repo->findAll();
 ```


 Pour afficher le rendu , on utilise twig :

 ```Twig
    {% for article in articles}
    <h1> {articles.title} </h1>
    {% endfor %}
 ```

Une exeption pour la date qui n'est pas une donnée primitive :

 ```Twig
    {% for article in articles}
    <h1> {articles.title} </h1>
    <div class="metada">Ecrit le {{ article.createdAt | date('d/m/y') }} à {{article.createdAt | date('H:i') }} dans la catégorie Politique</div>
    {% endfor %}
 ```

 Ainsi que pour le contenu (securité de twig) : 

 ```Twig
    {% for article in articles}
    <h1> {article.title} </h1>
    <div class="metada">Ecrit le {{ article.createdAt | date('d/m/y') }} à {{article.createdAt | date('H:i') }} dans la catégorie Politique</div>

    {{ article.content | raw }}
    {% endfor %}
 ```

 Pour obtenir l'identifiant de l'article que nous voulons voir on va dans le controller et on ajoute a la route l'id et on la fait passer en paramettre dans la fonction

 ```PHP
    /**
 * @Route("/blog/{id}", name="blog_show")
 */

public function show($id) {
    $repo = $this->getDoctrine()->getRepository(Article::class);
    $article = $repo->find($id);
    return $this->render('blog/show.html.twig', [
        'article' => $article,
    ]);
}
 ```

 Ne pas oublier de modifier le chemin du bouton pour ajouter l'id de l'article 

 ```Twig
  <a href="{{ path('blog_show', {'id' : article.id})}}" class="btn btn-primary">Lire la suite</a>
  ```

  ## Partie II

  ### Creation d'une page de creation d'article

  Nous avons besoin de 3 choses 

  * une function public dans un controller
 ```PHP
public function create() {
}
 ```
  * Une route qui représente l'adresse permettant d'appeller cette fonctionnalité , ici l'adresse sera donc localhost:8000/blog/new

```PHP
 /**
* @Route("/blog/new", name="blog_create")
*/
 ```
  * Et un traitement

 ```PHP
return $this ->render('blog/create.html.twig')
 ```

Ce qui nous donne dans le fichier BlogController.php :

```PHP
  /**
* @Route("/blog/new", name="blog_create")
*/

public function create() {
return $this ->render('blog/create.html.twig');
}
```


Faites attention a ne pas mettre de route trop similaire 


Créons maintenant un fichier create.html.twig dans le dossier blog se trouvant dans template et nous permettant d'afficher du contenue dans la page
Ne pas oublier de lui faire hérité de la page twig de base (% extends 'base.html.twig' %)

Une fois fait , dans le fichier base.html.twig pour avoir un code plus propre modifiez le lien menant à cette page

Remplacer : 

>  <a class="nav-link" href="/blog/new">Creer un article</a>

Par le nom de la route

>  <a class="nav-link" href="{{ path('blog_create') }}">Creer un article</a>

faites de meme pour la page menant aux articles

### Creation d'un formulaire symfony

Pour creer un formulaire on utilise la documentation 

https://symfony.com/doc/current/forms.html

Dans la function create on crée d'abord une instance de la class Article pour dire que nous créons un nouveau article 

```PHP
$article = new Article();
```

Puis nous créons le formulaire 

```PHP
$form = $this->createFormBuilder($article)
             ->add('title')
             ->add('content')
             ->add('image')
             ->getForm();

     return $this ->render('blog/create.html.twig' [
         'formArticle' => $form->createView()
     ]);
```

Puis dans twig nous affichons le formulaire grace a la variable

```Twig
{{ form(formArticle) }}
```

Pour changer le type de champ modifier :

```PHP
->add('content' TextType::class)
```

et ajouter le use correspondant (trouvable dans la documentation si dessus) pour expliquer d'ou vient TextType

```PHP
use Symfony\Component\Form\Extension\Core\Type\TextType;
```

#### Ajouter des attributs aux champs

Pour ajouter d'autres options aux champs ajouter :

```PHP
->add('title' TextType::class, [
    'attr' => [
        'placeholder' => "Titre de l'article",
        'class" => 'form-control'
    ]
])
```

#### Amélioration du rendu

Dans votre fichier twig nous pouvons utiliser les methodes de twig pour préciser le début et la fin du formulaire :

```Twig
{{ form_start(formArticle)}}

{{ form_end(formArticle)}}
```

Puis la méthode form_widget pour faire correspondre les champs aux label :

```Twig
{{ form_start(formArticle)}}

<div class="form-group">
    <label for="">Titre</label>
    {{ form_widget(formArticle.title) }}
</div>

{{ form_end(formArticle)}}
```

Pour ajouter un formulaire bootstrap supprimer les class et ajoutez dans le fichier twig.yaml qui se trouve dans le dossier config/packages

> form_themes: ['bootstrap_4_layout.html.twig']

Puis dans le twig en dessous de l'extends

> {% form_theme formArticle 'bootstrap_4_layout.html.twig' %}

Ajoutez le button dans le fichier twig

> <button type="submit" class="btn btn-succes">Ajouter l'article</button>

Simplifier le code dans le controller grace a la function form_row()

Supprimer les attributs dans les functions add , vous devez obtenir ceci

```Twig
    ->add('title')
    ->add('content')
    ->add('image')
```

Pour que les requetes atteignent la BDD ajoutez les arguments dans la function 

```PHP
public function create(Request $request,ObjectManager $manager)
```

Ainsi que cette ligne permettant de gere la requete 

```PHP
$form->handleRequest($request);
```

Ne pas oublier les use a mettre dans le controller

```PHP
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
```

Verifier si le formulaire et soumis/valide puis
on ajoute la date actuel au champ CreatedAt
ensuite on fait persister l'article
puis on demande au manager de balancer la requete

```PHP
if($form->isSubmitted() && $form->isValid()) {
    $article->setCreatedAt(new \DateTime());

    $manager->persist($article);
    $manager->flush();
}
```





  



