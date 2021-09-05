<?php
if(isset($_POST['submitOffer'])){
	require 'mydb.php';
		
		$user=$conn->real_escape_string($_POST['username']);
		$offerName=$conn->real_escape_string($_POST['offerName']);
		$offerType=$conn->real_escape_string($_POST['offerType']);
		$offerCity=$conn->real_escape_string($_POST['offerCity']);
		$offerStatus=$conn->real_escape_string($_POST['offerStatus']);

		if(strlen($offerName)>16){
			header("Location: index.php?nameIsTooLong");
			exit();
		}

		

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
						$fileNewName=$user.".offer.".$offerName.".".uniqid('',false).".".end($fileActualType);
						$fileDes="offers images/".$fileNewName;
						move_uploaded_file($fileTmpTame, $fileDes);
						$offerImage=$conn->real_escape_string($fileDes);
						$sql="INSERT INTO offers (user,offerName,offerType,offerImage,offerCity,offerStatus) VALUES ('$user','$offerName','$offerType','$offerImage','$offerCity','$offerStatus')";
						$stmt=$conn->prepare($sql);
						if(!$stmt){
							header("Location: index.php?fail=DataIsNotInserted!");
							exit();
						}else{
							$stmt->bind_param("sssss",$user,$offerName,$offerType,$fileDes,$offerStatus);
							$stmt->execute();
							$stmt->close();
						}
						header("Location: index.php?success=thingOffered.");
						
					}else{
						header("Location: index.php?size=ImageSizeIsTooBig!");
						exit();
					}
				}else{
					header("Location: index.php?type=Onlyjpg&pngAreAcceptable!");
					exit();
				}
			}else{
				header("Location: index.php?Error2=ErrorUploadingTheImage!");
				exit();
			}
		}else{
			header("Location: index.php?file=TheFileMustBeAnImageOnly!");
			exit();
		}


}else{
	header("Location: index.php?CannotAccessItDirectly!");
	exit();
}
?>