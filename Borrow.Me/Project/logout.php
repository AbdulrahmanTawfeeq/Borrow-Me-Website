
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['submitLogout'])){
		session_start();
		if(isset($_SESSION['user'])){
			session_unset();
			session_destroy();
			header("Location: index.php?loggedOut");
			exit();	
		}else{
			header("Location: index.php?Error4=LoginFirst!");
			exit();	
		}


	}else{
		header("Location: login-form.php?Error4=LoginFirst!");
		exit();	
	}
}else{
	header("Location: login-form.php?Error3=CannotAccessThisPageDirectly!");
	exit();	
}

?>