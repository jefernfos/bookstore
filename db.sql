CREATE DATABASE IF NOT EXISTS EssentialReadsDB
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE EssentialReadsDB;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BINARY(16) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(30) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) DEFAULT NULL,
    type ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS ebooks (
    ebook_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(100) NOT NULL UNIQUE,
    title VARCHAR(100) NOT NULL,
    subtitle VARCHAR(100) DEFAULT NULL,
    author VARCHAR(100) NOT NULL,
    publisher VARCHAR(100) DEFAULT NULL,
    price DECIMAL(10, 2) NOT NULL,
    pages INT NOT NULL CHECK (pages BETWEEN 1 AND 9999),
    year INT NOT NULL CHECK (year BETWEEN 1 AND 9999),
    language VARCHAR(30) NOT NULL,
    description TEXT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_size INT UNSIGNED NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    cover_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);  
/*
CREATE TABLE IF NOT EXISTS genres (
    genre_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS ebook_genres (
    ebook_id INT NOT NULL,
    genre_id INT NOT NULL,
    PRIMARY KEY (ebook_id, genre_id),
    FOREIGN KEY (ebook_id) REFERENCES ebooks(ebook_id) ON DELETE CASCADE,
    FOREIGN KEY (genre_id) REFERENCES genres(genre_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS user_library (
    user_id BINARY(16) NOT NULL,
    ebook_id INT NOT NULL,
    PRIMARY KEY (user_id, ebook_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (ebook_id) REFERENCES ebooks(ebook_id) ON DELETE CASCADE
);
*/