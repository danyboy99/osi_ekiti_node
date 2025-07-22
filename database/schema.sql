-- Database Schema for Osi-Ekiti Users
-- This is like your database models/schema in Node.js

-- Create database (run this first)
CREATE DATABASE IF NOT EXISTS osi_ekiti_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE osi_ekiti_db;

-- Create users table with your exact schema
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    family_name VARCHAR(255) NOT NULL,
    phone_no VARCHAR(20) NOT NULL,
    quarters VARCHAR(255) NOT NULL,
    current_address TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create index for better search performance
CREATE INDEX idx_fullname ON users(fullname);
CREATE INDEX idx_family_name ON users(family_name);
CREATE INDEX idx_email ON users(email);
CREATE INDEX idx_quarters ON users(quarters);

-- Insert some sample data for testing
INSERT INTO users (fullname, email, family_name, phone_no, quarters, current_address) VALUES
('Adebayo Ogundimu', 'adebayo@example.com', 'Ogundimu', '+234-801-234-5678', 'Isale Osi', 'No. 15 Lagos Street, Lagos, Nigeria'),
('Folake Adeyemi', 'folake@example.com', 'Adeyemi', '+234-802-345-6789', 'Oke Osi', 'Plot 23 Abuja Close, Abuja, Nigeria'),
('Taiwo Olumide', 'taiwo@example.com', 'Olumide', '+234-803-456-7890', 'Agbado', 'House 7 Ibadan Road, Ibadan, Nigeria');
