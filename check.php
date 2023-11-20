<?php
    // データベースに関する情報を記載する
    $dao = new PDO(
                'mysql:host=localhost;
                dbname=AsoFes;
                charset=utf8',   
                'データベースでのユーザID',
                'データベースでのパスワード'
            );

    //sqlの記述
    $sql = "SELECT * FROM aso WHERE AsoName = :AsoName";

    // sqlにデータを埋め込めるようにする
    $ninni = $dao->prepare($sql);

    //sqlに必要なデータを埋め込む
    $ninni->bindValue(":AsoName","入れたいデータ",PDO::PARAM_STR);

    //実行する
    $ninni->execute();

    //実行結果によってページを遷移させる
    $data = $ninni->fetchAll();

?>