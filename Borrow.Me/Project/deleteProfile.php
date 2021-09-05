<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
	session_start();
	if(isset($_POST['deleteImage'])){
		
		$path="uploads/".$_SESSION['user'].".profile.*";
		$search=glob($path);
		if(count($search)<1){
			header("Location: profile.php?Empty=NoProfileImageToDelete!!");
			exit();
		}else{
			unlink($search[0]);
			$connDelete=new mysqli('localhost','root','','my_database2');
			if(mysqli_connect_error()){
				die("Connection Failed: ".mysqli_connect_error());
				header("Location: profile.php?DeleteFailed=somethingWentWrong!!");
				exit();
			}else{
				$username=$_SESSION['user'];
				$sqlDeleteProfile="UPDATE imguploads SET status=1 WHERE user='$username'";
				if($connDelete->query($sqlDeleteProfile)===TRUE){
				header("Location: profile.php?Deleted=ImageDeletedSuccessfully!!");
				}else{
					header("Location: profile.php?DeleteFailed=somethingWentWrong!!");
					exit();
				}
			}
			
			
		}
	}elseif(isset($_POST['deleteImageByAdmin'])){
		$user=$_POST['username'];
		$path="uploads/".$user.".profile.*";
		$search=glob($path);
		if(count($search)<1){
			header("Location: index.php?Empty=NoProfileImageToDelete!!");
			exit();
		}else{
			unlink($search[0]);
			$connDelete=new mysqli('localhost','root','','my_database2');
			if(mysqli_connect_error()){
				die("Connection Failed: ".mysqli_connect_error());
				header("Location: profile.php?DeleteFailed=somethingWentWrong!!");
				exit();
			}else{
				$user=$_POST['username'];
				$sqlDeleteProfile="UPDATE imguploads SET status=1 WHERE user='$user'";
				if($connDelete->query($sqlDeleteProfile)===TRUE){
				header("Location: index.php?Deleted=ImageDeletedSuccessfully!!");
				}else{
					header("Location: index.php?DeleteFailed=somethingWentWrong!!");
					exit();
				}
			}
			
			
		}
	}else{
		header("Location: profile.php?CannotAccessThePageDirectly!!");
		exit();
	}
}else{
	header("Location: profile.php");
	exit();
}




?>