<?php
if(isset($_POST['requestOfferBTN'])){
  require 'mydb.php';
  session_start();

  $sender=$_SESSION['user'];
  $reciever=$_POST['reciever'];
  $offerName=$_POST['offerName'];
  $offerType=$_POST['offerType'];

  

  $sql="SELECT email FROM users WHERE username='$reciever'";
  $result=$conn->query($sql);
  $row=$result->fetch_assoc();
  $emailReciever=$row['email'];

  $sql2="SELECT email FROM users WHERE username='$sender'";
  $result2=$conn->query($sql2);
  $row2=$result2->fetch_assoc();
  $emailSender=$row2['email'];

   

   ?>
<!DOCTYPE html>
<html>
<title></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link href='RobotoDraft.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="font-awesome.min.css"><style>
  #id01{
    display: block;
  }
</style>
<body>


  <!--<a href="javascript:void(0)" class="w3-bar-item w3-button w3-dark-grey w3-button w3-hover-black w3-left-align" onclick="document.getElementById('id01').style.display='block'">New Message</a>-->
  


<div id="id01" class="w3-modal" style="z-index:4">
  <div class="w3-modal-content w3-animate-zoom">
    <div class="w3-container w3-padding w3-red">
       <a href="index.php"><span onclick="document.getElementById('id01').style.display='none'"
       class="w3-button w3-red w3-right w3-xxlarge">X</span></a>
      <h2>Send Mail</h2>
    </div>
    <div class="w3-panel">
      <form method="POST" action="">
      <label>To</label>
      <input name="to" class="w3-input w3-border w3-margin-bottom" type="text" value="<?php echo $emailReciever;?>">
      <label>Subject</label>
      <input name="subject" class="w3-input w3-border w3-margin-bottom" type="text" value="Request!">
      <?php
      if($offerType=='For Lending'){
        ?>
        <textarea name='messText' class="w3-input w3-border w3-margin-bottom" style="min-height: 130px;" placeholder="What's on your mind?" >Hello <?php echo $reciever;?>, I hope you are doing well. I want to borrow the <?php echo $offerName ?> from you.</textarea>  
        <?php
      }else{
        ?>
        <textarea name='messText' class="w3-input w3-border w3-margin-bottom" style="min-height: 130px;" placeholder="What's on your mind?" >Hello <?php echo $reciever;?>, I hope you are doing well. I want to have the <?php echo $offerName ?> from you.</textarea>  
        <?php
      }
      ?>
      <button name="submitRequest" type="submit"  class="w3-button w3-light-grey w3-right" >Send</button>
      </form>
      <div class="w3-section">
        
         
        <a href="index.php" class="w3-button w3-red" onclick="document.getElementById('id01').style.display='none'">Cancel</a>
      </div> 
         
    </div>
  </div>
  
</div>





</body>
</html>
   <?php
   

}else{
  ?>

  
    <?php
  if(isset($_POST['submitRequest'])){
    $message=$_POST['messText'];
    $actualMes=str_replace(" ", "%20", $message);
    ?>
    <a id="mail" href='mailto:<?php echo $_POST['to'];?>?subject=<?php echo $_POST['subject'];?>&body=<?php echo $actualMes;?>' ></a>
    <a id="toIndex" href='index.php'></a>
    <script type="text/javascript">
      function f(){
        document.getElementById('mail').click();
      }
      f();

      setTimeout(function() {document.getElementById('toIndex').click();}, 10);
    </script>
    <?php
  }
  ?>
  <a href="index.php" class="w3-button w3-red" onclick="document.getElementById('id01').style.display='none'">BACK</a>
  <?php
}


?>


 

