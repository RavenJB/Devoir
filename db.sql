-- Création de la table 'exercices' pour stocker les résultats des exercices
CREATE TABLE exercices (
    id INT AUTO_INCREMENT PRIMARY KEY,            -- Identifiant unique pour chaque exercice
    user_id INT NOT NULL,                         -- Référence à l'utilisateur qui a fait l'exercice
    exercice_type VARCHAR(50) NOT NULL,           -- Type d'exercice (soustraction, multiplication, etc.)
    score INT NOT NULL,                           -- Score obtenu lors de l'exercice
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,     -- Date et heure de l'exercice, valeur par défaut à l'heure actuelle
    FOREIGN KEY (user_id) REFERENCES users(id)   -- Clé étrangère qui référence la table 'users' pour l'utilisateur ayant fait l'exercice
);

-- Création de la table 'users' pour gérer les informations des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,            -- Identifiant unique pour chaque utilisateur
    name VARCHAR(255) NOT NULL,                    -- Nom de l'utilisateur
    email VARCHAR(255) NOT NULL UNIQUE,            -- Adresse email de l'utilisateur, unique
    password VARCHAR(255) NOT NULL,                -- Mot de passe de l'utilisateur
    role ENUM('enfant', 'enseignant', 'parent') NOT NULL,  -- Rôle de l'utilisateur (enfant, enseignant, parent)
    parent_id INT DEFAULT NULL,                    -- Référence à l'utilisateur parent (si l'utilisateur est un enfant)
    teacher_id INT DEFAULT NULL,                   -- Référence à l'utilisateur enseignant (si l'utilisateur est un enfant)
    FOREIGN KEY (parent_id) REFERENCES users(id),  -- Clé étrangère pour le parent (si applicable)
    FOREIGN KEY (teacher_id) REFERENCES users(id)  -- Clé étrangère pour l'enseignant (si applicable)
);

-- Création de la table 'role' pour gérer les associations entre les utilisateurs enfants, parents et enseignants
CREATE TABLE role (
    id INT AUTO_INCREMENT PRIMARY KEY,            -- Identifiant unique pour chaque rôle
    parent_id INT DEFAULT NULL,                    -- Référence à l'utilisateur parent
    teacher_id INT DEFAULT NULL,                   -- Référence à l'utilisateur enseignant
    child_id INT NOT NULL,                         -- Référence à l'utilisateur enfant
    FOREIGN KEY (parent_id) REFERENCES users(id),  -- Clé étrangère pour le parent
    FOREIGN KEY (teacher_id) REFERENCES users(id), -- Clé étrangère pour l'enseignant
    FOREIGN KEY (child_id) REFERENCES users(id)    -- Clé étrangère pour l'enfant
);
