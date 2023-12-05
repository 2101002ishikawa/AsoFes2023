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

    try{

    //sqlに必要なデータを埋め込む
    $ninni->bindValue(":student_id",$_POST['n1'],PDO::PARAM_STR);
    $ninni->bindValue(":student_name",$_POST['n2'],PDO::PARAM_STR);
    date_default_timezone_set('Asia/Tokyo');
    $ninni->bindValue(":daytime",date("Y-m-d H:i:s"),PDO::PARAM_STR);

    
    //実行する
    $ninni->execute();

    //実行結果によってページを遷移させる
   
   header('Location:'.'botan2.html');

    
    }catch(Exception $e){
        header('Location:'.'botan1.html');
    }

?>