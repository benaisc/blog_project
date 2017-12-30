Blog Project : Australian Roadtrip
============

Made with <3 by BENAIS Charles and FRESQUET Louise.

Test it there : http://world-trotter-blog.herokuapp.com/

Login: prof

Password: prof

## Routes:

	/                  => index
	/post/{urlAlias}   => a blogPost
	/about             => about us
	/contact           => contact us form
	/admin             => CRUD (protected)


## Commentaires:
On utilise le service SendGrid (Avec l'offre gratuite, limite de 100 mails par mois ^^) et le module SwiftMailer pour la gestion des mails, ce qui nous permet gérer des emails lors de :
- la création de comptes
- la réinitialisation du mot de passe
- la soumission du formulaire de la page de contact. 

Pour la BDD on utilise PostgreSQL hébergé sur Heroku (limite de 500Mo) couplé à l'ORM de doctrine et les bundles symfony doctrine-maker et doctrine-migrations, avec FOSUserBundle pour les utilisateurs.



## Want to Participate ?

### Pre-Requisite
	PHP 7.1+, PostgreSQL 10.1+, PHP-PGSQL

### How To ?
#####	0. Tout d'abord, créez les répertoires dans votre répertoire personnel: 
		mkdir ~/BLOG
		mkdir ~/BLOG/bin

#####	1. Installez composer:
		cd ~/BLOG
		https://getcomposer.org/download/

#####	2. Ensuite installez symfony:
		export HTTP_PROXY=162.38.218.204:3128
		curl -LsS http://symfony.com/installer -o ~/BLOG/bin/symfony
		chmod a+x ~/BLOG/bin/symfony

#####	3. Fermez le terminal

#####	4. Fork us !
		cd ~/BLOG/
		git clone https://github.com/gurujam/blog_project.git

#####	5. Installez les dépendances
		cd ~/BLOG/blog_project
		php ../composer.phar update
		bin/console assets:install --symlink




_A Symfony project created on November 23, 2017, 5:15 pm._
