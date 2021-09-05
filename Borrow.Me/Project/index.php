<?php 
//header the contains the navigation bar, Logo*, and the session already started there.
require 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="refresh" content="">
  <link rel="stylesheet" href="bootstrap.min.css">
  <script src="jquery.min.js"></script>
  <script src="bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="index.css">


  <script type="text/javascript">
    function showSearch(){
      var elem=document.getElementById('searchPage');
      if(elem.style.display==="block"){
        elem.style.display="none";
      }else{
        elem.style.display="block";
      }
    }

    setTimeout(function hidden() {
      var elem=document.getElementById('welcoming');
      elem.style.display="none";
    }, 5000);

    function fneighbors(){
      var elem=document.getElementById('neighbors');
      if(elem.style.display==='block'){
        elem.style.display='none';
      }else{
         elem.style.display='block';
      }
    }

    function foffer(){
      var elem=document.getElementById('offerForm-container');
      if(elem.style.top==='0px'){
        elem.style.top='-340px';
        //setTimeout(function a() {elem.style.display='none';}, 1000);
        
      }else if(elem.style.top='-340px'){
         
         //elem.style.display='block';
         setTimeout(function a() {elem.style.top='0px';}, 10);
      }
    }

  </script>
</head>
<body>





<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-2 sidenav upperNav">
    <?php 
      if(isset($_SESSION['user'])){
    ?>
  <!-- stating the profile chip -->
  <a id="profileChip" href="profile.php">
    <div class="chip">
    <?php
        require 'mydb.php';
        $user=$_SESSION['user'];
        $sqlStatus="SELECT status FROM imguploads WHERE user='$user'";
        $result=$conn->query($sqlStatus);
        $row=$result->fetch_assoc();
        if($row['status']==1){
          echo "<img alt='Person' width='96' height='96' src='/uploads/default.jpg'>";
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
                echo "<img title='$user' style='transform:rotate(-90deg)' alt='Person' width='96' height='96' src='$lastImage'>";

              }elseif($exif['Orientation']==6){
                $lastImage=$search[0];
                echo "<img title='$user' style='transform:rotate(90deg)' alt='Person' width='96' height='96' src='$lastImage'>";
 
              }elseif($exif['Orientation']==3){
                $lastImage=$search[0];
                echo "<img title='$user' style='transform:rotate(180deg)' alt='Person' width='96' height='96' src='$lastImage'>";

              }
            }else{
              //jpg, jpeg not rotated!
              $lastImage=$search[0];
              echo "<img title='$user' alt='Person' width='96' height='96' src='$lastImage'>";

            }
          }
          }else{
            //png
            $lastImage=$search[0];
            echo "<img title='$user' alt='Person' width='96' height='96' src='$lastImage'>";

          }
        }    
        ?>
    <span class="chipText"><?php echo $_SESSION['user']; ?></span>
    </div>
  </a>
  <!-- end of the profile chip -->
      <?php
        $user=$_SESSION['user'];
        $sqlStatus="SELECT status FROM users WHERE username='$user'";
        $result=$conn->query($sqlStatus);
        $row=$result->fetch_assoc();
        if($row['status']==0){
          ?>
          <p id="offerBTN" onclick="foffer()">Offer!</p>
          <?php
        }else{
          ?>
          <p id="offerBTN" onclick="alert('You are banned');">Offer!</p>
          <?php
        }
      ?>
    
        <?php
      if(isset($_GET['mess'])=='offerNow'){
        ?>
        <style type="text/css">
          #offerBTN{
            animation-name: toggleColor;
            animation-duration: 1.5s;
            animation-iteration-count: 5;
            
          }

          @keyframes toggleColor{
            to{color: red;}
            from{color: yellow;}
            font-weight: bold;
          }
        </style>
      <?php
      }
      ?>
      <p onclick="showSearch()" id="searchBTN">Search</p>
      <?php
      if($_SESSION['user']=='ADMIN'){
        $sql="SELECT * FROM contact where `to`='ADMIN' AND seen=0";
      }else{
        $user=$_SESSION['user'];
        $sql="SELECT * FROM contact where `to`='$user' AND seen=0";
      }
      $result=$conn->query($sql);
      if($result->num_rows>0){
        $notification=$result->num_rows;
      }
      ?>
    <a style="text-decoration: none;" href="notification.php">
      <p id="inboxBTN">Inbox
        <?php 
          if(isset($notification)){
        ?>
          <audio id="myAudio" autoplay>
          <!--  <source src="goes-without-saying.mp3" type="audio/ogg">-->
          </audio>

          <sup><span class="notify"><?php echo $notification;?></span></sup>
        <?php 
          } 
        ?>
      </p>
    </a>
      <?php
        if($_SESSION['user']==="ADMIN"){
          ?>
          <p id="neighborsBTN" onclick="fneighbors()">Users</p>
          <?php
        }else{
          ?>
          <p id="neighborsBTN" onclick="fneighbors()">Neighbors</p>
          <?php
        }
      ?>
    
  
  <div id="neighbors" style="height: 280px;">
  <?php
    $user=$_SESSION['user'];
    $sqlCity="SELECT city FROM users WHERE username='$user'";
    $resultCity=$conn->query($sqlCity);
    $rowCity=$resultCity->fetch_assoc();

    $city=$rowCity['city'];
    if($_SESSION['user']==="ADMIN"){
      $sql="SELECT username FROM users WHERE username!='$user'";
    }else{
      $sql="SELECT username FROM users WHERE city='$city' AND username!='$user'";
    }
    
    $result=$conn->query($sql);
    if($result->num_rows>0){
      while($row=$result->fetch_assoc()){
        
        ?>
          <a id="profileChip">
            <div class="chip">
            <?php
                
                $neighbor=$row['username'];
                $sqlNeighbor="SELECT status FROM imguploads WHERE user='$neighbor'";
                $resultNeighbor=$conn->query($sqlNeighbor);
                $rowNeighbor=$resultNeighbor->fetch_assoc();
                if($rowNeighbor['status']==1){
                  echo "<img alt='Person' width='96' height='96' src='/uploads/default.jpg'>";
                }elseif($rowNeighbor['status']==0){
                  $pathNeighbor="uploads/".$neighbor.".profile*";

                  $searchNeighbor=glob($pathNeighbor);
                  
                  
                  $extNeighbor=explode(".", $searchNeighbor[0]);
                  $actExtNeighbor=end($extNeighbor);
                  if($actExtNeighbor=='jpg' || $actExtNeighbor=='jpeg'){
                    if(isset($searchNeighbor[0])){
                    $exifNeighbor=read_exif_data($searchNeighbor[0]);
                    if(isset($exifNeighbor['Orientation'])){
                      //Edit the rotated iamges
                      if($exifNeighbor['Orientation']==8){
                        $lastImageNeighbor=$searchNeighbor[0];
                        echo "<img title='$neighbor' style='transform:rotate(-90deg)' alt='Person' width='96' height='96' src='$lastImageNeighbor'>";

                      }elseif($exifNeighbor['Orientation']==6){
                        $lastImageNeighbor=$searchNeighbor[0];
                        echo "<img title='$neighbor' style='transform:rotate(90deg)' alt='Person' width='96' height='96' src='$lastImageNeighbor'>";
         
                      }elseif($exifNeighbor['Orientation']==3){
                        $lastImageNeighbor=$searchNeighbor[0];
                        echo "<img title='$neighbor' style='transform:rotate(180deg)' alt='Person' width='96' height='96' src='$lastImageNeighbor'>";

                      }
                    }else{
                      //jpg, jpeg not rotated!
                      $lastImageNeighbor=$searchNeighbor[0];
                      echo "<img title='$neighbor' alt='Person' width='96' height='96' src='$lastImageNeighbor'>";

                    }
                  }
                  }else{
                    //png
                    $lastImageNeighbor=$searchNeighbor[0];
                    echo "<img title='$neighbor' alt='Person' width='96' height='96' src='$lastImageNeighbor'>";

                  }
                }    
                ?>
            <span class="chipText" ><?php echo $row['username']; ?></span>
            <form style="display: " action="publicProfile.php" method="POST">
              <input type="hidden" name="neighborName" value="<?php echo $row['username']; ?>">
              <button id="hiddenSubmit" style="" type="submit" name="submitNeighborName"></button>
            </form>
            </div>
          </a>        
        <?php
      }
    }else{
      echo "<p style='color:red;'>No Neighbors Yet!</p>";
    }
  ?>
  </div>
    <?php
      }else{
    ?>
            <p><a href='signup-form.php'>Sign Up</a></p>
    <?php
      }
    ?>
    </div>
    

    <div id="main" class="main col-sm-8 text-left">
    <?php
    
      if(isset($_SESSION['user'])){
    ?>  
    <div id="searchPage" class="searchPage" width="inherit" height="inherit"><?php require 'searchPage.php';?></div>
    <script type="text/javascript">
      document.getElementById("main").style.backgroundImage="none";
    </script>
    <div id="offerForm-container">
      <form id="offerForm" method="POST" action="offer.php" enctype="multipart/form-data">
        <input type="hidden" name="username" value="<?php echo $_SESSION['user']?>">
        <?php //get current user city
        $userName = $_SESSION['user'];
        $city = "SELECT city FROM users WHERE username = '$userName'";
        $query = mysqli_query($conn, $city);
        $userCity = mysqli_fetch_row($query);
         ?>
        <!-- Offer city -->
        <input type="hidden" id="offerCity" name="offerCity" value="<?php echo $userCity[0]; ?>">

        <input type="text" name="offerName" placeholder="<?php if(isset($_GET['nameIsTooLong'])){echo "Name is too long, make it shorter";}else{echo 'Offer Name:';}?>" required>
        
        <!-- offer options -->
        <div class="custom-control custom-radio custom-control-inline">
         <input id="gift_radio" type="radio" name="offerType" value="Gift" required>
          <label class="custom-control-label" for="gift_radio">Gift</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
         <input id="lending_radio" type="radio" name="offerType" value="For Lending" required>
          <label class="custom-control-label" for="lending_radio">For Lending</label>
        </div>
        <!-- End offer options -->
        <input type="hidden" name="offerStatus" value=0>
        <input type="file" name="file" required>
        <button id="submitOffer" type="submit" name="submitOffer">Offer</button>
      </form>
    </div>

    <?php
    if(isset($_GET['nameIsTooLong'])){
      echo "<script>alert('Your offer did not uploaded');</script>";
    }

    //here are all the offers by all users in same city
    
  echo "<div id='mainDivOffers'>";
      //here is the search field
    //When user searchs for an item
    if (isset($_GET['search'])) {
      $currentUser = $_SESSION['user'];
      //get search variable
      $itemSearch =$_GET['search'];
      //to get all offers except current user offers 
      //LIKE 'M%':find records stars with M
      //LIKE '%M':find records Ends with M
      //LIKE '%M%': find records contains M character


      $search = "SELECT * FROM offers WHERE user != '$currentUser' and offerName LIKE '%$itemSearch%'";
      $result = mysqli_query($conn,$search);//or you can use $conn->query($search);
      $fetch_data = mysqli_fetch_all($result,MYSQLI_ASSOC);
      // print_r($fetch_data);//for testing the output
      //in case of 0 results
      if (empty($fetch_data)) {
        echo "<div style='margin-top:10%'>
      <p id='noOffersYet' style='width: 100%; text-align: center; color: red; font-size: 14pt; --darkreader-inline-color:#ff3333;' data-darkreader-inline-color=''>Couldn't find any results matching your search!</p>
      </div>";
      }
      else{
        foreach ($fetch_data as $key => $item) { ?>
        <div id="favContainer">
          <div id="offers-container" class="well">
            <div id="offerImage-container">
              <img id="offerImage" src="<?php echo $item['offerImage']; ?>" alt="Offer Image">
            </div>
            <div id="text-container">
              <p id="offerName" class="text title"><?php echo $item['offerName'] ?></p>
              <form style="display: " action="publicProfile.php" method="POST">
                  <input type="hidden" name="neighborName" value="1">
                  <p id="offerOwner" class="text title">Offerd By <button id="hiddenSubmitFromProduct" style="" type="submit" name="submitNeighborName">1</button></p>
              </form>
              
              <p id="offerType" class="text title"><?php echo $item['offerType'] ?></p>
              <?php //check availability
                if($item['offerStatus']==1){
                  echo "<span class='status' id='requested'>Requested</span>";
                  }
                elseif($item['offerStatus']==0){
                    echo "<span class='status' id='available'>Available</span>";
                  } ?>
            </div>

            <form method="POST" action="message.php">
              <input type="hidden" name="reciever" value="<?php echo $item['user']; ?>">
              <input type="hidden" name="offerName" value="<?php echo $item['offerName'] ?>">
              <input type="hidden" name="offerType" value="<?php echo $item['offerType'] ?>">
              <button type="submit" id="requestOfferBTN" name="requestOfferBTN"><span>Request</span></button></form>

            
          </div>                      
            <form action="favourite.php" method="POST">
              <input type="hidden" name="userName" value="<?php echo $_SESSION['user'] ?>">
              <input type="hidden" name="favImage" value="<?php echo $item['offerImage']; ?>">
             <button type="submit" id="submitFav" class="submitFav" name="submitFav">Add to Favourite List</button>
                                        
            </form>
          </div>

          
        <?php }//end of foreach
      }//end of if

       echo "</div>";
    }
    //if user access the index.php directly
    else{
        $sqlCity="SELECT city FROM users WHERE username='$user'";
        $resultCity=$conn->query($sqlCity);
        if($resultCity->num_rows>0){
          $rowCity=$resultCity->fetch_assoc();
          $city=$rowCity['city']; //one result no need for while, select the city of the current user
        }
        if($_SESSION['user']==="ADMIN"){
          $sqlUser="SELECT username FROM users WHERE username!='$user'";
        }else{
          $sqlUser="SELECT username FROM users WHERE city='$city' AND username!='$user'";
        }
        
        $resultUser=$conn->query($sqlUser);
        if($resultUser->num_rows>0){
          while($rowUser=$resultUser->fetch_assoc()) { //loop for neighbors in same city
              $users=$rowUser['username'];

            $sql="SELECT * From offers WHERE user='$users'";
            $resultOffer=$conn->query($sql);
            if($resultOffer->num_rows>0){
              while ($rowOffer=$resultOffer->fetch_assoc()) { // loop to choose the offer of the neighbor selected from previous loop
                echo "<div id='favContainer'>
                      <div id='offers-container' class='well'>
                        <div id='offerImage-container'>
                          <img id='offerImage' src='".$rowOffer['offerImage']."' alt='Offer Image'>
                        </div>
                        <div id='text-container'>
                          <p id='offerName' class='text title'>".$rowOffer['offerName']."</p>";
                          ?>

                          <form style="display: " action="publicProfile.php" method="POST">
                            <input type="hidden" name="neighborName" value="<?php echo $rowOffer['user']; ?>">
                            <p id='offerOwner' class='text title'>Offerd By <button id="hiddenSubmitFromProduct" style="" type="submit" name="submitNeighborName"><?php echo $rowOffer['user']?></button></p>
                            
                          </form>
                          <?php
                          echo"
                          <p id='offerType' class='text title'>".$rowOffer['offerType']."</p>
                        ";
                        if($rowOffer['offerStatus']==1){
                              echo "<span class='status' id='requested'>Requested</span>";
                            }elseif($rowOffer['offerStatus']==0){
                              echo "<span class='status' id='available'>Available</span>";
                            }


                        echo "</div>
                        <form method='POST' action='message.php'>
                          <input type='hidden' name='reciever' value='".$rowOffer['user']."'>
                          <input type='hidden' name='offerName' value='".$rowOffer['offerName']."'>
                          <input type='hidden' name='offerType' value='".$rowOffer['offerType']."'>
                          ";
                                                      if($rowOffer['offerStatus']==1){
                            echo "<button style='opacity:100%;' type='' id='requestOfferBTN' name='' disabled><span>Request</span></button>";
                          }else{
                          echo "<button type='' id='requestOfferBTN' name='requestOfferBTN' ><span>Request</span></button>";
                           }
                        echo  "</form>
                      ";
                        
                      echo "</div>";
                      //here is the favorate button
                      ?>
                      <form action="favourite.php"  method="POST">
                        <input type="hidden" name="userName" value="<?php echo $_SESSION['user'];?>">
                        <input type="hidden" name="favImage" value="<?php echo $rowOffer['offerImage'];?>">
                        <?php
                          $user=$_SESSION['user'];
                          $favImage=$rowOffer['offerImage'];
                          $sql="SELECT * FROM favourite WHERE user='$user' AND favImage='$favImage'";
                          $result=$conn->query($sql);
                          if($result->num_rows==0){
                          ?>
                            <button type='submit' id='submitFav' class='submitFav' name='submitFav'>Add to Favourite List</button>
                          <?php
                          }else{
                          ?>
                            <button type='submit' id='removeFav' class='submitFav' name='removeFav'>Remove from Favourite List</button>
                          <?php
                          }
                        ?>
                        
                      </form>

                      <?php
                        if($_SESSION['user']==="ADMIN"){
                          ?>
                            <form method='POST' action='deleteOffer.php'>
                              <input type="hidden" name="offerImageFullName" value="<?php echo $rowOffer['offerImage'];  ?>">
                              <button type='submit' id='removeOfferBTN' name='removeOffersubmit'><span>Remove</span></button>
                            </form>
                          <?php
                        }
                      ?>
                      
                      
                      
                      <?php

                      
                    echo "</div>";
              }
            }else{
              
              
              
              
            }
          }
        }else{
            
            echo "<p style='width:100%;text-align:center;color:red;font-size:14pt;'>No Neighbors Yet!</p>";
            ?>
              <img class="backgroundIf" src="images/home.png">
            <?php
        }

          
          echo "</div>";
          //end of offers 
    }



    


      }else{

      //content if logged out...
      //........................
      if(isset($_GET['LoginFailed'])){
        if(!isset($_SESSION['user'])){
        echo "<p id='alert' class='alert'><b>Login Failed...</b><br>Wrong User Name or Password, try again."."</p>";
        }
      }
      ?>

      <h1 style="margin-left: 5px;">Welcome</h1>
      <p style="margin-left: 5px;font-size: 12pt;">Here is the website that you and your neighbors can now get benefit from each other!</p>
      <p style="margin-left: 5px;font-size: 12pt;">Sign up now to see what are the things that your nieghbors share.</p>
      <?php

      }
    

    


    
  ?>
