-- Create a new database schema
CREATE DATABASE IF NOT EXISTS edulearn;

-- Use the newly created database
USE edulearn;

-- Drop the user if it exists
DROP USER IF EXISTS 'edulearn_user'@'localhost';

-- Create a new database user
CREATE USER 'edulearn_user'@'localhost' IDENTIFIED BY 'edulearn_pass';

-- Grant all privileges to the new user on the newly created database
GRANT ALL PRIVILEGES ON edulearn.* TO 'edulearn_user'@'localhost';

-- Create a user table to store sign-in and sign-up data
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert a user into the users table
INSERT INTO users (username, email, password) VALUES ('edulearn_user', 'mashiyanak@gmail.com', 'edulearn_pass');
