<?php
    
    // データベースに関する情報を記載する
    $dao = new PDO(
                'mysql:host=localhost;
                dbname=AsoFes;
                charset=utf8',   
                'asofes',
                'asofes2023'
    );

    //sqlの記述
    $sql = "INSERT INTO `students`(`student_id`, `student_name`, `daytime`, `flag`) VALUES (:student_id,:student_name,:daytime,'Y')";
 
    // sqlにデータを埋め込めるようにする
    $ninni = $dao->prepare($sql);

    

    //実行結果によってページを遷移させる
   



   try {
    // 例外が発生する可能性があるコード
    // 例: データベースへの接続、ファイルの読み込み、その他のリソースの取得など

    //sqlに必要なデータを埋め込む
    $ninni->bindValue(":student_id",$_POST['n1'],PDO::PARAM_STR);
    $ninni->bindValue(":student_name",$_POST['n2'],PDO::PARAM_STR);
    date_default_timezone_set('Asia/Tokyo');
    $ninni->bindValue(":daytime",date("Y-m-d H:i:s"),PDO::PARAM_STR);

    //実行する
    $ninni->execute();
    
    header('Location:'.'botan2.html');

} catch (Exception $e) {
    // 例外が発生した場合の処理
    // $eには例外オブジェクトが渡され、詳細な情報を取得できる

    header('Location:'.'botan1.html');

}

?>