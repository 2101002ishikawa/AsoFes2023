<?php
require_once '../DAO.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $studentId = $_POST['updateStudentId'];
        $studentName = $_POST['updateStudentName'];
        $daytime = $_POST['updateDaytime'];
        $flag = $_POST['updateFlag'];

        $dao = new DAO();
        $dao->updateStudent($studentId, $studentName, $daytime, $flag);

        echo '更新が成功しました'; // 正常なレスポンスを返す
    }
} catch (Exception $e) {
    http_response_code(500); // サーバーエラーのステータスコードを設定
    echo '更新中にエラーが発生しました: ' . $e->getMessage();
}
