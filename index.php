<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>射的システム</h1>
    <p>学籍番号</p>
    <form action="check.php" method="post">
        <input type="text" class="num" name="n1">
        <p>氏名</p>
        <input type="text" class="name" name="n2"><br>
       
        <?php 
            if ($_GET) {
                echo" <div>
                <p class='era'> </p>"
              .$_GET['errTxt']."
    
    
            </div>";
            }
            
            ?>
        <input type="submit" class="form" value="Enter">
    </form>
</body>
</html>