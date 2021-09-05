<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8">
  <meta http-equiv="refresh" content="">
  <link rel="stylesheet" href="bootstrap.min.css">
  <script src="jquery.min.js"></script>
  <script src="bootstrap.min.js"></script>
<style>



.replyForm{
  display: block;
  position: relative;
  float: left;
  background-color: ;
  color: #aaa;
  width: 45%;

}



.reply{
  background-color: inherit;
  border: 0px;
  color: #aaa;
  cursor: pointer;
}

p{
  position: relative;
  left: 80px;
}

.container {
  width: 500px;
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 10px auto;
  display: block;
  word-wrap: break-word;
}

.close {
  position: absolute;
  right: 25px;
  top: 0;
  color: #000;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: red;
  cursor: pointer;
}





.container img {
  float: left;
  max-width: 60px;
  width: 100%;
  margin-right: 20px;
  border-radius: 50%;
}

.container img.right {
  float: right;
  margin-left: 20px;
  margin-right:0;
}

.time-right {
  float: right;
  color: #aaa;
}


.mainCon{
  background-color: inherit;
  margin: 0 auto;
  display: block;
  width: 600px;
}


.modal {
  display: block; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  padding-top: 60px;
}

.modal-content {
  background-color: #fefefe;
  border: 1px solid #888;
}

.animate {
  -webkit-animation: animatezoom 0.6s;
  animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
  from {-webkit-transform: scale(0)} 
  to {-webkit-transform: scale(1)}
}
  
@keyframes animatezoom {
  from {transform: scale(0)} 
  to {transform: scale(1)}
}


@media only screen and (max-width: 767px){
 .mainCon{
  width: 100%;
 }
}

@media only screen and (max-width: 600px){
 .container{
  width: 100%;
 }
}




</style>
</head>


<body>


<div id="id01" class="modal">
<div class="mainCon modal-content animate">
  <?php
    if($_SESSION['user']!="ADMIN"){
      ?>
        <a href="index.php"><span onclick="fSeen()" class="close" title="Close">&times;</span></a>
      <?php
    }else{
      ?>
        <a href="index.php"><span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close">&times;</span></a>
      <?php
    }
  ?>
  

<?php
require 'mydb.php';

  echo "<h2 style='text-align:center;'>Inbox Messages</h2>";
if($_SESSION['user']=='ADMIN'){
  $sql="SELECT * FROM contact where `to`='ADMIN' AND seen=0";
}else{
  $user=$_SESSION['user'];
  $sql="SELECT * FROM contact where `to`='$user' AND seen=0";
}
$result=$conn->query($sql);
if($result->num_rows>0){
  while($row=$result->fetch_assoc()){
    ?>
    <div class="container">
    <?php
    $cSubmitTime=$row['cSubmitTime'];
    $cFullName=$row['cFullName'];
    $cSubject=$row['cSubject'];
    $cMessage=$row['cMessage'];
    $user=$row['username'];
    
    ?>
      <script type="text/javascript">
          function fSeen(){
            <?php
            $current=$_SESSION['user'];
              $sqlSeen="UPDATE contact SET seen=1 WHERE cMessage='$cMessage' AND username='ADMIN' AND `to`='$current'";
              if($conn->query($sqlSeen)===TRUE){}
            ?>
          }
      </script>
    <?php

        $sqlStatus="SELECT status FROM imguploads WHERE user='$user'";
        $result2=$conn->query($sqlStatus);
          $row2=$result2->fetch_assoc();
            if($row2['status']==1){
              ?>
              <img src='/uploads/default.jpg' style="width:100%;">
              <h3><?php echo $cFullName;?><?php echo " "."(".$user.")"?></h3>
              <h4>Subject: <?php echo $cSubject;?></h4>
              <?php
            }else{
              $path="uploads/".$user.".profile*";
              $search=glob($path);
              $lastImage=$search[0];
              echo "<img src='$lastImage' style='width:100%;'>";
              ?>
              <h3><?php echo $cFullName;?><?php echo " "."(".$user.")"?></h3>
              <h4>       Subject: <?php echo $cSubject;?></h4>
              <?php
            }
              ?>
              
              <p style="white-space: pre-line;"><?php echo $cMessage;?></p>
              <span class="time-right"><?php echo $cSubmitTime;?></span>
              <?php
              if($_SESSION['user']=='ADMIN'){
                ?>
                <form id="replyForm" class="replyForm" action="contact.php" method="POSt">
                <input type="hidden" name="username" value="<?php echo $_SESSION['user'];?>">
                <input type="hidden" name="subject" value="<?php echo $cSubject;?>">
                <input type="hidden" name="to" value="<?php echo $user;?>">
                <input style="width: 50%" type="text" name="message">
                <input type="hidden" name="messageToBeSeen" value="<?php echo $cMessage ?>">
                <button style="background-color: inherit;border: 0px;color: #aaa; cursor: pointer;float: left;" type="submit" name="reply">Reply</button>
              </form>
              <?php
              }
              ?>
              
              
              <?php

        ?>

        </div>
        <?php
  }
}else{
  ?>
  <div style="display: block;margin: 15px; auto;text-align: center;">No Messages yet!</div>
  
  <?php
}

?>
</div>
</div>



</body>
</html>