<!DOCTYPE Html>
<html>
<head>
    <title>ユーザ更新</title>
    <style>
        body{
            background-color:lightcyan;
        }
        h1,h3,h5{
            text-align: center;
        }
        h1{
            color:crimson;
        }
        h3{
            color:purple;
        }
        h5{
            color:red;
        }
        .koshinclass{
            width: 650px;
            margin: auto;
        }
        input{
            width: 300px;
            height: 25px;
            font-size: 20px;
            margin:20px;
        }
        label{
            float: left;
            color:mediumblue;
        }
        #userID{
            margin-left: 100px;
        }
        #password{
            margin-left: 35px;
        }
        #username{
            margin-left: 102px;
        }
        #updateBtn,#deleteBtn,#backBtn{
            width: 100px;
            height: 50px;
            border-radius: 2px;
            font-size: 20px;
            background-color:royalblue;
            color:white;
        }
        #updateBtn{
            margin-left: 165px;
        }
        .deleteclass{
            margin-left: 355px;
            margin-top: -90px;
        }
        #backBtn{
            margin-top: 50px;
            margin-left: 480px;
        }
        .modal_class{
            background-color: rgba(50, 50, 50, 0.7);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none; 
        }
        .kakuninMsg{
            border: 1px solid brown;
            position:absolute;
            width: 450px;
            height: 180px;
            top: 35%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white; 
            border-radius: 6px;       
        }
        .checkBtn,.checkBtn1{
            width: 250px;
            margin: auto;
        }
        #okBtn,#kakuninBtn,#cancelBtn,#kakuninBtn1,#cancelBtn1{
            width: 70px;
            height: 35px;
            border-radius: 6px;
            background-color:royalblue;
            color:white;
        }
        #kakuninBtn,#kakuninBtn1{
            margin-left: 20px;
        }
        #cancelBtn,#cancelBtn1{
            width: 90px;
            margin-left: 50px;
        }
        .closeBtn{
            float: right;
            margin-right: 10px;
            font-size: 20px;
            cursor: pointer;
            margin-top: 12px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).on('click','#okBtn',function(){
            $('.modal_class').fadeOut(0.0001);
        });
        function deleteFunction(){
            $(document).on('click','#kakuninBtn',function(){
                $('.modal_class').fadeOut(0.0001);
                return true;
            }); 
        }
        function deleteEvent(){
            $('.checkBtn1').fadeIn(0.001);
            $('.modal_class').fadeIn(0.001);
            $('.checkuser').fadeIn(0.001);
            $('.checkdelete').fadeIn(0.001);
            $('.checkpassword1').fadeOut(0.0001);
            $('.checkpassword2').fadeOut(0.0001);
            $('.checkname').fadeOut(0.0001);
            $('.checkupdate').fadeOut(0.0001);
            $('.closeBtn').fadeOut(0.0001);
            $('.checkBtn').fadeOut(0.0001);
            var userID = document.forms["koshinform"]["userID"].value;
            document.getElementById("checkdelete").innerHTML = "ユーザID"+"("+userID+")、";
        }

        function koshinEvent(){
            var userID = document.forms["koshinform"]["userID"].value;
            var username = document.forms["koshinform"]["username"].value;
            var password = document.getElementById("password").value;
            var suji = /[0-9]/;
            var komoji = /[a-z]/;
            var oomoji = /[A-Z]/;
            var strlength = password.length;
            var kakuninSuji = password.match(suji);
            var kakuninKomoji = password.match(komoji);
            var kakuninOomoji = password.match(oomoji);
            if(password == ""){
                $('.modal_class').fadeIn(0.001);
                $('.closeBtn').fadeIn(0.001);
                $('.checkpassword1').fadeIn(0.001);       
                $('.checkpassword2').fadeOut(0.0001);
                $('.checkuser').fadeOut(0.0001);
                $('.checkname').fadeOut(0.0001);
               
                return false;
            }else
            if(strlength < 8 || !kakuninSuji || !kakuninKomoji || !kakuninOomoji){
                $('.modal_class').fadeIn(0.001);
                $('.checkpassword2').fadeIn(0.001);
                $('.checkpassword1').fadeOut(0.0001);
                $('.checkuser').fadeOut(0.0001);
                $('.checkname').fadeOut(0.0001);
                return false;
            }else if(username == ""){
                $('.modal_class').fadeIn(0.001);
                $('.checkname').fadeIn(0.001);
                $('.checkpassword1').fadeOut(0.0001);
                $('.checkpassword2').fadeOut(0.0001);
                $('.checkuser').fadeOut(0.0001);
                return false;
            }else{
                $('.modal_class').fadeIn(0.001);
                $('.checkBtn').fadeIn(0.001);
                $('.checkupdate').fadeIn(0.001);
                $('.checkuser').fadeIn(0.001);
                $('.checkpassword1').fadeOut(0.0001);
                $('.checkpassword2').fadeOut(0.0001);
                $('.checkname').fadeOut(0.0001);
                $('.checkdelete').fadeOut(0.0001);
                $('.checkBtn1').fadeOut(0.0001);
                $('.closeBtn').fadeOut(0.0001);
                document.getElementById("checkupdate").innerHTML = "ユーザID"+"("+userID+")、";   
            }
        }
        $(document).on('click','#kakuninBtn',function(){
            document.getElementById("koshinform").submit();
            $('#checksubmit').val(); 
            $('.modal_class').fadeOut(0.0001);
        });
        $(document).on('click','#kakuninBtn1',function(){
            document.getElementById("deleteform").submit();
            $('#checkdelete').val(); 
            $('.modal_class').fadeOut(0.0001);
        });
        $(document).on('click','#cancelBtn',function(){
            $('.modal_class').fadeOut(0.0001);
        });
        $(document).on('click','#cancelBtn1',function(){
            $('.modal_class').fadeOut(0.0001);
        });  
    </script>
