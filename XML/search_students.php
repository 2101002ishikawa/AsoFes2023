<?php
require_once '../DAO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchKeyword = $_POST['searchKeyword'];

    $dao = new DAO();
    $studentsData = $dao->searchStudents($searchKeyword);

    // 検索結果をHTML形式で返す
    echo "<table border='1'>
            <tr>
                <th>学籍番号</th>
                <th>学生名</th>
                <th>日時</th>
                <th>フラグ</th>
                <th>更新</th>
                <th>削除</th>
            </tr>";

    foreach ($studentsData as $row) {
        echo "<tr>
                <td>" . $row['student_id'] . "</td>
                <td>" . $row['student_name'] . "</td>
                <td>" . $row['daytime'] . "</td>
                <td>" . $row['flag'] . "</td>
                <td><button onclick='openModal(\"" . $row['student_id'] . "\", \"" . $row['student_name'] . "\", \"" . $row['daytime'] . "\", \"" . $row['flag'] . "\")'>更新</button></td>
                <td><button onclick='confirmDelete(\"" . $row['student_id'] . "\")'>削除</button></td>
            </tr>";
    }

    echo "</table>";
}
?>
