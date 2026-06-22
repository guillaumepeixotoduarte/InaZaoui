# Ina Zaoui

## 1. Guide d'Installation

### Prérequis

* **PHP 8.2** ou supérieur
* **Composer**
* **MySQL / MariaDB**
* **Symfony CLI** (recommandé)


#### 1. Cloner le projet et installer les dépendances

```bash
composer install
```

#### 2. Configuration de l'environnement

Copie le fichier `.env` pour créer ton fichier `.env.local` et configure ta base de données :

```bash
cp .env .env.local
```

Dans `.env.local`, ajuste la ligne suivante avec tes identifiants locaux :

```ini
DATABASE_URL="mysql://root:password@127.0.0.1:3306/car_rental?serverVersion=8.0"
```

#### 3. Création de la base de données et des tables

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate --no-interaction
```

#### 4. Chargement des données de test (Fixtures)

```bash
php bin/console doctrine:fixtures:load --no-interaction
```

#### 5. Lancer le serveur de développement

```bash
symfony server:start -d
```

---

## 2. Exécution des Tests via PHPUnit

Tous les fichiers de tests incluent la directive de typage strict :

```php
declare(strict_types=1);
```

### Commandes utiles

#### Exécuter toute la suite de tests

```bash
php bin/phpunit
```

#### Exécuter un fichier de test spécifique

```bash
php bin/phpunit tests/Functional/Admin/MediaControllerTest.php
```

#### Exécuter un test de coverage

Le resultat se trouvera dans le dossier  `var/cache/test/` qui est ignoré par Git

```bash
php -d xdebug.mode=coverage bin/phpunit --coverage-html var/cache/test
```

---

## 3. Architecture & Choix d'Implémentation

### Sécurité & Authentification

Le système de sécurité a été refactorisé pour migrer d'une authentification en mémoire (`in_memory`) vers un système entièrement géré en base de données à l'aide de l'entité `User` et de son `UserRepository`.

#### Gestion des rôles

Un flag `admin` (`boolean`) distingue les comptes d'administration des comptes invités (`guests`). A la connexion, si le admin est à `true` en BDD, alors on ajoute le role `ROLE_ADMIN` à l'utilisateur

#### Contrôle d'accès

L'accès aux routes `/admin/*` est strictement restreint aux utilisateurs connecté
Les utilisateurs `ROLE_USER` sont limité à Media

Les tentatives de modification ou de suppression par des utilisateurs anonymes ou avec un compte invité classique déclenchent soit :

* une redirection vers `/login`
* une erreur **403 Access Denied**

Ces comportements sont couverts par des tests fonctionnels.

---

### Gestion des Médias

L'envoi d'images (limités à un poids strict de **2 Mo**) sont rattachés à un utilisateur (`User`) voir à un album (`Album`).

---

### Gestion des utilisateurs

Lors de la suppression d'un utilisateurs, ses médias sont automatiquement supprimés avec lui.

### ⚡ Optimisation des Performances & SQL (Rapport de Performance)

Pour la page `guests`, la récupération des utilisateurs a été modifié afin d'éviter que Doctrine ne relance des requêtes pour chaque utilisateurs

### Impact des indicateurs de performance mesurés sur une Base de données ne contenant que 100 utilisateurs

| Indicateur de performance | Avant optimisation | Après optimisation | Résultat                     |
| ------------------------- | ------------------ | ------------------ | ---------------------------- |
| Nombre de requêtes SQL    | 101 requêtes       | 1 requête          | 1 requête aux lieux de (N+1) |
| Temps de réponse (TTFB)   | ~60 ms             | ~8 ms              | Environ 10× plus rapide      |

![Texte alternatif de l'image](image_readme/perf_guests.png)

### Bénéfices de ce choix

- **Moins de requêtes à la base de données** : toutes les informations nécessaires sont récupérées en une seule requête.
- **Page plus rapide** : le serveur traite moins d'opérations pour afficher la liste des utilisateurs.
- **Meilleure évolutivité** : les performances restent bonnes même lorsque le nombre d'utilisateurs et de médias augmente.

```
```


Pour se connecter avec le compte de Ina, il faut utiliser les identifiants suivants:
- identifiant : `Ina Zaoui`
- mot de passe : `password`

Vous trouverez dans le fichier `backup.zip` un dump SQL anonymisé de la base de données et toutes les images qui se trouvaient dans le dossier `public/uploads`.
Faudrait peut être trouver une meilleure solution car le fichier est très gros, il fait plus de 1Go.