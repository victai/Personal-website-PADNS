<?php
if(isset($_POST['usr'])){
require("connect2.php");
$username=$_POST['usr'];
$password=$_POST['pwd'];
$data=mysql_query("select * from admin where usr = '$username' and pwd = '$password'");
 if(mysql_num_rows($data)>=1){
  header("location:p13-admin.php");
 }else{
  header("location:p13-login.php?msg=error");
 }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理員登入介面</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<style>
 *{
  padding:0;
  margin:0;
 }
 .container{
  padding:20px 0;
        background-color:#f5f5f5;
        width:800px;
 }
 h2{
  font-family:微軟正黑體;
  padding:0 0 20px 0;
 }
 .btn{
  font-size:20px;
  font-family:微軟正黑體;
 }
 .respond{
  text-align:center;
  padding:20px 0;
  font-family:微軟正黑體;
  font-size:20px;
 }
</style>
</head>

<body>
<div class="container">
 <h2 align="center">管理員登入</h2>
    <form class="form-horizontal" role="form" id="form1" name="form1" method="post" action="">
    
    <div class="form-group">
        <label class="control-label col-sm-4" for="usr">UserName:</label>
        <div class="col-sm-4">
            <input name="usr" type="text" class="form-control" id="usr" placeholder="Enter username">
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-sm-4 for="pwd">Password:</label>
        <div class="col-sm-4">
            <input name="pwd" type="password" class="form-control" id="pwd" placeholder="Enter password">
        </div>
    </div>
    <div>
        <div align="center" style="padding-top:30px">
            <input name="button" type="submit" class="btn" id="button" value="確認" />
        </div>
      </div>
    </form>
    <div class="respond">
    <?php
        if($_GET['msg']=="error"){
            echo'<p class="bg-danger">查無此人</p>';
        }
    ?>
    </div>
</div>
</body>
</html>