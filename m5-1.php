<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset = UTF-08>
        <title>mission_3-05</title>
    </head>
    <body>
    <body bgcolor="beige"></body>
<?php
//  DB接続    
    $dsn = "データベース名";
    $user = "ユーザー名";
    $password = "パスワード";
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
//  テーブル作成
    $sql = "CREATE TABLE IF NOT EXISTS completetb"
    . "("
    . "id INT AUTO_INCREMENT PRIMARY KEY," //投稿番号
    . "name char(32)," //名前
    . "comment TEXT," //コメント
    . "date TEXT," // 日付
    . "password TEXT" //パスワード
    . ");";
    $stmt = $pdo->query($sql);
//  編集機能
    if(!empty($_POST["edit"]) && !empty($_POST["edit_pass"])){
        $edit = $_POST["edit"];
        $edit_pass = $_POST["edit_pass"];
        $id = $edit; //投稿番号と同じだから
        $sql = 'SELECT * FROM completetb WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt ->bindParam(':id', $id, PDO::PARAM_INT); //ここで差し替え
        $stmt ->execute(); //sql実行
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            if($row['id'] == $edit ){
                $form_num = $row['id'];
                $form_name = $row['name'];
                $form_comment = $row['comment'];
            }
        }
    }else{
        $form_num = "";
        $form_name = "";
        $form_comment = "";
    }
?>
    <form action="" method="post">
        <b>犬派？猫派？それとも○○派…？</b>
        <hr>＊犬派でも猫派でもないそこのあなた！　○○には好きな動物を入れよう！<br><br>
        <input type="hidden" name="num" value="<?php echo $form_num?>">
        ＜新規投稿＞<br>
        名前　　　　
        <input type="text" name="name" value="<?php echo $form_name; ?>"><br>
        コメント　　
        <input type="text" name="comment" value="<?php echo $form_comment; ?>"><br>
        パスワード　
        <input type="text" name="pass">
        <input type="submit" name="submit" placeholder="送信">
        <br><br>
        <削除><br>
        削除対象番号
        <input type="number" name="delete"><br>
        パスワード　
        <input type="text" name="delete_pass">
        <input type="submit" name="submit" value="削除">
        <br><br>
        ＜編集＞<br>
        編集対象番号
        <input type ="number" name="edit"><br>
        パスワード　
        <input type="text" name=edit_pass>
        <input type ="submit" value="編集">
        <br>
    </form>
<?php
//  新規投稿
    if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass"])){
        if(empty($_POST["num"])){    //新規投稿の場合
//  INSERT文で書き込み        
            $sql = $pdo -> prepare("INSERT INTO completetb (name, comment, password, date) VALUES (:name, :comment, :password, :date)");
            $sql -> bindParam(':name', $name, PDO::PARAM_STR);
            $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
            $sql -> bindParam(':password', $pass, PDO::PARAM_STR);
            $sql -> bindParam(':date', $date, PDO::PARAM_STR);
            $name = $_POST["name"];
            $comment = $_POST["comment"];
            $pass = $_POST["pass"];
            $date = date("Y年m月d日　H:i:s");
            $sql -> execute();
//  SELECT文で表示
            $sql = 'SELECT * FROM completetb';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].',';
                echo $row['date'].'<br>';
            }
        }else{
            $edit_num = $_POST["num"];
            $id = $edit_num; //変更する投稿番号
            $edit_name = $_POST["name"];
            $edit_comment = $_POST["comment"]; //変更したい名前、変更したいコメントは自分で決めること
            $edit_pass = $_POST["edit_pass"];
            $date = date("Y年m月d日　H:i:s");
            $sql = 'UPDATE completetb SET name=:name,comment=:comment, date=:date, password=:password WHERE id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $edit_name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $edit_comment, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->bindParam(':password', $edit_pass, PDO::PARAM_STR);
            $stmt->execute();
//SELECT文で表示
            $sql = 'SELECT * FROM completetb';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].',';
                echo $row['date'].'<br>';
                }
            }
        }
//  削除機能
    if(!empty($_POST["delete"]) && !empty($_POST["delete_pass"])){
        $delete = $_POST["delete"];
        $delete_pass = $_POST["delete_pass"];
        $id = $delete;
        $sql = 'delete from completetb where id=:id';
        $stmt = $pdo->prepare($sql); //準備して
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); //差し替えて
        $stmt->execute(); //sql実行
//  SELECT文で表示        
        $sql = 'SELECT * FROM completetb';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['comment'].',';
            echo $row['date'].'<br>';
        }
    }

 
 
?>
    </body>
</html>

    
    
