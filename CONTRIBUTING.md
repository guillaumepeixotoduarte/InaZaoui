# Guide de Contribution (CONTRIBUTING)

## Convention de nomage : 

Pour se projet, nous utiliserons le `camelCase`
Pour ce qui est du typage des retour des fonctions, il faut faire un `use` de la classe en haut au lieu de mettre le chemin complet avec le namespace a chaque fois

## Contribution -> Branches et Pull Requests (PR)

La branche `main` doit toujours rester stable et fonctionnelle.
Pour chaque modification, créez une branche depuis `main` avec un nom clair (ex: `feat/authentification`, `fix/lenteur-invites`).
Une fois vos modifications terminées et poussées, ouvrez une PR sur GitHub/GitLab pour que votre code soit relu avant d'être fusionné dans `main`.

## Performance et requêtes SQL

Attention aux performances. Si vous affichez une liste d'éléments qui possèdent des relations (ex: une liste de médias avec leur auteur), assurez-vous de ne pas générer une requête SQL par élément.

## Tests et Qualité du code

`Ajout de fonctionnalités = Ajout de tests` Si vous ajoutez une nouvelle route ou une nouvelle logique métier, vous devez obligatoirement écrire les tests fonctionnels correspondants dans le dossier `tests/Functional/`.
Avant d'ouvrir votre Pull Request, assurez-vous que la suite de tests passe localement :
  ```bash
  php bin/phpunit