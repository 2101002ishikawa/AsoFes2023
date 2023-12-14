<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者画面</title>
</head>
<body>

    <label for="searchKeyword">検索:</label>
    <input type="text" id="searchKeyword" name="searchKeyword">
    <button onclick='searchStudents()'>検索</button>
        
<?php
    require_once 'DAO.php';
    $dao = new DAO();

    try {
        $studentsData = $dao->selectAllStudents();
        // 結果を表として出力
        echo "<table id='studentsTable' border='1'>
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
                    <td> <button onclick='confirmDelete(".$row['student_id'].")'>削除</button></td>
                </tr>";
        }

        echo "</table>";

    } catch (PDOException $e) {
        echo "接続エラー: " . $e->getMessage();
    }
?>

<!-- モーダル -->
<div id="updateModal" style="display:none;">
        <form id="updateForm">
            <label for="updateStudentId">学籍番号:</label>
            <input type="text" id="updateStudentId" name="updateStudentId" required>
            <br>
            <label for="updateStudentName">学生名:</label>
            <input type="text" id="updateStudentName" name="updateStudentName" required>
            <br>
            <label for="updateDaytime">日時:</label>
            <input type="datetime" id="updateDaytime" name="updateDaytime" required>
            <br>
            <label for="updateFlag">フラグ:</label>
            <input type="text" id="updateFlag" name="updateFlag" required>
            <br>
            <input type="submit" value="更新">
            <div id="errorContainer"></div>
        </form>
    </div>

<script>
    function openModal(studentId, studentName, daytime, flag) {
        // モーダルを表示
        document.getElementById('updateModal').style.display = 'block';

        // モーダル内のフォームにデータをセット
        document.getElementById('updateStudentId').value = studentId;
        document.getElementById('updateStudentName').value = studentName;
        document.getElementById('updateDaytime').value = formatDate(daytime); // datetimeのフォーマットに変換
        document.getElementById('updateFlag').value = flag;

        // エラーメッセージをリセット
        resetErrorMessages();

        // フォームが送信されたときの処理を設定
        document.getElementById('updateForm').addEventListener('submit', function (event) {
            event.preventDefault(); // デフォルトのフォーム送信を防ぐ

            // バリデーションを実行
            if (validateForm()) {
                // フォームデータを取得
                var formData = new FormData(document.getElementById('updateForm'));

                // Ajaxを使用してサーバーに更新リクエストを送信
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'XML/update_student.php', true);
                xhr.onload = function () {
                    // 更新処理が成功したらモーダルを閉じるなどの処理を追加
                    document.getElementById('updateModal').style.display = 'none';
                };
                xhr.send(formData);
            }
        });
    }

    function formatDate(datetime) {
        // datetimeのフォーマットに変換する処理を実装
        return datetime; // 適切な実装に置き換える
    }

    function resetErrorMessages() {
        // エラーメッセージをリセットする処理を実装
    }

    function validateForm() {
        var studentId = document.getElementById('updateStudentId').value;
        var studentName = document.getElementById('updateStudentName').value;
        var daytime = document.getElementById('updateDaytime').value;
        var flag = document.getElementById('updateFlag').value;

        var isValid = true;

        // 各フィールドに対するバリデーションを実行
        if (!validateStudentId(studentId)) {
            displayErrorMessage('学籍番号は7桁の数字で、2000000～2399999の範囲内である必要があります。');
            isValid = false;
        }

        if (!validateStudentName(studentName)) {
            displayErrorMessage('学生名は必須です。');
            isValid = false;
        }

        if (!validateDaytime(daytime)) {
            displayErrorMessage('日時は正しい形式で入力してください。');
            isValid = false;
        }

        if (!validateFlag(flag)) {
            displayErrorMessage('フラグは「Y」か「N」のいずれかを入力してください。');
            isValid = false;
        }

        return isValid;
    }
    function validateStudentId(studentId) {
        // 学籍番号のバリデーション
        // 1. 7桁の数字であること
        // 2. 範囲が2000000～2399999であること
        return /^\d{7}$/.test(studentId) && parseInt(studentId) >= 2000000 && parseInt(studentId) <= 2399999;
    }

    function validateStudentName(studentName) {
        // 学生名のバリデーション
        // 特定の条件があれば追加する
        return true; // 今回は必須項目のみなので常に true
    }

    function validateDaytime(daytime) {
        // 日時のバリデーション
        // datetimeの形式に合致するかを確認する
        // 例: YYYY-MM-DDTHH:mm形式 (datetime-localの値) としている
        return /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/.test(daytime);
    }

    function validateFlag(flag) {
        // フラグのバリデーション
        // "Y" または "N" であるかを確認する
        return flag === 'Y' || flag === 'N';
    }

    function displayErrorMessage(message) {
        // エラーメッセージを表示する処理
        // 例: モーダル内の特定の場所にエラーメッセージを表示する
        var errorContainer = document.getElementById('errorContainer');
        errorContainer.innerHTML = message;
    }



    function confirmDelete(studentId) {
        var result = confirm("本当に削除しますか？");

        if (result) {
            // 確認ダイアログでOKがクリックされた場合、削除処理を実行
            deleteStudent(studentId);
        }
    }

    function deleteStudent(studentId) {
        // Ajaxを使用してサーバーに削除リクエストを送信
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'XML/delete_student.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            // 削除処理が成功したらページをリロードなどの処理を実行
            location.reload();
        };
        xhr.send('deleteStudentId=' + studentId);
    }

    function searchStudents() {
        var searchKeyword = document.getElementById('searchKeyword').value;

        // Ajaxを使用してサーバーに検索リクエストを送信
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'XML/search_students.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            // 検索結果を表に反映するなどの処理を実行
            document.getElementById('studentsTable').innerHTML = xhr.responseText;
        };
        xhr.send('searchKeyword=' + searchKeyword);
    }

</script>
</body>
</html>