</head>
<body>
    <h1>ユーザマスタ更新</h1>
    <hr width="45%">
    <?php
        //データに接続する
        include "dataConnect.php";
        if(!isset($_POST["koshinID"])){
        }else{
            $id = $_POST["koshinID"];       //ユーザ一覧表示画面からユーザIDを取得
            $select = "SELECT name FROM user_master WHERE id='$id'";    //ユーザID,パスワード、ユーザ名をセレクト
            $data = $connect->query($select);   //クエリ実行
            foreach($data as $value){
                $username = $value["name"];         //ユーザ名を取る
            }
        }
        //ユーザ更新設定
        $flag = "";
        if(!isset($_POST["updateBtn"]) && !isset($_POST["checksubmit"]) && !isset($_POST["checkdelete"])){         //更新、削除しない場合       
        }elseif(isset($_POST["checkdelete"])){                                    //削除する場合
            $updated_at = date("Y-m-d H:i:s");
            $update = "UPDATE user_master SET is_deleted='1', updated_at='$updated_at' WHERE id='$id'";   //フラッグをアップデート                       
            if($connect->query($update)){                   //クエリ実行出来る場合
                echo "<script type='text/javascript'>document.location.href='message.php?value=ユーザ削除が完了しました。';</script>"; 
            }        
        }elseif(isset($_POST["checksubmit"])){
            $passwordNew = trim($_POST["passwordNew"]);         //新しいパスワードを取得
            $username = $_POST["username"];                     //ユーザ名を取得
            $passHash = password_hash($passwordNew, PASSWORD_DEFAULT);    //パスワードをハッシュ化         
            $updated_at = date("Y-m-d H:i:s");                  //更新日を設定
            $update = "UPDATE user_master SET password='$passHash', name='$username', updated_at='$updated_at' WHERE id='$id'";    //ユーザ情報をアップデート
            if($connect->query($update)){
                echo "<script type='text/javascript'>document.location.href='message.php?value=ユーザ更新が完了しました。';</script>";    //メッセージ画面に遷移、更新メッセージを表示 
            }else{
                echo "更新に失敗しました。";
            }      
        }
    ?>
    <div class="modal_class">
        <div class="kakuninMsg">
            <div class="checkpassword1">
                <h3>パスワードを入力してください。</h3><br><br>
            </div>
            <div class="checkpassword2">
                <h3>パスワードは大文字含む、<br>英数字８桁以上で指定してください。</h3><br>
            </div>
            <div class="checkname">
                <h3>ユーザ名を入力してください。</h3><br><br>
            </div>
            <div class="checkuser">
                <div class="checkdelete">
                    <h3><div id="checkdelete"></div>このユーザの情報を<br>削除してもよろしいでしょうか？</h3>
                </div>
                <div class="checkupdate">
                    <h3><div id="checkupdate"></div>このユーザの情報を更新しますか？</h3><br>
                </div>
                <div class="checkBtn">
                    <form>
                        <button id="kakuninBtn" name="kakuninBtn" type="button">OK</button>
                        <button id="cancelBtn" name="cancelBtn" type="button">Cancel</button>
                    </form>             
                </div>
                <div class="checkBtn1">
                    <form>
                        <button id="kakuninBtn1" name="kakuninBtn1" type="button">OK</button>
                        <button id="cancelBtn1" name="cancelBtn1" type="button">Cancel</button>
                    </form>             
                </div>
            </div>
            <div class="closeBtn">
                <button id="okBtn">OK</button>
            </div>
        </div>
    </div>
    <div class="koshinclass">
        <form method="POST" id="koshinform" action="edituser.php" name="koshinform" onsubmit="return koshinForm()">
            <input name="checksubmit" id="checksubmit" type="hidden" value="">
            <input name="koshinID" type="hidden" value="<?php if(isset($_POST["koshinID"])){echo $_POST["koshinID"];} ?>">
            <label>ユーザID<input id="userID" name="userID" disabled value="<?php if(isset($id)){echo $id;} ?>"/></label></br>
            <label>新しいパスワード<input id="password" name="passwordNew" maxlength="25" type="password" value="<?php if(isset($_POST["passwordNew"])){echo $_POST["passwordNew"];} ?>"/></label></br>
            <label>ユーザ名<input id="username" name="username" value="<?php echo $username;?>"/></label></br>
            <input id="updateBtn" name="updateBtn" type="button" value="更新" onClick="koshinEvent()">        
        </form>
        <div class="deleteclass">
            <form method="POST" id="deleteform" name="deleteform" onsubmit="return deleteForm()">
                <input name="checkdelete" id="checkdelete" type="hidden" value="">
                <input name="koshinID" type="hidden" value="<?php if(isset($_POST["koshinID"])){echo $_POST["koshinID"];} ?>">
                <input id="deleteBtn" name="deleteBtn" type="button" value="削除" onClick="deleteEvent()">         
            </form>
        </div> 
        <div>
            <form action="userichiran.php" method="POST">
                <input id="backBtn" name="backBtn" type="submit" value="戻る">
            </form>
        <div>
    </div>
</body>
</html>
