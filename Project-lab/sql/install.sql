CREATE DATABASE todolist;

USE todolist;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE todo_lists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    todo_id INT NOT NULL,
    description TEXT NOT NULL,
    status ENUM('incomplete', 'complete') NOT NULL DEFAULT 'incomplete',
    FOREIGN KEY (todo_id) REFERENCES todo_lists(id) ON DELETE CASCADE
);

ALTER TABLE todo_lists
ADD COLUMN description TEXT,
ADD COLUMN due_date DATE,
ADD COLUMN priority ENUM('Low', 'Medium', 'High') DEFAULT 'Medium',
ADD COLUMN color VARCHAR(7) DEFAULT '#ffffff';
