<?php 
echo '<header>';
    require 'header.php';
echo '</header>';
  if(isset($_POST['submitNeighborName'])){
    
    echo "<h2 style='text-align:center;'>Profile</h2>";

    echo "<div class='card'>";
        require 'mydb.php';
        $user=$_POST['neighborName'];
        $sqlStatus="SELECT status FROM imguploads WHERE user='$user'";
        $result=$conn->query($sqlStatus);
        $row=$result->fetch_assoc();
        if($row['status']==1){
          echo "<img style='border-radius:50%;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.9);' src='/uploads/default.jpg'>";
        }else{
          $path="uploads/".$user.".profile*";

          $search=glob($path);
          
          
          $ext=explode(".", $search[0]);
          $actExt=end($ext);
          if($actExt=='jpg' || $actExt=='jpeg'){
            if(isset($search[0])){
            $exif=read_exif_data($search[0]);
            if(isset($exif['Orientation'])){
              //Edit the rotated iamges
              if($exif['Orientation']==8){
                $lastImage=$search[0];
                echo "<img style='transform:rotate(-90deg);box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.9);' src='$lastImage'>";
                if(count($search)==2){
                  unlink($search[0]);
                }
              }elseif($exif['Orientation']==6){
                $lastImage=$search[0];
                echo "<img style='transform:rotate(90deg);box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.9);' src='$lastImage'>";
                if(count($search)==2){
                  unlink($search[0]);
                }
              }elseif($exif['Orientation']==3){
                $lastImage=$search[0];
                echo "<img style='transform:rotate(180deg);box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.9);' src='$lastImage'>";
                if(count($search)==2){
                  unlink($search[0]);
                }
              }
            }else{
              //jpg, jpeg not rotated!
              $lastImage=$search[0];
              echo "<img style='box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.9);' src='$lastImage'>";
              if(count($search)==2){
                  unlink($search[0]);
                }
            }
          }
          }else{
            //png
            $lastImage=$search[0];
            echo "<img style='box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.9);' src='$lastImage'>";
            if(count($search)==2){
                  unlink($search[0]);
                }
          }

            
          
          
        }


        echo "<h1 style='padding: 10px'>";
        if(isset($_POST['neighborName'])){echo $_POST['neighborName'];}
        $user=$_POST['neighborName'];
        echo "</h1>";

        $sqlInfo="SELECT username,city,neighborhood,email,phone,status FROM users WHERE username='$user'";
        $result=$conn->query($sqlInfo);
        $row=$result->fetch_assoc();
        

        if($row['city']){
        echo "
        <p class='title'>City: ".$row['city']."</p>";
        }

        if($row['neighborhood']){
        echo "
        <p class='title'>Neighborhood: ".$row['neighborhood']."</p>";
        }
        
        if($row['email']){
        echo "
        <p class='title'>Email: ".$row['email']."</p>";
        }
        
        if($row['phone']){
        echo "<p class='title'>Phone: ".$row['phone']."</p>";
        }
        
        echo "<div style='margin: 24px 0;'>
          <a class='sm' href='#'><i class='fa fa-dribbble'></i></a> 
          <a class='sm' href='#'><i class='fa fa-twitter'></i></a>  
          <a class='sm' href='#'><i class='fa fa-linkedin'></i></a>  
          <a class='sm' href='#'><i class='fa fa-facebook'></i></a> 
        </div>";
  
        if($_SESSION['user']==="ADMIN"){
          echo "
        <form id='delete-form' action='deleteProfile.php' method='POST'>
          <input type='hidden' name='username' value='$user'>
          <button title='Delete current profile image?' class='conbtn' type='submit' name='deleteImageByAdmin'>Delete Profile Image</button>
        </form>";

          if($row['status']==0){
            ?>
            <form action="ban.php" method="post">
              <input type="hidden" name="currentUser" value="<?php echo $row['username'];?>">
              <p><button type="submit" class="conbtn" name="ban">Ban</button></p>
            </form>
            <?php
          }elseif($row['status']==1){
            ?>
            <form action="ban.php" method="post">
              <input type="hidden" name="currentUser" value="<?php echo $row['username'];?>">
              <p><button type="submit" class="conbtn" name="unban">UnBan</button></p>
            </form>
            <?php
          }

          

        }

        
        echo "<a href='index.php'><p><button class='conbtn'>Back</button></p></a>
        ";

    
  

echo "</div>";

  }else{
     header("Location: index.php?CannotAccessItDirectly!");
  }
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap.min.css">
  <script src="jquery.min.js"></script>
  <script src="bootstrap.min.js"></script>
<style>
  header{
    z-index: 1;
    position: sticky;
  top: 0px;
  }

.navbar {
      margin: 0;
      border-radius: 0px;
        height: 52px;

}

.title {
  color: grey;
  font-size: 18px;
  padding-top: 10px;
}

.conbtn {

  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
  color: white;

}

.conbtn:hover {
  opacity: 90%;
}

.card {
  
  max-width: 300px;
  margin: auto;
  text-align: center;
  font-family: arial;
}





.sm {
   box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
   border-radius: 50%;
  text-decoration: none;
  font-size: 22px;
  color: black;
}



img{
  width: 150px;
  height: 150px;


}

        

        

       
        


