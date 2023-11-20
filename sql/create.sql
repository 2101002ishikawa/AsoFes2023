DROP DATABASE IF EXISTS AsoFes;
CREATE DATABASE AsoFes;
USE AsoFes;
CREATE TABLE Students (
    student_id VARCHAR(191) NOT NULL, 
    student_name VARCHAR(191) NOT NULL, 
    daytime DATETIME NOT NULL, 
    flag VARCHAR(191) NOT NULL, 
    PRIMARY KEY (student_id)
);