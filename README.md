# ForumFoot

## Installation

Pour intaller le projet utilisez la commande ci dessous :
```bash
git clone https://github.com/DylanTheAmerican/forum_projet_symfony.git
```

PLacer vous dans le dossier :
```bash
cd forum_projet_symfony
```

Vous devez ensuite creer une base de donnée et mettre son url dans le fichier .env :

    ```bash
    ligne 31 : DATABASE_URL="mysql://username:password@127.0.0.1:8889/BDDName?serverVersion=5.7"
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
