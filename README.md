# CV/Portfolio Project

## Description

Ce projet est un site web de CV/Portfolio permettant aux utilisateurs de créer, gérer et télécharger leurs CV, ainsi que d'ajouter des projets personnels. Le site est développé en PHP avec une base de données SQLite et est déployé avec Docker et Nginx.

## Fonctionnalités
- **Inscription et Connexion** : Création de compte et connexion pour les utilisateurs.
- **Gestion du CV** : Création et mise à jour du CV, ajout de compétences, d'expériences et de formations.
- **Génération de PDF** : Exportation du CV au format PDF (en cours de développement).
- **Gestion des Projets** : Ajout de projets personnels au portfolio (fonctionnalité de modification en cours).

## Technologies Utilisées
- **PHP 8.1** avec FPM
- **SQLite** pour la base de données
- **Nginx** comme serveur web
- **Docker** pour la conteneurisation
- **Bootstrap** pour la mise en page et les styles
- **Composer** pour la gestion des dépendances PHP

## Installation

1. Clonez le dépôt :
   ```bash
   git clone https://github.com/CantonyEddy/TP-test-PHP.git

2. Accédez au dossier du projet :
   ```bash
   cd TP-test-PHP/Docker

3. Construisez les conteneurs Docker :
   ```bash
   docker-compose up --build

4. Initialisez la base de données SQLite :
   ```bash
   docker exec -it php /bin/bash
   php /var/www/html/init_db.php

## Utilisation

Accédez au site en ouvrant votre navigateur à l'adresse http://localhost:8080.

## Problèmes Connus

 - La génération de PDF nécessite l'installation correcte de **DomPDF**.

 - Certains chemins d'inclusion doivent être revérifiés si des erreurs se produisent.

## Contribuer

Aucun contributeur demandé
