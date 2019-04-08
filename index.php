<?php
    include "connect.php";
    ini_set("session.cookie_httponly", 1);
    session_start();
    $counter_name = "counter.txt";
    if (!file_exists($counter_name)) {
        $f = fopen($counter_name, "w");
        fwrite($f, "0");
        fclose($f);
        chmod($f, 0777);
    }
    $counterVal = 0;
    $f = fopen($counter_name, "r");
    $counterVal = fread($f, filesize($counter_name));
    fclose($f);
    chmod($f, 0777);

    if (!isset($_SESSION['hasVisited'])) {
        $_SESSION['hasVisited'] = "yes";
        $counterVal++;
        if (is_writable($counter_name)){
            $f = fopen($counter_name, "w");
            fwrite($f, $counterVal);
            fclose($f);
            chmod($f, 0777);
        }
    }
    #unset($_SESSION['hasVisited']);
?>

<?php
    $count = 1;
    if (isset($_COOKIE['counter'])) {
        $count = $_COOKIE['counter'] + 1;
    }
    setcookie('counter', $count, time() + 30*24*60*60, $secure=True, $httponly=True);
?>

<?php
    include 'gen_rand_string.php';
    if (!isset($_COOKIE['unique_ID'])) {
        $id = generateRandomString();
        $_COOKIE['unique_ID'] = $id;
        setcookie('unique_ID', $id, time() + 30*24*60*60, $secure=True, $httponly=True);
    }
?>

<?php
    function replace($str) {
        $str = str_replace("<", "", $str);
        $str = str_replace(">", "", $str);
        $str = str_replace("'", "", $str);
        $str = str_replace('"', "", $str);
        $str = str_replace(";", "", $str);
        return $str;
    }

    #echo replace("adkf''\"jald;;<<.''''");

    $conn = OpenCon();

    $guestName=$_POST['guestName'];
    $guestSubject=$_POST['guestSubject'];
    $guestContent=$_POST['guestContent'];
    $guestTime = date("Y:m:d H:i:s",time()+28800);
    $guestUniqueID = $_COOKIE['unique_ID'];

    $guestName = replace("$guestName");
    $guestSubject = replace("$guestSubject");
    $guestContent = replace("$guestContent");

    if(isset($guestContent) AND isset($guestSubject) AND $guestContent != "" AND $guestSubject != "") {
        $sql = "insert into guest (guestName, guestSubject, guestContent, guestTime, guestUniqueID)
                           values ('$guestName', '$guestSubject', '$guestContent', '$guestTime','$guestUniqueID')";
        if ($conn->query($sql) === True) {
            echo "Success<br>";
        }
        else {
            echo "Error: ". $sql. "<br>" . $conn->error;
        }
        CloseCon($conn);
        header("location:message_board.php");
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我要留言</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<style>
 .container{
  margin:auto;
  background-color:#f5f5f5;
  width:800px;
  padding-bottom: 20px;
 }
 .button{
  text-align:center;
  padding:20px 0;
 }
 .top h3{
  font-family:微軟正黑體;
  text-align:center;
  padding:10px 0;
 }
 .form-group{
  font-family:微軟正黑體;
  font-size:16px;
 }
 .myself {
    text-align:center;
    margin: 20px;
 }
 .visitor {
    text-align:center;
    margin: 20px;
    border: solid coral;
 }
</style>
<body>
    <div class='myself'>
        <h1> Vic Tai </h1>
    </div>
    <div class='myself'>
        <img src="img/me.jpg" width=200px height=auto>
    </div>
    <div class='myself'>
        <h2> Brief Intro </h2>
        <p> Currently a Computer Science student at National Taiwan University.<p>
    </div>
    <div class='myself'>
        <h2> Recent Findings </h2>
        <p> Building a website is freaking hard. </p>
    </div>
    <div class='visitor'>
        <?php
            echo "You are visitor No.";
            for ($i = 0; $i < strlen($counterVal); $i++) {
                $n = substr($counterVal, $i, 1);
                if (!is_numeric($n)) break;
                echo "<img src=img/$n.png width=20px height=20px>";
            }
            echo " !<br><br>";
            echo "You have visited";
            for ($i = 0; $i < strlen($count); $i++) {
                $n = substr($count, $i, 1);
                if (!is_numeric($n)) break;
                echo "<img src=img/$n.png width=20px height=20px>";
            }
            echo " times !<br>";
        ?>
    </div>
    <div class='myself'>
        <a href="message_board.php"><button type="button" class="btn btn-primary btn-lg">留言版</button></a>
    </div>

<div class="container">
 <div class="top">
    <h3>新增留言</h3>
    </div>
    <form id="form1" name="form1" method="post" action="" class="form-horizontal">
        <div class="form-group">
            <label for="guestName" class="col-sm-4 control-label">暱稱：</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" placeholder="您的暱稱" name="guestName" id="guestName" />
            </div>
        </div>
        <div class="form-group">
            <label for="guestSubject" class="col-sm-4 control-label">留言主旨：</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="guestSubject" id="guestSubject" />
            </div>
        </div>
        <div class="form-group">
          <label for="guestContent" class="col-sm-4 control-label">留言內容：</label>
          <div class="col-sm-6">
              <textarea name="guestContent" class="form-control" id="guestContent" rows="5"></textarea>
          </div>
        </div>
        <div class="button">
            <input type="submit" name="button" id="button" value="送出" class="btn"/>
        </div>
    </form>
    
</div>
</body>
</html>
