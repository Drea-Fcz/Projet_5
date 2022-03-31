<h1 align="center" style="color: #b79862; box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px; ">
Projet 5 OpenClassrooms
</h1>
 <h3 align="center">Création d'un Blog via une architecture MVC Orienté objet.</h3>


## À propos
Voici les principales fonctionnalités disponibles en fonction des différents statuts d'utilisateur :
<h5>Visiteur:</h5>
<ul>
<li>Visiter la page d'accueil et ouvrir les différents liens disponibles (compte GitHub, compte Linkedin).</li>
<li>Envoyer un message au créateur du blog.</li>
<li>Parcourir la liste des blogs et parcourir la liste de ses commentaires.</li>
</ul>
<h5>Utilisateur:</h5>
<ul>
<li>Prérequis: s'être enregistré via le formulaire d'inscription.</li>
<li>Accès aux mêmes fonctionnalités que le visiteur.</li>
<li>Ajout de commentaires.</li>
<li>Accès au CV.</li>

</ul>
<h5>Administrateur:</h5>
<ul>
<li>Prérequis: avoir le status administrateur.</li>
<li>Accès aux mêmes fonctionnalités que le visiteur.</li>
<li>Ajout/suppression/modification de blog post.</li>
<li>Validation/suppression de commentaires.</li>

</ul>

### Framework/ Librairie/ Langages

Pour la partie Front End du projet, le framework BootStrap et du Css ont été utilisé.


<!-- GETTING STARTED -->
## Getting Started


### Prérequis

* composer
  ```sh
  composer install
  ```
* PHP sup 7.4

### Installation

_Suivez les instructions suivantes :
1. Clone the repo
   ```sh
   git clone https://github.com/your_username_/Project-Name.git
   ```
2. Create your database
   ```sql
   CREATE DATABASE IF NOT EXISTS OcBlog
   ```
3. Install Composer packages
   ```sh
   composer install
   ```
4. Enter your config in `config.php`
   ```js
   const DB_HOST = 'ENTER YOUR HOST';
   const DB_USER = 'ENTER YOUR USERNAME';
   const DB_PASS = 'ENTER YOUR PASSWORD';
   const DB_NAME = 'OcBlog';
   ```

5. Remplir le fichier App/Config/mail.exemple.php avec les accès à votre compte email.

<!-- ID for testing -->
## Identifiants connexion

### Utilisateur :
<ul>
<li>Identifiant: TODO</li>
<li>Mot de passe: TODO</li>
</ul> 

### Administrateur :
<ul>
<li>Identifiant: TODO</li>
<li>Mot de passe: TODO</li>
</ul>
