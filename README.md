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


Vous devez modifier l'url dans le fichier .env (ligne 31) pour la faire correspondre à vorte BDD :
    ```bash
    DATABASE_URL="mysql://username:password@127.0.0.1:8889/BDDName?serverVersion=5.7"
    ```
> :warnin: Votre serveur doit être démarré

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
