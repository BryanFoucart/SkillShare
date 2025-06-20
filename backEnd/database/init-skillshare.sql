DROP DATABASE IF EXISTS skillsharedb;

CREATE DATABASE IF NOT EXISTS skillsharedb;

USE skillsharedb;

CREATE TABLE
    `user` (
        id_user INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        avatar VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        `role` JSON NOT NULL,
        email_token VARCHAR(255),
        is_verified BOOLEAN,
        verified_at DATETIME,
        password VARCHAR(255) NOT NULL,
        created_at DATETIME,
        reset_at DATETIME,
        reset_token VARCHAR(100)
    );

CREATE TABLE
    skill (
        id_skill INT AUTO_INCREMENT PRIMARY KEY,
        id_user INT NOT NULL,
        title VARCHAR(100) NOT NULL,
        infos TEXT,
        etat ENUM ('offer', 'request') NOT NULL,
        created_at DATETIME,
        updated_at DATETIME,
        FOREIGN KEY (id_user) REFERENCES `user` (id_user)
    );

CREATE TABLE
    exchange (
        id_exchange INT AUTO_INCREMENT PRIMARY KEY,
        id_user INT NOT NULL,
        id_skill INT NOT NULL,
        etat ENUM ('pending', 'accepted', 'rejected', 'completed') DEFAULT 'pending',
        infos TEXT,
        created_at DATETIME,
        updated_at DATETIME,
        FOREIGN KEY (id_user) REFERENCES `user` (id_user),
        FOREIGN KEY (id_skill) REFERENCES skill (id_skill)
    );

CREATE TABLE
    rating (
        id_rating INT AUTO_INCREMENT PRIMARY KEY,
        id_exchange INT NOT NULL,
        id_user INT NOT NULL,
        rating_value TINYINT NOT NULL CHECK (rating_value BETWEEN 1 AND 5),
        comment TEXT,
        created_at DATETIME,
        updated_at DATETIME,
        FOREIGN KEY (id_exchange) REFERENCES exchange (id_exchange),
        FOREIGN KEY (id_user) REFERENCES `user` (id_user)
    );