/*editing style*/
body {font-family: Arial, Helvetica, sans-serif;}






</style>

      
</head>
<body>

<style type="text/css">
.offersbtn{
  background-color: #000;
  color: white;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100px;
  height: 25px;
  opacity: 0.9;
  box-sizing: border-box;
  font-size: 8pt;
  position: fixed;
  top:150px;
  color: white;
  left: -30px;
  transition: 0.4s ease-in;
  border-radius: 0 5px 5px 0;
  z-index: 0;
}

.offersbtn:hover{
  opacity: 0.8;
  left: 0px;
}
  #mainDivOffers{
    width: 500px ;
    display: none;
    margin: 30px auto 30px auto;
    padding: 0px;
    position: relative;
    display: none;
    background-color: ;
    transition: 0.55s ease-in;
    left:-950px;
    border-radius: 0px;
  }

  #offers-container{
    width: 500px ;
    display: block;
    margin: 30px auto 30px auto;
    height: 150px;
    padding: 0px;
    position: relative;
    overflow: hidden;
    border-radius: 0px;
  }

  #offerImage-container{
    width: 150px;
    height: inherit;
    border: 0px;
    float: left;
    box-sizing: border-box;
  }

  .text{
    display: flex;
    flex-direction: column;
    padding: 5px;
  }

  #requestOfferBTN{
    padding: 15px;
    position: absolute;
    right: 0px;
    top: 0;
    bottom: 0;
    background-color: #4daece;
    border: 0px;
    opacity: 90%;

  }

  #requestOfferBTN:hover{
    opacity: 100%;
    color: #333;
  }

  #requestOfferBTN span{
    font-size: 18px;
    writing-mode: vertical-lr;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 2px;
  }

  #offerName{
    font-size: 25pt;
    color: #111;
    margin: 5px;
    font-weight: bold;
    width: auto;
  }

  #offerOwner{
    margin: 5px;
    width: auto;
  }

  #offerType{
    margin: 5px;
    width: auto;
  }

  .status{
    position: absolute;
    bottom: 25px;
    right: 50px;
    color: green;
    text-transform: uppercase;
    font-weight: bold;
    font-style: italic;
    transform: rotate(-45deg);
  }

  #requested{
    color:red !important;
  }

  @media screen and (max-width: 767px) {
  .navbar {
        height: auto;
    }

  .offersbtn{
    left: 0px;
    position: absolute;
  }
  }

  @media only screen and (max-width: 500px) {
    
      


    #mainDivOffers{
    width: 100% ;
  }

    #offers-container{
      width: 100%;
      margin-left: 0px;
      margin-right: 0px;
  }

  #offerName{
    font-size: 25px;
    
  }

  #offerOwner{
  	font-size: 20px;
  }

  #offerType{
  	font-size: 20px;
  }
 }

  @media only screen and (max-width: 466px) {
  	#offerName{
    font-size: 20px;
  }

  #offerOwner{
  	font-size: 15px;
  }

  #offerType{
  	font-size: 15px;
  }
  }

  @media only screen and (max-width: 416px) {
  	#offerName{
    font-size: 15px;
  }

  #offerOwner{
  	font-size: 10px;
  }

  #offerType{
  	font-size: 10px;
  }

  }
</style>

<script type="text/javascript">
	function foffers(){
          var elem=document.getElementById('mainDivOffers');
          if(elem.style.display==='block'){
            setTimeout(function() {elem.style.display='none';}, 500);
            
            elem.style.left='-950px';
          }else{
            elem.style.display='block';
            setTimeout(function() {elem.style.left='0px';}, 1);
            
          }
        }
</script>


<a href="#mainDivOffers"><button onclick="foffers()" class="offersbtn">Neighbor's Offers</button></a>
<?php
echo "<div id='mainDivOffers'>";
if(isset($_POST['submitNeighborName'])){
$user=$_POST['neighborName'];
$sql="SELECT * From offers WHERE user='$user'";
$result=$conn->query($sql);
  if($result->num_rows>0){
    while ($row=$result->fetch_assoc()) {
      echo "<div id='offers-container' class='well'>
              <div id='offerImage-container'>
                <img id='offerImage' src='".$row['offerImage']."' alt='Offer Image'>
              </div>
              <p id='offerName' class='text title'>".$row['offerName']."</p>
              <p id='offerOwner' class='text title'>Offerd By ".$user."</p>
              <p id='offerType' class='text title'>".$row['offerType']."</p>
              <form method='POST' >
                <input type='hidden' name='' value='".$row['offerImage']."'>
                ";
                if($row['offerStatus']==1){
                	echo "<button style='opacity:100%;' type='' id='requestOfferBTN' name='' disabled><span>Request</span></button>";
            	}else{
            		echo "<button type='' id='requestOfferBTN' name='' ><span>Request</span></button>";
            	}
            echo  "</form>
            ";
              if($row['offerStatus']==1){
                echo "<span class='status' id='requested'>Requested</span>";
              }elseif($row['offerStatus']==0){
                echo "<span class='status' id='available'>Available</span>";
              }
            echo "</div>";
    }
  }else{
    echo "<p style='width:100%;text-align:center;color:red;font-size:14pt;'>No Offers Yet!</p>";
  }


}
echo "</div>";
?>



</body>
</html>
