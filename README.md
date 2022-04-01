# Application de Gestion de Stages 👨‍💻

<img src="https://user-images.githubusercontent.com/101253389/157455133-4713fc13-9af5-4abb-bf4d-a114882648a8.png" align="right"
     alt="Icon" width="96" height="96">
L'application de gestion de stages est une application Web utilisant **Symfony**.
Ce projet a été réalisé dans le cadre d'un travail en groupe durant notre formation BTS SIO Option SLAM.

// REFAIRE MIEUX
Cette application permet aux utilisateurs (professeurs et étudiants) de répertorier et de gérer les stages.

<img src="https://user-images.githubusercontent.com/101253389/157456354-9f07beac-dd1b-41ac-9ea7-895392f17a70.png" align="center"
     alt="Icon" width="90%" height="auto">


## Socle Techniques 🔧

* [Linux Debian](https://www.debian.org).<br>testé avec **Debian GNU/Linux 11 (bullseye)**.
* [NGINX](https://github.com/nginx) Version **Plus Release 24 (R24)** ou [Apache](https://github.com/apache) Version **2.2 - 2.4**.<br>testé avec **Apache 2.4.48** .
* [Symfony](https://github.com/symfony) Version **5** <br>testé avec **5.3.16** .
* [PHP](https://github.com/php) Version **7.4 - 8**  (à installer [php-pgsql](https://www.php.net/manual/fr/book.pgsql.php) et [php-xml](https://www.php.net/manual/fr/refs.xml.php)).<br>testé avec **PHP 7.4.8** .
* [PostgreSQL](https://github.com/postgresql) Version **13.5**.<br>testé avec **13.5** .
* [Navigateur Web](#) Chrome, Firefox, Opera GX, Edge, Brave.<br>testé avec **Firefox 91.0.2 (64 bits)**.


## Installation : Premier pas ! 👣

 Installation des prérequis techniques : 
 ```bash
 sudo apt update
 sudo apt install php
 sudo apt install php-pgsql
 sudo apt install php-xml
 sudo apt install composer
 echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | sudo tee /etc/apt/sources.list.d/symfony-cli.list
 sudo apt update
 sudo apt install symfony-cli
 sudo apt install unoconv
 ```

1. Rendez vous dans le dossier contenant les fichiers **Symfony**.
     
```bash
📁 ─ stage-symfony
├──  📁 ─ bin
├──  📁 ─ config
├──  📁 ─ migrations
├──  📁 ─ public
├──  📁 ─ src
├──  📁 ─ templates
├──  📁 ─ translations
├──  📁 ─ var
├──  📁 ─ vendor
├──  📑 ─ composer.json
├──  📑 ─ composer.lock
├──  📑 ─ docker-compose.override.yaml
├──  📑 ─ docker-compose.yaml
├──  📑 ─ phpunit.xml.dist
├──  📑 ─ symfony.lock
└──  📑 ─ .env
```

2. Ouvrez un **Terminal** ici et tapez :
     ```bash
     symfony server:start
     ```
     ```bash
     composer update
     ```
    
3. Rendez vous sur un navigateur et accéder à localhost
<img src="https://user-images.githubusercontent.com/101253389/158605649-82cba167-1929-48a0-8cfc-2869467650c1.PNG" align="center" alt="CommandeStart" width="90%" 
     height="auto">

## Installation : Base de données

La gestion de la connexion à la base de données se fait dans le fichier '.env' en fichier caché dans la racine du dossier de l'application.

Vous avez le choix entre Mysql, PostgreSQL, SQLite. Il vous suffira de décommenter la ligne de connexion à la base de données et y mettre vos informations de connexion.

![env](https://user-images.githubusercontent.com/101253389/158603674-2040ec5a-69d6-4d6b-9e7d-4e88450b8a41.png)

Ensuite, dans un terminal de commande, il vous faudra écrire les commandes : 

```bash
symfony console doctrine:database:create
```

```bash
symfony console make:migration
```

```bash
symfony console doctrine:migrations:migrate
```

