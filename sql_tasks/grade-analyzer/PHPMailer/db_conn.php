<?php 

function dbConn(){
$host = 'db'; 
$username = 'root';
$password = 'password';
$database = 'crud';

return new mysqli($host,$username,$password,$database);
}

function createSubjectTable($conn){
    $sql = "CREATE TABLE IF NOT EXISTS subject (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name varchar(20) NOT NULL
    )";
    $conn->query($sql);

    $conn->close();
}

function createClassTable($conn){
    $sql = "CREATE TABLE IF NOT EXISTS class (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_name INT(20) NOT NULL,
    teacher_id INT(5) NOT NULL ,
    CONSTRAINT fk_teacher FOREIGN KEY (teacher_id) REFERENCES teacher(id) ON DELETE CASCADE
    )";
    $conn->query($sql);

    $conn->close();
}

function createMarksTable($conn){
    $sql = "CREATE TABLE IF NOT EXISTS marks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id int(20) not null,
    subject_id int(20) not null,
    marks_obtained int (5) not null,
    constraint fk_marks_student foreign key (student_id) references student(id) on delete cascade,
    constraint fk_marks_subject foreign key (subject_id) references subject(id) on delete cascade
    )";
}
function createStudentTable($conn){
    $sql = "CREATE TABLE IF NOT EXISTS student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    emali varchar(50) not null,
    phone bigint(20) not null,
    address varchar(15) not null,
    class_id int(5) not null,
    constraint fk_class foreign key (class_id) references class(id) on delete cascade
    )";
}
function createTeacherTable($conn){
    $sql = "CREATE TABLE IF NOT EXISTS teacher (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name varchar(50) not null
    )";
}
function createTeacherClassTable($conn){
    $sql = "CREATE TABLE IF NOT EXISTS teacher_class (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id int(5) not null,
    teacher_id int(5) not null,
    constraint fk_class foreign key (class_id) references class(id) on delete cascade,
    constraint fk_teacher foreign key (teacher_id) references teacher(id) on delete cascade
    )";
}
function createTeacherClassSubjectTable($conn){
    $sql = "CREATE TABLE IF NOT EXISTS teacher_class_subject (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id int(5) not null,
    class_id int(5) not null,
    subject_id int(5) not null,
    constraint fk_teacher foreign key (teacher_id) references teacher(id) on delete cascade,
     constraint fk_class foreign key (class_id) references class(id) on delete cascade,
     constraint fk_subject foreign key (subject_id) references subject(id) on delete cascade
    )";
}
// function createAdminTable($conn){
//     $sql = "CREATE TABLE IF NOT EXISTS admin (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     emali varchar(50) not null,
//     phone bigint(20) not null,
//     address varchar(15) not null,
//     class_id int(5) not null,
//     constraint fk_class foreign key (class_id) references class(id) on delete cascade
//     )";
// }
function createUserTable($conn){
    $sql = "CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name varchar(50) not null,
    role ENUM('student','teacher','class_teacher') not null,
    password VARCHAR(255)
    )";
}

?>