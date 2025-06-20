CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    promotion VARCHAR(50) DEFAULT NULL,
    birthdate DATE DEFAULT NULL,
    company VARCHAR(100) DEFAULT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) DEFAULT NULL,
    google_id VARCHAR(50) DEFAULT NULL,
    auth_type ENUM('local', 'google') NOT NULL DEFAULT 'local',
    is_verified BOOLEAN DEFAULT FALSE,
    verify_token VARCHAR(100) DEFAULT NULL,
    role VARCHAR(20) DEFAULT 'utilisateur',
    is_adherent BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE alumni_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    diplome VARCHAR(255) NOT NULL,
    annee INT NOT NULL,
    statut ENUM('en_attente', 'valide', 'refuse') DEFAULT 'en_attente',
    date_demande DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS bde_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    annee VARCHAR(9) NOT NULL UNIQUE,         -- Exemple : '2025/2026'
    description TEXT NOT NULL,                -- Texte libre rédigé chaque année
    is_active BOOLEAN DEFAULT FALSE,          -- True = BDE affiché par défaut
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS bde_membres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bde_id INT NOT NULL,                      -- Clé étrangère vers bde_info.id
    nom VARCHAR(100) NOT NULL,
    role VARCHAR(100),                        -- Ex : "Président", "Trésorier"
    description TEXT,                         -- Petite bio
    photo VARCHAR(255),                       -- Lien vers l'image
    FOREIGN KEY (bde_id) REFERENCES bde_info(id) ON DELETE CASCADE
);

ALTER TABLE bde_membres 
MODIFY nom VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
MODIFY role VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
MODIFY photo VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
MODIFY description TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER DATABASE bde_ensar CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
ALTER TABLE bde_membres CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS alumni_requests;
DROP TABLE IF EXISTS bde_info;
DROP TABLE IF EXISTS bde_membres;