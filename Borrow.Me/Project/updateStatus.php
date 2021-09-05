<?php
if(isset($_POST['requestedsubmit'])){
      require 'mydb.php';
      $offerImage=$_POST['offerImage'];
      $status=$_POST['requested'];

      $sql="UPDATE offers SET offerStatus='$status' WHERE offerImage='$offerImage'";
      if($conn->query($sql)===TRUE){
      	header("Location: profile.php?statusUpdated=true");
      }else{
        header("Location: profile.php?Error");
        exit();
      }
}else{
	header("Location: index.php?Error");
    exit();
}
?>