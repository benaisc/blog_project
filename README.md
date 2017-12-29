Blog Project : Australian Roadtrip
============

Made with <3 by BENAIS Charles and FRESQUET Louise.


##Routes:

	/			=> index
	/post/{urlAlias}	=> a blogPost
	/about			=> about us
	/admin			=> CRUD (protected)
	/contact		=> TODO


Test it there : http://world-trotter-blog.herokuapp.com/


##What's needed ?

	PHP 7.1+, PostgreSQL 10.1+, PHP-PGSQL

##How To ?
#####	0) Tout d'abord, créez un répertoire bin dans votre répertoire personnel 
		mkdir ~/BLOG
		mkdir ~/BLOG/bin

#####	1) Installez composer:
		cd ~/BLOG
		https://getcomposer.org/download/

#####	2) Ensuite installez symfony:
		export HTTP_PROXY=162.38.218.204:3128
		curl -LsS http://symfony.com/installer -o ~/BLOG/bin/symfony
		chmod a+x ~/BLOG/bin/symfony

#####	3) Fermez le terminal

#####	4) Fork us !
		cd ~/BLOG/
		git clone https://github.com/gurujam/blog_project.git

#####	5) Installez les dépendances
		cd ~/BLOG/blog_project
		php ../composer.phar update
		bin/console assets:install --symlink




A Symfony project created on November 23, 2017, 5:15 pm.
