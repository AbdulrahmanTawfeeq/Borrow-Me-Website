<?php
  require 'header.php';
  require 'mydb.php';
  if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    //get all current user info
    $sql = "SELECT * FROM users WHERE username = '$user'";
    $query = mysqli_query($conn, $sql);
    $fetch = mysqli_fetch_array($query);
    // print_r($fetch);

  }
  //when the message have been sent
  if (isset($_POST['submit']) || isset($_POST['reply'])) {
    $user=$_SESSION['user'];
    $cFullName = $_POST['fullname'];
    $cSubject = $_POST['subject'];
    $cMessage = $_POST['message'];
    $to='ADMIN';
    $toReply=$_POST['to'];
    $message = "INSERT INTO contact(username,cFullName, cSubject,cMessage,`to`) VALUES(?,?,?,?,?)";
    $query=$conn->prepare($message);
      if(!$query){
        if(isset($_POST['submit'])){
          header("Location: contact.php?status=0");
          exit();
        }elseif (isset($_POST['reply'])) {
          header("Location: notification.php?status=0");
          exit();
        }
        
      }else{
        if(isset($_POST['submit'])){
          $query->bind_param("sssss",$user,$cFullName,$cSubject,$cMessage,$to);
        }elseif (isset($_POST['reply'])) {
          $query->bind_param("sssss",$user,$cFullName,$cSubject,$cMessage,$toReply);
          $messageToBeSeen=$_POST['messageToBeSeen'];
        }
        
        $query->execute();
        $query->close();
        if(isset($_POST['submit'])){
          header("Location: contact.php?status=1");
        }elseif (isset($_POST['reply'])) {

          $sqlSeen="UPDATE contact SET seen=1 WHERE cMessage='$messageToBeSeen' AND username='$toReply'";
          if($conn->query($sqlSeen)===TRUE){
            header("Location: notification.php?status=1");
          }
          
        }
        
      }
  }
  //when message have been sent
  if (isset($_GET['status'])) {
    if ($_GET['status'] == 1) {
      $msgState = "Message Have been sent!";
      $alert = "success";
    }
    else if($_GET['status'] == 0){
      $msgState = "Message Have not been sent!";
      $alert = "danger";
    }
    

   
  }
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8">
  <link rel="stylesheet" href="bootstrap.min.css">
  <script src="jquery.min.js"></script>
  <script src="bootstrap.min.js"></script>
<style>


.navbar {
  margin: 0;
  border-radius: 0px;
      
}

body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
}

input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
  width:65%;
 
}

h3{
  text-align: center;

}
</style>
</head>
<body>



<div class="container">
  
  <?php
    ?>
      <h3>Contact Us</h3>
  <center>
    <?php if (isset($_GET['status'])) { ?>
      <div id="msgStatus" class="alert alert-<?php echo $alert; ?>">
        <span><?php echo $msgState; ?></span>
      </div>
    <?php } ?>
  </center>
  
  <form action="contact.php" method="POST">
    <label for="fullname">Full Name</label>
    <input required type="text" id="fullname" name="fullname" placeholder="Your name.." value="<?php 
    // set full user name
    if(isset($fetch) and !empty($fetch['first'])){
      echo $fetch['first']." ".$fetch['last'];
    }

    ?>">

    <label for="subject">Subject</label>
    <input required type="text" id="subject" name="subject" placeholder="Subject" value="">

    <label for="message">Message</label>
    <textarea required id="message" name="message" placeholder="Write something.." style="height:100px"></textarea>

    <input type="submit" name="submit" value="Submit">
  </form>
</div>
<?php

  ?>


</body>
</html>