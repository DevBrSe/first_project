<!DOCTYPE Html>
<html>
<head>
    <title>ログイン</title>
    <link rel="stylesheet" href="Css/login.css">
</head>
<body>
    <h1>ログイン</h1>
    <hr width="35%">
    <?php
        //データに接続する
        include "dataConnect.php";
        $message = "";
        if(!isset($_POST["loginBtn"])){                 //ログイン動作しない場合     
        }else{
            if(strlen(trim($_POST["userID"]))==0){      //ユーザIDを未入力場合
                $message = "ユーザIDを入力してください。";
                goto outputMsg;
            }elseif(strlen(trim($_POST["password"]))==0){   //パスワードを未入力場合
                $message = "パスワードを入力してください。";
                goto outputMsg;
            }else{
                $userID = trim($_POST["userID"]);           //ユーザIDを取得
                $password = trim($_POST["password"]);       //パスワードを取得
                $select = "SELECT id,name, password FROM user_master WHERE id='$userID' AND is_deleted=0";    //ユーザIDとパスワードをセレクト
                $data = $connect->query($select);           //クエリ実行
                $count = mysqli_num_rows($data);            //データの存在を確認
                if($count==0){
                    $message = "ユーザIDまたはパスワードが違います";      //エラーメッセージを出力
                    goto outputMsg;
                }else{
                    $result = mysqli_fetch_array($data);     //データの連想配列を取得             
                    $id = $result["id"];                     //ユーザIDを取る
                    $name = $result["name"];
                    $passHash = $result["password"];         //ハッシュ化パスワードを取得
                    if(password_verify($password, $passHash)==false){       //入力したパスワードと登録したパスワードを比較
                        $message = "ユーザIDまたはパスワードが違います";      //エラーメッセージを出力
                        goto outputMsg;  
                    }else{
                        header("location: topmenu.php");                //トップメニュー画面に移動する
                    }    
                } 
            }          
        }
        outputMsg:                      //メッセージを出力
        echo "<h5>".$message."</h5>";
    ?>
    <div class="login_class">
        <form method="POST">
            <label>ユーザID：<input id="userID" name="userID" maxlength="8" value="<?php if(isset($_POST["userID"])){echo $_POST["userID"];}?>"/></label></br>
            <label>パスワード：<input id="password" name="password" type="password" maxlength="25" value="<?php if(isset($_POST["password"])){echo $_POST["password"];}?>"/></label></br>
            <input id="login" name="loginBtn" type="submit" value="ログイン"/>
        </form>
    </div>
</body>
</html>
