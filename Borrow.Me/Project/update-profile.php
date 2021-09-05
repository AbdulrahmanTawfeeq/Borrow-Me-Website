<?php
if(isset($_POST['submitUpdate'])){
	session_start();
	require 'mydb.php';
		
		$city1=$conn->real_escape_string($_POST['city']);
		$neighborhood1=$conn->real_escape_string($_POST['neighborhood']);
		$telephone1=$conn->real_escape_string($_POST['telephone']);

		function test($data){
			$data=htmlspecialchars($data);
			$data=stripslashes($data);
			$data=trim($data);
			return $data;
		}

		$city=test($city1);
		$neighborhood=test($neighborhood1);
		$telephone=test($telephone1);
		
		if(!preg_match("/^[ 0-9]*$/", $telephone)){
			header("Location: profile.php?telephone=numbersOnly!");
			exit();
		}else{
			$user=$_SESSION['user'];
			if(!empty($city)){
				$sql="UPDATE users SET city=? WHERE username='$user'";
				$stmt=$conn->prepare($sql);
				if(!$stmt){
					header("Location: profile.php?WentWrong!");
					exit();
				}else{
					$sqlNei="UPDATE users SET neighborhood='' WHERE username='$user'";
					if($conn->query($sqlNei)===TRUE){

					}else{
						echo "";
					}
					$stmt->bind_param("s",$city);
					$stmt->execute();
					$stmt->close();
				}
				
			}

			if(!empty($neighborhood)){
				$sql2="UPDATE users SET neighborhood=? WHERE username='$user'";
				$stmt2=$conn->prepare($sql2);
				if(!$stmt2){
					header("Location: profile.php?WentWrong!");
					exit();
				}else{
					$stmt2->bind_param("s",$neighborhood);
					$stmt2->execute();
					$stmt2->close();

				}
				
			}

			if(!empty($telephone)){
				$sql3="UPDATE users SET phone=? WHERE username='$user'";
				$stmt3=$conn->prepare($sql3);
				if(!$stmt3){
					header("Location: profile.php?WentWrong!");
					exit();
				}else{
					$stmt3->bind_param("s",$telephone);
					$stmt3->execute();
					$stmt3->close();				
				}
			}

			if(empty($neighborhood)&&empty($telephone)){
				header("Location: profile.php?mess=cityUpdatedSuccessfully");
			}elseif(!empty($neighborhood)&&empty($telephone)){
				header("Location: profile.php");
			}elseif(!empty($city)&&!empty($telephone)&&empty($neighborhood)){
				header("Location: profile.php?mess=cityAndTeleUpdatedSuccessfully");
			}elseif(empty($neighborhood)&&!empty($telephone)){
				header("Location: profile.php");
			}else{
				header("Location: profile.php");
			}
		}


}else{
	header("Location: index.php?CannotAccessThisPageDirectly!");
	exit();
}


?>