<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title></title>

  <style>

    /* Remove the navbar's default margin-bottom and rounded borders */ 
    

    #logo{
      transform: scaleY(1.2);
      font-weight: bold;
      transition: 0.5s ease-in;
    }

    #logoName{
      transform: scaleY(1.2);
      font-weight: bold;
      display: none;
      transition: 0.5s ease-in;
    }
    

    #logout{
    	background-color: inherit;
    	border: 0px;
    }

    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
       
    }
  </style>

  <script type="text/javascript">
    function fchange(){
      document.getElementById("logo").style.display="none";
      document.getElementById("logoName").style.display="block";
    }

    function freturn(){
      document.getElementById("logo").style.display="block";
      document.getElementById("logoName").style.display="none";
    }
  </script>
</head>
<header style="position: sticky;top: 0px;">
<nav class="navbar navbar-inverse"">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a onmouseover="fchange()" id="logo" class="navbar-brand" href="index.php">BM</a>
      <a onmouseout="freturn()" id="logoName" class="navbar-brand" href="index.php">Borrow Me</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <?php
        	if(isset($_SESSION['user'])){
        		echo "<li><a href='profile.php'>Profile</a></li>";
        	}
        ?>
        <li><a href="contact.php">Contact</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li>
        	<?php
        		if(!isset($_SESSION['user'])){
        			echo "<a href='login-form.php'><span class='glyphicon glyphicon-log-in'></span> Login</a>";
        		}else{
        			echo "<a><form method='POST' action='logout.php'><span class='glyphicon glyphicon-log-out'></span> <button id='logout' type='submit' name='submitLogout'>Logout</button></form></a>";
        		}
        	?>
          
        </li>
      </ul>
    </div>
  </div>
</nav>
</header>
</html>