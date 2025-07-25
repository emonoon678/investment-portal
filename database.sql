
CREATE DATABASE IF NOT EXISTS investment_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE investment_db;

CREATE TABLE IF NOT EXISTS opportunities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    location VARCHAR(255),
    area VARCHAR(100),
    type VARCHAR(100),
    status VARCHAR(50),
    duration VARCHAR(100),
    lastDate DATE,
    map TEXT
);

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admins (username, password) VALUES ('admin', '123456');
