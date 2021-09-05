<?php  
if(isset($_POST['submitImage'])){
	$file=$_FILES['file'];
	
	$fileName=$file['name'];
	$fileType=$file['type'];
	$fileTmpTame=$file['tmp_name'];
	$fileError=$file['error'];
	$fileSize=$file['size'];

	

	$fileTypeLower=strtolower($fileType);
	$fileActualType=explode("/", $fileTypeLower);
	$fileActualNewType=$fileActualType[0]; //type
	
	$nameLower=strtolower($fileName);
	$fileExt=explode(".", $nameLower);
	$fileActualExt=end($fileExt);

	$allowed=array('jpg','png','jpeg');



	if($fileActualNewType=='image'){
		if($fileError==0){
			if(in_array($fileActualExt, $allowed)){
				if($fileSize<10000000){
					session_start();
					$fileNewName=$_SESSION['user'].".profile.".uniqid('',false).".".end($fileActualType);
					$fileDes="uploads/".$fileNewName;
					require 'mydb.php';
					$user=$_SESSION['user'];
					$sql5="UPDATE imguploads SET status=0 WHERE user='$user'";
					if($conn->query($sql5)===TRUE){
						move_uploaded_file($fileTmpTame, $fileDes);
						header("Location: profile.php?success=ImageUploaded.");
					}else{
						header("Location: profile.php?Error=UpdatingTheData!");
						exit();
					}
					
				}else{
					header("Location: profile.php?size=ImageSizeIsTooBig!");
					exit();
				}
			}else{
				header("Location: profile.php?type=Onlyjpg&pngAreAcceptable!");
				exit();
			}
		}else{
			header("Location: profile.php?Error2=ErrorUploadingTheImage!");
			exit();
		}
	}else{
		header("Location: profile.php?file=TheFileMustBeAnImageOnly!");
		exit();
	}

}else{
	header("Location: index.php?CannotAccessThisPageDirectly!");
	exit();
}




?>