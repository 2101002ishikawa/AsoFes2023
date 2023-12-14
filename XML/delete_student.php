<?php
require_once '../DAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['deleteStudentId'];

    $dao = new DAO();
    $dao->deleteStudent($studentId);
}
?>