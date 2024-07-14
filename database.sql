CREATE DATABASE preschool_math;
USE preschool_math;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Game Progress Table
CREATE TABLE game_progress (
    user_id INT NOT NULL,
    activity VARCHAR(255) NOT NULL,
    score INT DEFAULT 1,
    total INT DEFAULT 1,
    completed BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (user_id, activity),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Lesson Progress Table
CREATE TABLE lesson_progress (
    user_id INT NOT NULL,
    activity VARCHAR(255) NOT NULL,
    score INT DEFAULT 1,
    total INT DEFAULT 1,
    completed BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (user_id, activity),
    FOREIGN KEY (user_id) REFERENCES users(id)
);