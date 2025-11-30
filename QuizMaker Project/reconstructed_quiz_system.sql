

CREATE DATABASE IF NOT EXISTS quiz_system;
USE quiz_system;


CREATE TABLE IF NOT EXISTS quiztypes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);


CREATE TABLE IF NOT EXISTS quizzes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL,
    quiztype_id INT NOT NULL,
    question TEXT NOT NULL,
    answer VARCHAR(255) NOT NULL,
    FOREIGN KEY (quiztype_id) REFERENCES quiztypes(id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS choices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    choice VARCHAR(255) NOT NULL,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL
);


CREATE TABLE IF NOT EXISTS quiz_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    quizcode VARCHAR(50) NOT NULL,
    score INT NOT NULL
);


INSERT INTO quiztypes (name) VALUES
('multiple_choice'),
('true_false'),
('identification');
