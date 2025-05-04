CREATE DATABASE IF NOT EXISTS tp_mvc;
USE tp_mvc;

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    nim VARCHAR(20) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    join_date DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_code VARCHAR(10) NOT NULL,
    course_name VARCHAR(100) NOT NULL,
    credit INT NOT NULL,
    semester VARCHAR(10) NOT NULL
);

CREATE TABLE IF NOT EXISTS enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date DATE NOT NULL,
    grade VARCHAR(2),
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

INSERT INTO courses (course_code, course_name, credit, semester) VALUES
('CS101', 'Arsitektur Komputer', 3, 'Ganjil'),
('CS102', 'Algoritma dan Pemrograman', 4, 'Ganjil'),
('CS203', 'Sistem Basis Data', 3, 'Genap'),
('CS204', 'Desain Pemrograman Web', 4, 'Genap');