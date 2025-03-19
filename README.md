# API-Authentification

Une API d'authentification dédiée au projet **API-VolleyTrack**.

## Description

Cette API permet la gestion de l'authentification pour le projet **API-VolleyTrack**. Elle prend en charge les requêtes **GET** et **POST** pour l'émission et la validation de jetons JWT.

## Fonctionnalités

- **GET** `https://authapi.alwaysdata.net/authapi.php` → Génère un token JWT valide pendant **30 minutes**. Spécifié le login et le mot de passe dans le body de la requête.
- **POST** `https://authapi.alwaysdata.net/authapi.php` → Vérifie la validité d’un token JWT.

Toutes les autres requêtes sont traitées mais non implémentées, et renvoient une **erreur utilisateur** plutôt qu’une erreur serveur.

## 📦 Installation

1. **Cloner le dépôt** :
   ```sh
   git clone https://github.com/votre-repo/API-Authentification.git
   cd API-Authentification
