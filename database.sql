-- Create database
CREATE DATABASE IF NOT EXISTS tena_hospital;
USE tena_hospital;

-- Patients table
CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Doctors table
CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    specialization VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    available_days VARCHAR(100),
    available_time VARCHAR(100)
);

-- Appointments table
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time VARCHAR(20) NOT NULL,
    symptoms TEXT,
    status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE
);

-- Admin table
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Insert sample doctors
INSERT INTO doctors (full_name, specialization, phone, email, available_days, available_time) VALUES
('Dr. Sarah Johnson', 'Cardiologist', '0712345678', 'sarah@tenahospital.com', 'Mon, Wed, Fri', '9:00 AM - 5:00 PM'),
('Dr. Michael Kimani', 'Pediatrician', '0723456789', 'michael@tenahospital.com', 'Tue, Thu, Sat', '10:00 AM - 6:00 PM'),
('Dr. Jane Mwangi', 'Dermatologist', '0734567890', 'jane@tenahospital.com', 'Mon-Fri', '8:00 AM - 4:00 PM');

-- Insert admin account (username: admin, password: admin123)
-- We'll hash the password in PHP later
INSERT INTO admin (username, password) VALUES ('admin', 'admin123');