# SkillShare - Plateforme d'échange de compétences

## 📋 Description

SkillShare est une plateforme web permettant aux utilisateurs de partager et d'échanger leurs compétences avec d'autres passionnés. Les utilisateurs peuvent créer un profil, lister leurs compétences et rechercher des personnes avec qui échanger des connaissances.

## 🚀 Technologies utilisées

- Frontend :
  - HTML5, CSS3, JavaScript
  - EJS (Template Engine)
  - SASS
  - Browser-sync
- Backend :
  - PHP 8.2
  - MySQL
  - JSON Web Tokens (JWT)
- Outils :
  - Git
  - Composer
  - npm

## 💻 Prérequis

- PHP 8.2 ou supérieur
- MySQL 8.0 ou supérieur
- Node.js 18 ou supérieur
- npm 9 ou supérieur
- Composer

## 🔧 Installation

### Configuration du Backend

```bash
cd backEnd
composer install
# Configurez votre base de données dans le fichier .env
cp .env.example .env
# Importez la base de données
mysql -u root -p < database/init-skillshare.sql
```

### Configuration du Frontend

```bash
cd frontEnd
npm install
cp .env.example .env
# Configurez les variables d'environnement dans le fichier .env
```

## 🏃‍♂️ Démarrage

### Lancer les deux

```bash
npm start
```

### Lancer le Backend

```bash
cd backEnd
php -S localhost:8000 -t public
```

### Lancer le Frontend

```bash
cd frontEnd
npm start
```

## 📁 Structure du projet

```
SkillShare/
├── backEnd/
│   ├── public/
│   ├── src/
│   │   ├── controller/
│   │   ├── core/
│   │   ├── model/
│   │   ├── repository/
│   │   └── service/
│   └── database/
└── frontEnd/
    ├── public/
    │   ├── assets/
    │   └── services/
    ├── routes/
    ├── styles/
    └── views/
```

## 🔐 Fonctionnalités

- Authentification utilisateur (inscription, connexion, déconnexion)
- Vérification d'email
- Gestion de profil utilisateur
- CRUD des compétences
- Dashboard administrateur
- Upload d'avatar
- Système de notation

## 👥 Rôles utilisateur

- Visiteur : Consultation des compétences disponibles
- Utilisateur : Gestion de profil, ajout/modification de compétences
- Administrateur : Gestion complète de la plateforme

## 🔒 Sécurité

- Protection CSRF
- Validation des données
- Hachage des mots de passe
- Authentification JWT
- Protection XSS
- Configuration CORS

## 📝 Licence

Ce projet est sous licence MIT.

## ✍️ Auteur

[Bryan Foucart]

## 🤝 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à ouvrir une issue ou soumettre une pull request.
