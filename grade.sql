-- Create database
CREATE DATABASE grading_system;

-- Use the new database
USE grading_system;

-- Create a table for students
CREATE TABLE students (
    student_id INT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50)
);

-- Create a table for homework scores
CREATE TABLE homework (
    homework_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    homework1 INT,
    homework2 INT,
    homework3 INT,
    homework4 INT,
    homework5 INT,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- Create a table for quiz scores
CREATE TABLE quizzes (
    quiz_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    quiz1 INT,
    quiz2 INT,
    quiz3 INT,
    quiz4 INT,
    quiz5 INT,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- Create a table for midterm scores
CREATE TABLE midterm (
    midterm_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    midterm_score INT,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- Create a table for final project scores
CREATE TABLE final_project (
    final_project_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    final_project_score INT,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

CREATE TABLE final_grades (
    student_id INT,
    final_grade INT,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- Insert a fixed number of students
INSERT INTO students (student_id,first_name, last_name) VALUES
('2422','John', 'Doe'),
('8863','Jane', 'Smith'),
('6478','Emily', 'Jones'),
('5748','Michael', 'Brown'),
('5799','Sarah', 'Davis');
