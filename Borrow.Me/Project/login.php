<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['submitLogin'])){
		require 'mydb.php';

		$username=$conn->real_escape_string($_POST['username']);
		$password=$conn->real_escape_string($_POST['password']);

		$sql4="SELECT username,password FROM users WHERE username=? ";
		$stmt=$conn->prepare($sql4);
		if($stmt){
			$stmt->bind_param("s",$username);
			$stmt->execute();
			$stmt->bind_result($varUserName,$varPassword);
			while($stmt->fetch()){
				
				
				if($username==$varUserName&&password_verify($password, $varPassword)){
					session_start();
					$_SESSION['user']=$username;
					header("Location: index.php?Loggedin");
					exit();
				}
			}

			if($username!=$varUserName||password_verify($password, $varPassword)!=1){
				header("Location: index.php?LoginFailed");
				exit();	
			}
			
		}else{
			header("Location: index.php?LoginError");
			exit();	
		}

	}else{
		header("Location: index.php?Error4=LoginFirst!");
	}
}else{
	header("Location: index.php?Error3=CannotAccessThisPageDirectly!");
}

?>