<!DOCTYPE html>
<html>
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

/* Full-width input fields */
input[type=text], input[type=password], input[type=email], input[type=tel],select {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
  
}

/* Add a background color when the inputs get focus */
input[type=text]:focus, input[type=password]:focus,select:focus {
  background-color: #ddd;
  outline: none;
}


/* Set a style for all buttons */
button {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

button:hover {
  opacity:1;
}

/* Extra styles for the cancel button */
.cancelbtn {
  padding: 14px 20px;
  background-color: #f44336;
}

/* Float cancel and signup buttons and add an equal width */
.cancelbtn, .signupbtn {
  float: left;
  width: 50%;
}

/* Add padding to container elements */
.container {
  padding: 16px;
  position: relative;
  z-index: 0;
}

/* The Modal (background) */
.modal {
  display: block; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: #474e5d;
  padding-top: 50px;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 0% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 65%; /* Could be more or less, depending on screen size */
}

/* Style the horizontal ruler */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}
 
/* The Close Button (x) */
    .close {
      position: absolute;
      right: 35px;
      top: 15px;
      font-size: 40px;
      font-weight: bold;
      color: #f1f1f1;
    }

    .close:hover,.close:focus {
      color: #f44336;
      cursor: pointer;
    }

    /* Clear floats */
    .clearfix::after {
      content: "";
      clear: both;
      display: table;
    }

    .Errors{
      color: red;
      display: inline;
      font-weight: bold;
      position: absolute;
      right: 0px;
      z-index: 1;
      font-size: 10pt;
      padding: 8px;
      padding-right: 200px;
    }

    .success{
      color: green;
      display: inline;
      font-weight: bold;
      display: block;
      margin: 0 auto;
      transition: 2s ease-in;
    }

    .fail{
      color: red;
      display: inline;
      font-weight: bold;
      margin-right: 250.2px ;
      margin-left: 250.2px ;
    }
/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 850px) {
  .cancelbtn, .signupbtn {
     width: 100%;
  }

   .Errors{
      font-size: 8pt;
      padding: 11px;
      padding-right: 10px;
    }
}

@media screen and (max-width: 300px) {
   .Errors{
      font-size: 5pt;
    }
}
</style>
<body>
  <?php
    if(isset($_GET['Error1'])){
      echo "
        <script>alert('Cannot access this page directly! Sign up first.');</script>
      ";
    }
  ?>


<div id="id01" class="modal">
  <a href="login-form.php"><span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span></a>
  <form class="modal-content" action="signup.php" method="POST">
    <div class="container">
      <h1>Sign Up</h1>
      <p>Please fill in this form to create an account.</p>
        <?php if(isset($_GET['fail'])){echo "<p class='fail'>Ooops...Data is not inserted!</p>";}?>
        <?php 
        if(isset($_GET['success'])){
        echo "<p id='success' class='success'>Data inserted successfully.</p>";
        echo "<script>alert('You now are able to login.');</script>";
        }
        ?>
      <hr>
      <input type="text" name="first" placeholder="First Name:" value="<?php if(isset($_GET['samefirst'])){echo htmlspecialchars($_GET['samefirst']);}?>" required><?php if(isset($_GET['first'])){echo "<p class='Errors'>*Letters Only</p>";}?><?php if(isset($_GET['all'])){echo "<p class='Errors'>*Letters Only</p>";}?> 
      <input type="text" name="last" placeholder="Last Name:" value="<?php if(isset($_GET['samelast'])){echo htmlspecialchars($_GET['samelast']);}?>" required><?php if(isset($_GET['last'])){echo "<p class='Errors'>*Letters Only</p>";}?><?php if(isset($_GET['all'])){echo "<p class='Errors'>*Letters Only</p>";}?>
      <input type="text" name="username" placeholder="User Name:" value="<?php if(isset($_GET['sameusername'])){echo htmlspecialchars($_GET['sameusername']);}?>" required><?php if(isset($_GET['username'])){echo "<p class='Errors'>*Letters & numbers Only</p>";}?><?php if(isset($_GET['all'])){echo "<p class='Errors'>*Letters & numbers Only</p>";}?><?php if(isset($_GET['used'])){echo "<p class='Errors'>*This User Name is already taken!</p>";}?>
      <input type="email" name="email" placeholder="E-mail:" value="<?php if(isset($_GET['sameemail'])){echo htmlspecialchars($_GET['sameemail']);}?>" required><?php if(isset($_GET['email'])){echo "<p class='Errors'>*Invalid email</p>";}?>
      <select name="city" id="labelCity">
        <option value="Erbil">Erbil</option>
        <option value="Baghdad">Baghdad</option>
        <option value="Sulaimani">Sulaimani</option>
      </select>
      <input type="tel" name="telephone" placeholder="Phone Number:" pattern="[0-9]{11}" value="<?php if(isset($_GET['sametelephone'])){echo htmlspecialchars($_GET['sametelephone']);}?>"><?php if(isset($_GET['telephone'])){echo "<p class='Errors'>*numbers Only</p>";}?>
      <input type="password" name="password" placeholder="Password:" required><?php if(isset($_GET['password'])){echo "<p class='Errors'>*Passwords are not matched</p>";}?>
      <input type="password" name="confirmPassword" placeholder="Confirm Password:" required><?php if(isset($_GET['confirmPassword'])){echo "<p class='Errors'>*Passwords are not matched</p>";}?>
      
      <!--<label>
        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
      </label>-->


      <div class="clearfix">
        <a href="login-form.php"><button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button></a>
        <button type="submit" class="signupbtn" name="submitSignup">Sign Up</button>
      </div>
    </div>
  
  </form>
  
</div>



</body>
</html>