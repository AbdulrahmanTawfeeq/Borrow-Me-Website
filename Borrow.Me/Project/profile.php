<?php 
echo '<haeder>';
    require 'header.php';
echo '</haeder>';
  if(isset($_SESSION['user'])){
    
    echo "<h2 style='text-align:center;'>Profile</h2>";

    echo "<div class='card'>";
        require 'mydb.php';
        $user=$_SESSION['user'];
        $sqlStatus="SELECT status FROM imguploads WHERE user='$user'";
        $result=$conn->query($sqlStatus);
        $row=$result->fetch_assoc();
        if($row['status']==1){
          echo "<img style='border-radius:50%;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.9);' src='/uploads/default.jpg'>";
        }else{
          $path="uploads/".$_SESSION['user'].".profile*";

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
        if(isset($_SESSION['user'])){echo $_SESSION['user'];}
        $user=$_SESSION['user'];
        echo "</h1>";

        $sqlInfo="SELECT city,neighborhood,email,phone,status FROM users WHERE username='$user'";
        $result=$conn->query($sqlInfo);
        $row=$result->fetch_assoc();
        

        if($row['city']){
        echo "
        <p class='title'>City: ".$row['city']."</p>";
        }

        if($row['neighborhood']==''){
          echo "<p id='note' style='position:absolute; top:50px;left:0px;'>Click on Edit Profile to add your neighborhood</p>";
          
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
    

        if($row['status']==0){
          echo "
        <a href='#close' ><p><button class='conbtn' onclick='show()'>Change Image</button></p></a>
        <div id='editImageCon'>
        <span onclick='hide()' id='close'>&times;</span>
        <form id='upload-form' action='uploads.php' method='POST' enctype='multipart/form-data'>
          <input id='subbtn'  type='file' name='file'>
          <button id='subbtn' type='submit' name='submitImage' onclick='hide()' >Upload</button>
        </form>
        <form id='delete-form' action='deleteProfile.php' method='POST'>
          <button title='Delete current profile image?' id='deletebtn' type='submit' name='deleteImage' onclick='hide()' >Delete</button>
        </form>
        </div>
      
        ";
        }else{
          echo "<span style='font-weight:bold;color:red'>You are banned!</span>";
        }
        


    if(isset($_GET['success'])){
      echo "<p id='successpara' style='color:green;display:inline-block'>Profile image updated. Refeah now!</p>";
    }elseif(isset($_GET['Error'])){
      echo "<p style='color:red;'>Something went wrong!!.</p>";
    }elseif(isset($_GET['size'])){
      echo "<p style='color:red;'>Image size is too big!!.</p>";
    }elseif(isset($_GET['type'])){
      echo "<p style='color:red;'>Only jpg & png are acceptable!!!.</p>";
    }elseif(isset($_GET['Error2'])){
      echo "<p style='color:red;'>Error Uploading The Image!!!.</p>";
    }elseif(isset($_GET['file'])){
      echo "<p style='color:red;'>The file must be an Image only!!.</p>";
    }
  

    echo "</div>";
echo "<br><br> <br>  ";
  }else{
     header("Location: login-form.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="refresh" content="">
  <link rel="stylesheet" href="bootstrap.min.css">
  <script src="jquery.min.js"></script>
  <script src="bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="profile.css">

      <script type="text/javascript">
       
        function show(){
          document.getElementById('editImageCon').style.display="inline-block";
          document.getElementById('upload-form').style.display="block";
          document.getElementById('delete-form').style.display="block";
          document.getElementById('close').style.display="block";
        }

        function hide(){
          document.getElementById('editImageCon').style.display="none";
          document.getElementById('upload-form').style.display="none";
          document.getElementById('close').style.display="none";
          document.getElementById('delete-form').style.display="none";
          
        }

        setTimeout(function() {document.getElementById('successpara').style.display="none";}, 3000);

        setTimeout(function note() {document.getElementById('note').style.left="-500px";}, 3000);

        function foffers(){
          var elem=document.getElementById('mainDivOffers');
          if(elem.style.display==='block'){
            setTimeout(function() {elem.style.display='none';}, 500);
            
            elem.style.left='-950px';
          }else{
            document.getElementById('mainDivFav').style.display="none";
            elem.style.display='block';
            setTimeout(function() {elem.style.left='0px';}, 1);
            
          }
        }

        function ffav(){
          var elem=document.getElementById('mainDivFav');
          if(elem.style.display==='block'){
            setTimeout(function() {elem.style.display='none';}, 500);
            
            elem.style.left='-950px';
          }else{
            document.getElementById('mainDivOffers').style.display="none";
            elem.style.display='block';
            setTimeout(function() {elem.style.left='0px';}, 1);
            
          }
        }


        
      </script>
</head>
<body>
  <?php 
  if($row['status']==0){
    ?>
      <button onclick="document.getElementById('id012').style.display='block'" id="editbtn" class="editbtn">Edit Profile</button>
    <?php
  }else{
    ?>
    <button onclick="alert('You are banned!');" id="editbtn" class="editbtn">Edit Profile</button>
    <?php
  }

  ?>
  
  <a id='offersbtnLink' href="#mainDivOffers"><button onclick="foffers()" id="offersbtn" class="offersbtn">Your Offers</button></a>
  <a href="index.php?mess=offerNow"><button id="OfferNewThing" class="OfferNewThing">Offer Now</button></a>
  <a id='favbtnLink' href="#mainDivFav"><button onclick="ffav()" id="favbtn" class="favbtn">Favourits</button></a>
<div id="id012" class="modal2">
  <span onclick="document.getElementById('id012').style.display='none'" class="close2" title="Close Modal">&times;</span>
  <form class="modal-content2" method="POST" action="update-profile.php">
    <div class="container2">
      <h1>Update Info.</h1>
      <hr>
      <label for="selectCity" id="labelCity">Update City then Neighborhood</label>
      <select id="selectCity" name="city">
        <option value="Erbil" <?php require_once 'mydb.php';$user=$_SESSION['user'];$sql="SELECT city,phone FROM users WHERE username='$user'";$result=$conn->query($sql);$row=$result->fetch_assoc();if($row['city']=='Erbil'){echo 'selected';} ?>>Erbil</option>
        <option value="Baghdad" <?php require_once 'mydb.php';$user=$_SESSION['user'];$sql="SELECT city,phone FROM users WHERE username='$user'";$result=$conn->query($sql);$row=$result->fetch_assoc();if($row['city']=='Baghdad'){echo 'selected';} ?>>Baghdad</option>
        <option value="Sulaimani" 
        <?php
           require_once 'mydb.php';$user=$_SESSION['user'];
           $sql="SELECT city,phone FROM users WHERE username='$user'";
           $result=$conn->query($sql);
           $row=$result->fetch_assoc();
           if($row['city']=='Sulaimani'){echo 'selected';
         } ?>>Sulaimani</option>
      </select>

      <?php
        if(isset($_GET['mess'])){
          require_once 'mydb.php';
          $user=$_SESSION['user'];
          $sql="SELECT city,phone FROM users WHERE username='$user'";
          $result=$conn->query($sql);
          $row=$result->fetch_assoc();
            if($row['city']=='Sulaimani'){
              echo "<style>#selectCity{display:none;} #labelCity{display:none;}</style>";
              echo "<label for='selectNeighborhood' id='labelNeighborhood'>Update Neighborhood:</label> 
                    <select id='selectNeighborhood' name='neighborhood'>
                      <option value='Sarchinar'>Sarchinar</option>
                      <option value='Qaiwan City'>Qaiwan City</option>
                      <option value='Chwarbakh'>Chwarbakh</option>
                      <option value='Bakrajo'>Bakrajo</option>
                      <option value='Bakhtiari'>Bakhtiari</option>
                      <option value='Hawarabarza'>Hawarabarza</option>
                      <option value='Baxan'>Baxan</option>
                      <option value='Wuluba'>Wuluba</option>
                      <option value='Raparin'>Raparin</option>
                      <option value='Shorish'>Shorish</option>
                      <option value='Kullarasi'>Kullarasi</option>
                      <option value='Kani Soikah'>Kani Soikah</option>
                      <option value='Silemani Nwe'>Silemani Nwe</option>
                      <option value='Zerin'>Zerin</option>
                      <option value='Deya City'>Deya City</option>
                      <option value='Qalat Kin'>Qalat Kin</option>
                      <option value='Goizhay Nwe'>Goizhay Nwe</option>
                      <option value='Baba Murda'>Baba Murda</option>
                      <option value='Qazi Mohammed'>Qazi Mohammed</option>
                      <option value='Sulaymaniyah Governorate'>Sulaymaniyah Governorate</option>
                    </select>";
            }elseif($row['city']=='Erbil'){
              echo "<style>#selectCity{display:none;} #labelCity{display:none;}</style>";
              echo "<label for='selectNeighborhood' id='labelNeighborhood'>Update Neighborhood:</label> 
                    <select id='selectNeighborhood' name='neighborhood'>
                      <option value='Kurdistan'>Kurdistan</option>
                      <option value='Ankawa'>Ankawa</option>
                      <option value='Qalat'>Qalat</option>
                      <option value='Karezan'>Karezan</option>
                      <option value='Eskan'>Eskan</option>
                      <option value='Salaheddin'>Salaheddin</option>
                      <option value='Arab'>Arab</option>
                      <option value='Dream City'>Dream City</option>
                      <option value='Nishtiman'>Nishtiman</option>
                      <option value='Zaniary'>Zaniary</option>
                      <option value='Pizishkan'>Pizishkan</option>
                      <option value='Brayaty'>Brayaty</option>
                      <option value='Havalan'>Havalan</option>
                      <option value='Khabat'>Khabat</option>
                      <option value='Zanayan'>Zanayan</option>
                      <option value='Khanzad'>Khanzad</option>
                      <option value='Kwestan'>Kwestan</option>             
                      <option value='Runaky'>Runaky</option>
                      <option value='Chwar Chira'>Chwar Chira</option>
                      <option value='Zanko 1'>Zanko 1</option>
                      <option value='Raparin'>Raparin</option>
                      <option value='Nawroz'>Nawroz</option>
                      <option value='Sharawani'>Sharawani</option>
                      <option value='Tayrawa'>Tayrawa</option>
                      <option value='Tairawa'>Tairawa</option>
                      <option value='Badawa'>Badawa</option>
                      <option value='Sarwaran'>Sarwaran</option>
                      <option value='Iskan'>Iskan</option>
                      <option value='Setaqan'>Setaqan</option>
                      <option value='Zanko 2'>Zanko 2</option>
                      <option value='Azadi'>Azadi</option>
                      <option value='Zeelan City'>Zeelan City</option>
                      <option value='Majidawa'>Majidawa</option>
                      <option value='Zagros'>Zagros</option>
                      <option value='Mufti'>Mufti</option>
                      <option value='Mantikawa'>Mantikawa</option>
                      <option value='Bahar'>Bahar</option>
                      <option value='South Cemetery'>South Cemetery</option>
                      <option value='Mahabad'>Mahabad</option>
                      <option value='Azadi 2'>Azadi 2</option>
                      <option value='Rasty'>Rasty</option>
                      <option value='Khanaqa Qr.'>Khanaqa Qr.</option>
                      <option value='Araban'>Araban</option>
                      <option value='Shorsh'>Shorsh</option>
                      <option value='Razgari 1'>Razgari 1</option>
                      <option value='Minara 1'>Minara 1</option>
                      <option value='Mamostiyan 2'>Mamostiyan 2</option>
                      <option value='Kuran Ankawa'>Kuran Ankawa</option>
                      <option value='Minaret'>Minaret</option>
                      <option value='11 Athar'>11 Athar</option>
                      <option value='Saidawa'>Saidawa</option>
                    </select>";
            }elseif ($row['city']=='Baghdad') {
              echo "<style>#selectCity{display:none;} #labelCity{display:none;}</style>";
              echo "<label for='selectNeighborhood' id='labelNeighborhood'>Update Neighborhood:</label> 
                    <select id='selectNeighborhood' name='neighborhood'>
                     <option value='Green Zone'>Green Zone</option>
                     <option value='Karkh'>Karkh</option>
                     <option value='Karada'>Karada</option>
                     <option value='Al Jamaa'>Al Jamaa</option>
                     <option value='Shaab South'>Shaab South</option>
                     <option value='Bab Al Sharqi'>Bab Al Sharqi</option>
                     <option value='Al Baladiyat'>Al Baladiyat</option>
                     <option value='Al Shuala'>Al Shuala</option>
                     <option value='Washash'>Washash</option>
                     <option value='Abu Disher'>Abu Disher</option>
                     <option value='Suleikh'>Suleikh</option>
                     <option value='Drage'>Drage</option>
                     <option value='Saba Abkar'>Saba Abkar</option>
                     <option value='Al Shalchiya'>Al Shalchiya</option>
                     <option value='Al Alam'>Al Alam</option>
                     <option value='Arab Ejbur'>Arab Ejbur</option>
                     <option value='Orfali'>Orfali</option>
                     <option value='Turath'>Turath</option>
                     <option value='Tal Muhammad'>Tal Muhammad</option>
                     <option value='Shwaka'>Shwaka</option>
                     <option value='Um Al-Kuber Wa Al-Gazlan'>Um Al-Kuber Wa Al-Gazlan</option>
                     <option value='Baijai'>Baijai</option>
                     <option value='Al Shurtah 4th'>Al Shurtah 4th</option>
                     <option value='Area 601'>Area 601</option>
                     <option value='Al Shurtah 5th'>Al Shurtah 5th</option>
                     <option value='Sumer'>Sumer</option>
                     <option value='Shuhada Al Sydia'>Shuhada Al Sydia</option>
                     <option value='Hurriya Second'>Hurriya Second</option>
                     <option value='Khair Allah'>Khair Allah</option>
                     <option value='Huriya First'>Huriya First</option>
                     <option value='Al Mailhania'>Al Mailhania</option>
                     <option value='Al Salhiah'>Al Salhiah</option>                    
                    </select>";
            }
        }
      ?>  

      <input type="tel" placeholder="Phone Number:" pattern="[0-9]{11}" name="telephone" value="<?php if(isset($_GET['sametelephone'])){echo htmlspecialchars($_GET['sametelephone']);};
        //get the current phone number from the database
        echo $row['phone'];
       ?>"><?php if(isset($_GET['telephone'])){echo "<p class='Errors'>*numbers Only</p>";}?>
     
      <div class="clearfix2">
        <button type="button" onclick="document.getElementById('id012').style.display='none'" class="cancelbtn2">Cancel</button>
        <button type="submit" name="submitUpdate" class="signupbtn2">Update</button>
      </div>
    </div>
  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id012');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}


</script>

<!--Offers are here-->

<?php
echo "<div id='mainDivOffers'>";
if(isset($_SESSION['user'])){
$username=$_SESSION['user'];
$sql="SELECT * From offers WHERE user='$username'";
$result=$conn->query($sql);
  if($result->num_rows>0){
    echo "<h2 style='text-align:center;'>Your Offers</h2>";
    echo "<hr/>";
    while ($row=$result->fetch_assoc()) {
      echo "<div id='offers-container-cover'>";
        echo "<div id='offers-container' class='well'>
              <div id='offerImage-container'>
                <img id='offerImage' src='".$row['offerImage']."' alt='Offer Image'>
              </div>
              <p id='offerName' class='text title'>".$row['offerName']."</p>
              <p id='offerOwner' class='text title'>Offerd By You</p>
              <p id='offerType' class='text title'>".$row['offerType']."</p>
              
              <form method='POST' action='deleteOffer.php'>
                <input type='hidden' name='offerImageFullName' value='".$row['offerImage']."'>
                <button type='submit' id='removeOfferBTN' name='removeOffersubmit'><span>Remove</span></button>
              </form>
              ";
              if($row['offerStatus']==1){
                echo "<span class='status' id='requested'>Requested</span>";
              }else{
                echo "<span class='status' id='available'>Available</span>";
              }
        echo "</div>";
        echo "<form id='requestedForm' method='POST' action='updateStatus.php'>
              Requested?
                <input type='radio' name='requested' value='1'>YES
                <input type='radio' name='requested' value='0'>NO
                <input type='hidden' name='offerImage' value='".$row['offerImage']."'>
                <button style='border:0px;' type='submit' id='requestedBTN' name='requestedsubmit'><span>Apply</span></button>
              </form>";
      echo "</div>";      

    }

if(isset($_GET['statusUpdated'])){
    ?>
    <script type="text/javascript">
      foffers();
    </script>
    <?php
}

  }else{
echo "<p style='width:100%;text-align:center;color:red;font-size:14pt;'>No Offers Yet!</p>";  }


}
echo "</div>";
echo"<a href='#mainDivOffers' id='place'></a>";
if(isset($_GET['statusUpdated'])){
  ?>
  
  <script type="text/javascript">
    function ff(){
          var elem=document.getElementById('mainDivOffers');
            elem.style.display='block';
            setTimeout(function() {elem.style.left='0px';}, 0);
            document.getElementById('place').click();
          }
    ff();
  </script>
  <?php
}

if(isset($_GET['mess'])=='cityUpdatedSuccessfully' || isset($_GET['mess'])=='cityAndTeleUpdatedSuccessfully
'){
  ?>
  <script type="text/javascript">
    function f2(){
      document.getElementById('editbtn').click();
    }
    f2();
  </script>
  <?php
}

if(isset($_GET['success'])=='ImageUploaded.'){
  ?>
  <a href='profile.php' id="profilePage"></a>
  <script type="text/javascript">
    function f3(){
      document.getElementById('profilePage').click();
    }
    f3();
  </script>
  <?php
}
?>


<?php
echo "<div id='mainDivFav'>";
if(isset($_SESSION['user'])){
$username=$_SESSION['user'];
$sql="SELECT favImage From favourite WHERE user='$username'";
$resultFav=$conn->query($sql);
  if($resultFav->num_rows>0){
        echo "<h2 style='text-align:center;'>Your Favourite List</h2>";
        echo "<hr/>";
    while($rowfav=$resultFav->fetch_assoc()){
      $fav=$rowfav['favImage'];
      $sql2="SELECT * FROM offers WHERE offerImage='$fav'";
      $resultNow=$conn->query($sql2);
      if($resultNow->num_rows>0){

        while($rowNow=$resultNow->fetch_assoc()){
          echo "<div id='fav-container-cover'>";
        echo "<div id='fav-container' class='well'>
              <div id='favImage-container'>
                <img id='favImage' src='".$rowNow['offerImage']."' alt='Offer Image'>
              </div>
              <p id='favName' class='text title'>".$rowNow['offerName']."</p>";
              ?>
                    <form style="display: " action="publicProfile.php" method="POST">
                      <input type="hidden" name="neighborName" value="<?php echo $rowNow['user']; ?>">
                      <p id='FavOwner' class=' title'> Offerd By <button id="hiddenSubmitFromProduct" style="" type="submit" name="submitNeighborName"><?php echo $rowNow['user']?></button></p>
                    </form>
              <?php
              echo "<p id='favType' class='text title'>".$rowNow['offerType']."</p>
              
              <form method='POST' action='favourite.php'>
                <input type='hidden' name='favImageFullName' value='".$rowNow['offerImage']."'>
                <button type='submit' id='removeFavBTN' name='removeFavsubmit'><span>Unfavourite</span></button>
              </form>
              ";
                  if($rowNow['offerStatus']==1){
                    echo "<span class='status' id='requested2'>Requested</span>";
                  }elseif($rowNow['offerStatus']==0){
                    echo "<span class='status' id='available2'>Available</span>";
                  }
               
        }
        echo "</div>";
        echo "</div>";
      }
    
    
   



  }
}else{
  echo "<p style='width:100%;text-align:center;color:red;font-size:14pt;'>No Favourits Yet</p>";
}
}
echo "</div>";

if(isset($_GET['favDeleted'])){
  ?>
  <script type="text/javascript">
    function f(){
      document.getElementById('favbtn').click();
    }
    f();
  </script>
  <?php
}?>
</body>
</html>
