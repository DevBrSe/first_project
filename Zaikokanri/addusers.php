<!DOCTYPE Html>
<html>
<head>
    <title>ユーザ登録</title>
    <link rel="stylesheet" href="Css/adduser.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="Js/adduser.js"></script>
</head>
<body>
    <h1>ユーザマスタ登録</h1>
    <hr width="40%">
    <?php
        //データに接続する
        include "dataConnect.php";
        $message = "";
        $torokuMsg = "";
        //ユーザID設定
        $selectid = "SELECT id FROM user_master";           //登録したユーザをセレクト
        $dataid = $connect->query($selectid);               //クエリ実行
        $countid = mysqli_num_rows($dataid);                //登録したユーザIDの数を確認
        $countid += 1;
        $id = str_pad($countid,8,'0',STR_PAD_LEFT);         //ユーザID設定
        if(!isset($_POST["torokuBtn"])){                    //登録動作確認
        }else{
            $password = trim($_POST["password"]);           //パスワードを取得                            
            $usernames = trim($_POST["usernames"]);           //ユーザ名を取得
            if($password==""){                              //パスワード入力確認(空白場合)
                $message = "パスワードを入力してください。";
                goto outputMsg;
            }elseif(strlen($password)<8                     //入力したパスワードは8桁以下
                    || !preg_match("/[0-9]/", $password)    //入力したパスワードは数字未入力
                    || !preg_match("/[a-z]/", $password)    //入力したパスワードは小文字未入力
                    || !preg_match("/[A-Z]/", $password)){  //入力したパスワードは大文字未入力
                $message = "パスワードは大文字含む英数字８桁以上で指定してください。";
                goto outputMsg;
            }elseif($usernames==""){                         //ユーザ名入力確認(空白場合)
                $message = "ユーザ名を入力してください。";
                goto outputMsg;
            }else{
                $passHash = password_hash($password, PASSWORD_DEFAULT);    //パスワードをハッシュ化   
                $authority_id = 0;                          //authority_id設定
                $is_deleted = 0;                            //状態設定
                $created_at = date("Y-m-d H:i:s");          //登録設定 
                $updated_at = date("Y-m-d H:i:s");          //更新日設定
                //取得した値と設定した値をインサート
                $insert = "INSERT INTO user_master (id, password, name, authority_id, is_deleted, created_at, updated_at) 
                            VALUES ('$id', '$passHash', '$usernames', $authority_id, $is_deleted, '$created_at', '$updated_at')";
                $data = $connect->query($insert);           //クエリ実行
                if(!empty($data)){                          //クエリ実行確認(実行した場合)
                    $torokuMsg = "ユーザ登録が完了しました。";    //登録出来たメッセージ
                    $password = "";
                    $usernames = "";
                    goto outputMsg;
                }else{                                      //クエリ実行確認(実行しなかった場合)
                    $message = "ユーザ登録に失敗しました。";    //エラーメッセージ
                    goto outputMsg;
                }
            }
        }
        outputMsg:                      //メッセージ出力       
        echo "<h5>".$message."</h5>";
        if($torokuMsg != ""){
            echo "<div class='modal_toroku'><div class='kakuninMsg'><div class='closeBtn'>✖</div><p>".$torokuMsg."</p></div></div>"; 
        }      
    ?>
    <div class="usertotoku_class">
        <form action="addusers.php" method="POST">
            <label>ユーザID<input id="userID" name="userID" disabled value="<?php echo $id;?>"/></label><br>
            <label>パスワード<input id="password" name="password" type="password" maxlength="25" value="<?php if(isset($password)){echo $password;}?>"/></label><br>
            <label>ユーザ名<input id="usernames"name="usernames" value="<?php if(!empty($usernames)){echo $usernames;}?>"/></label><br>
            <input id = "torokuBtn" name="torokuBtn" type="submit" value="登録">
        </form>
        <div class="backBtn">
            <form action="user_master_kanri.php" method="POST">
                <input id="backBtn" name="backBtn" type="submit" value="戻る">
            </form>
        </div>
    </div>
</body>
</html>