</div>
  

      
    
    <div class="col-sm-2 sidenav lowerNav">
      <div class="well">
        <div class="mySlides fade">
          <p class="para" style="width:100%">SHARE</p>
        </div>

        <div class="mySlides fade">
          <p class="para" style="width:100%">BORROW</p>
        </div>

        <div class="mySlides fade">
          <p class="para" style="width:100%">GIVE A GIFT</p>
        </div>
      </div>



      <div style="padding: 0px;height: auto;width: 100%;" class="well">

        <div class="mySlides2 fade2">
          <img class="sliderImage" src="images/sewing machin.jpg" style="width:100%">
        </div>

        <div class="mySlides2 fade2">
          <img class="sliderImage" src="images/hot plate.jpg" style="width:100%">
        </div>

        <div class="mySlides2 fade2">
          <img class="sliderImage" src="images/Heat-Resistant-Safety-Gloves.jpg" style="width:100%">
        </div>

        <div class="mySlides2 fade2">
          <img class="sliderImage" src="images/ronhair_straightener_.jpg" style="width:100%">
        </div>

        <div class="mySlides2 fade2">
          <img class="sliderImage" src="images/tool-box.jpg" style="width:100%">
        </div>

        <div class="mySlides2 fade2">
          <img class="sliderImage" src="images/shovel_tool.jpg" style="width:100%">
        </div>

        <div class="mySlides2 fade2">
          <img class="sliderImage" src="images/welding  mask.jpg" style="width:100%">
        </div>

      </div>
      
    </div>
  </div>
</div>

<script>
var slideIndex2 = 0;
showSlides2();

function showSlides2() {
  var i;
  var slides2 = document.getElementsByClassName("mySlides2");
  for (i = 0; i < slides2.length; i++) {
    slides2[i].style.display = "none";  
  }
  slideIndex2++;
  if (slideIndex2 > slides2.length) {slideIndex2 = 1}    
  
  slides2[slideIndex2-1].style.display = "block";  
  setTimeout(showSlides2, 4500); // Change image every 2.5 seconds
}
</script>



<script>
var slideIndex = 0;
showSlides();

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  
  slides[slideIndex-1].style.display = "block";  
  setTimeout(showSlides, 3500); // Change text every 3.5 seconds
}
</script>


<?php
require 'footer.php';
?>

</body>
</html>