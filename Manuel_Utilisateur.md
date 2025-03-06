# Manuel Utilisateur

## Introduction
"Les devoirs de primaire" est un site web permettant aux enfants en primaire de faire des exercices de maths et de français. Le site propose des exercices d'addition, de conjugaison de phrases, de conjugaison de verbes, de dictée, de multiplication et de soustraction.

## Installation
1. Téléchargez le code source du projet.
2. Transférez-le sur un hébergement avec PHP (pas de base de données utilisée).
3. Après le transfert, dans les répertoires `addition`, `conjugaison_phrase`, `conjugaison_verbe`, `dictee`, `multiplication` et `soustraction`, changez les droits en 777 pour les sous-répertoires `logs`, `resultats` et `supprime`.

## Utilisation
1. Rendez-vous sur la page d'accueil du site.
2. Sélectionnez l'exercice que vous souhaitez réaliser.
3. Configurez les exercices si nécessaire (changement du temps pour les conjugaisons, des bornes des nombres pour les exercices de maths, etc.).
4. Pour voir les résultats d'un enfant, rendez-vous sur la page d'accueil, entrez dans l'exercice pour lequel vous voulez les résultats puis, dans la barre d'adresse, modifiez `index.php` par `affiche_resultat.php`.

## Fonctionnalités
### Exercices
- **Addition** : Permet de faire des exercices d'addition.
- **Conjugaison de phrases** : Permet de faire des exercices de conjugaison de phrases.
- **Conjugaison de verbes** : Permet de faire des exercices de conjugaison de verbes.
- **Dictée** : Permet de faire des exercices de dictée.
- **Multiplication** : Permet de faire des exercices de multiplication.
- **Soustraction** : Permet de faire des exercices de soustraction.

### Résultats
- Les résultats des exercices sont enregistrés dans des fichiers texte dans le répertoire `resultats`.
- Les résultats peuvent être consultés en modifiant l'URL de l'exercice pour accéder à `affiche_resultat.php`.

### Logs
- Les actions des utilisateurs sont enregistrées dans des fichiers de log dans le répertoire `logs`.
- Les logs incluent des informations telles que l'adresse IP de l'utilisateur, la page visitée et les actions effectuées.

## Système de Connexion
- Un système de connexion avec profil est en cours de développement.
- Les utilisateurs pourront s'inscrire, se connecter et sauvegarder leurs exercices réalisés avec visualisation de statistiques sur leur profil.

## Rôles des Utilisateurs
- **Enfant** : Peut faire des exercices.
- **Enseignant** : Peut voir les résultats de ses élèves et configurer les exercices.
- **Parent** : Peut voir les résultats de ses enfants.

## Contact
- Rémi Synave
- Contact : remi.synave@univ-littoral.fr

---

Ce manuel utilisateur vous guide à travers l'installation, l'utilisation et les fonctionnalités du site "les-devoirs-de-primaire". Pour toute question ou assistance supplémentaire, veuillez contacter Rémi Synave à l'adresse email fournie ci-dessus.