CREATE DATABASE IF NOT EXISTS brightledger_registration
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE brightledger_registration;

CREATE TABLE IF NOT EXISTS users (
    ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    Name VARCHAR(100) NOT NULL,
    Email VARCHAR(190) NOT NULL,
    Mobile VARCHAR(20) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    Created_At TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (ID),
    UNIQUE KEY uq_users_email (Email)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
