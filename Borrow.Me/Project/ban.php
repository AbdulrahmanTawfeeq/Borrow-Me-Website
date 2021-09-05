<?php
session_start();
require 'mydb.php';
if(isset($_POST['ban']) && $_SERVER['REQUEST_METHOD']==='POST'){
  $user=$_POST['currentUser'];
  $sql="UPDATE users SET status=1 WHERE username='$user'";
  if($conn->query($sql)===TRUE){
    header("Location:index.php?user=banned.");
    exit();
  }else{
    header("Location:index.php?somthingWentWrong!!!");
    exit();
  }
}elseif(isset($_POST['unban']) && $_SERVER['REQUEST_METHOD']==='POST'){
  $user=$_POST['currentUser'];
  $sql="UPDATE users SET status=0 WHERE username='$user'";
  if($conn->query($sql)===TRUE){
    header("Location:index.php?user=unbanned.");
    exit();
  }else{
    header("Location:index.php?somthingWentWrong!!!");
    exit();
  }
}else{
    header("Location:index.php?cannotAccessThePageDirectly!");
    exit();
}
?>