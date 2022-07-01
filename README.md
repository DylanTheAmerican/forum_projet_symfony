# ForumFoot

## Installation

Pour intaller le projet utilisez la commande ci dessous :
```bash
git clone https://github.com/DylanTheAmerican/forum_projet_symfony.git
```

Placer vous dans le dossier :
```bash
cd forum_projet_symfony
```
Installez le composer
```bash
symfony composer install
```
```bash
npm install
```
```bash
npm run build
```


Vous devez modifier l'url dans le fichier .env (ligne 31) pour la faire correspondre à vorte BDD
```bash
DATABASE_URL="mysql://username:password@127.0.0.1:8889/BDDName?serverVersion=5.7"
```
> :warning: Votre serveur doit être démarré

- Creation de la base de donnée

    ```bash
    symfony console doctrine:database:create
    ```

- Mise à jour de la base de donnée
    ```bash
    symfony console make:migration
    ```
    ```bash
    symfony console doctrine:migration:migrate
    ```
    ```bash
    symfony php bin/console doctrine:fixtures:load
    ```

- Il ne manque plus qu'a lancer le projet
    ```bash
    symfony server:start -d
    ```
## Identifiants

Utilisateur rôle admin :

- Nom d'utilisateur : admin
- Mot de passe : adminpassword

Utilisateur rôle auteur :

- Nom d'utilisateur : loken32
- Mot de passe : azerty32

## Vérifier que le projet est fonctionnel

### Utilisateur
Se connecter :
- Aller sur "Connexion"
- Entrer les identifiants

S'inscrire :
- Aller sur "Connexion"
- Cliquer sur "Inscrivez vous"
- Entrer les informations demandé

> :warning: Les étapes suivantes nécessitent d'être connecté

Editer les informations de son profil :
- Aller sur "Profil"
- Changer les informations voulu
- Cliquer sur "Modifier"

Ouvrir un nouveau ticket :
- Aller sur "Forum"
- Cliquer sur "Nouveau sujet"
- Remplir les informations
- Cliquer sur "Poster"

Voir les tickets d'une catégorie :
- Aller sur "Catégorie"
- Cliquer sur "Voir les Tickets" d'une catégorie

Répondre à un ticket déjà ouvert :
- Aller sur "Accueil" ou "Forum"
- Cliquer sur "Voir" d'un ticket
- Remplir "Content" de "Ajouter une réponse"
- Et clique sur "Répondre au sujet"

### Administrateur

> :warning: Les étapes suivantes nécessitent d'être connecté en tant qu'administrateur

Voir l'ensemble des utilisateurs :
- Aller sur "Administration"

Pouvoir supprimer des messages :
- Aller sur "Accueil" ou "Forum"
- Cliquer sur "Voir" d'un ticket
- Cliquer sur le bouton avec l'icone d'une poubelle d'un message

Pouvoir editer ces propres informations :
- Aller sur "Administration"
- Cliquer sur le bouton editer d'un utilisateur
- Changer les informations voulu
- Cliquer sur "Modifier"

Pouvoir editer des catégories :
- Aller sur "Catégorie"
- Cliquer sur le bouton editer d'une catégorie
- Changer le titre de la catégorie
- Cliquer sur "Modifier"