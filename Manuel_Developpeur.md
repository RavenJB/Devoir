# Manuel Développeur

## Introduction
Ce manuel développeur fournit des instructions détaillées pour installer, configurer et comprendre la structure du projet "les-devoirs-de-primaire".

## Arborescence des fichiers
.gitattributes
.gitignore
addition/
    affiche_resultat.php
    correction.php
    fin.php
    images/
    index.php
    log_config.php
    logs/
    question.php
    raz.php
    resultats/
    supprime/
    supprimer_resultat.php
    utils.php

conjugaison_phrase/
    ...
conjugaison_verbe/
    ...
dictee/
    ...
soustraction/
    ...
multiplication/
    ...

composer.json
composer.lock
db.php
db.sql
index.html
index.php
LICENSE
login.php
logout.php
Manuel_Developpeur.md
Manuel_Utilisateur.md
profile.php
README.md
register.php
resultats/
textToSpeech.py
vendor/
    composer/
    monolog/
    psr/
    autoload.php

## Installation
1. **Téléchargement du code source**
   - Clonez le dépôt Git ou téléchargez le code source du projet.

2. **Transfert sur un hébergement**
   - Transférez les fichiers sur un serveur web avec PHP installé (aucune base de données n'est nécessaire).

3. **Configuration des permissions**
   - Dans les répertoires `addition`, `conjugaison_phrase`, `conjugaison_verbe`, `dictee`, `multiplication` et `soustraction`, changez les permissions des sous-répertoires `logs`, `resultats` et `supprime` en 777 pour permettre l'écriture.

4. **Installation des dépendances**
   - Utilisez Composer pour installer les dépendances PHP :
     ```sh
     composer install
     ```

## Structure du projet
- **addition/** : Contient les fichiers relatifs aux exercices d'addition.
- **conjugaison_phrase/** : Contient les fichiers relatifs aux exercices de conjugaison de phrases.
- **conjugaison_verbe/** : Contient les fichiers relatifs aux exercices de conjugaison de verbes.
- **dictee/** : Contient les fichiers relatifs aux exercices de dictée.
- **multiplication/** : Contient les fichiers relatifs aux exercices de multiplication.
- **soustraction/** : Contient les fichiers relatifs aux exercices de soustraction.
- **vendor/** : Contient les dépendances installées via Composer.
- **logs/** : Contient les fichiers de logs générés par les exercices.
- **resultats/** : Contient les fichiers de résultats des exercices.

## Configuration des logs
Chaque module utilise Monolog pour la gestion des logs. Les fichiers de configuration des logs se trouvent dans chaque répertoire d'exercice, par exemple [log_config.php].

## Contacts
Pour toute question ou assistance supplémentaire, veuillez contacter :
- **Rémi Synave**
- **Email** : remi.synave@univ-littoral.fr

---

Ce manuel développeur vous guide à travers l'installation, la configuration et la structure du projet "les-devoirs-de-primaire". Pour toute question ou assistance supplémentaire, veuillez contacter Rémi Synave à l'adresse email fournie ci-dessus.