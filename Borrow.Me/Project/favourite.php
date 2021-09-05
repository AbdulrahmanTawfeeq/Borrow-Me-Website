<?php
if(isset($_POST['submitFav'])){
	require 'mydb.php';
	$userCurrent=$conn->real_escape_string($_POST['userName']);
	$favImage=$conn->real_escape_string($_POST['favImage']);
	$sql="INSERT INTO favourite (user,favImage) VALUES (?,?)";
	$stmt=$conn->prepare($sql);
	$stmt->bind_param("ss",$userCurrent,$favImage);
	$stmt->execute();
	$stmt->close();
	header("Location: index.php?favUpdatedSuccess1");
	
}elseif(isset($_POST['removeFav'])){
	require 'mydb.php';
	$favImage=$_POST['favImage'];
	$sql="DELETE FROM favourite WHERE favImage='$favImage'";
	if($conn->query($sql)===TRUE){
		header("Location: index.php?favDeletedSuccess2");
	}else{
		header("Location: index.php?mess=Error");
		exit();
	}
	
	
}elseif(isset($_POST['removeFavsubmit'])){
	require 'mydb.php';
	$favImage=$_POST['favImageFullName'];
	$sql="DELETE FROM favourite WHERE favImage='$favImage'";
	if($conn->query($sql)===TRUE){
		header("Location: profile.php?favDeleted=success3");
	}else{
		header("Location: profile.php?ErrorCon");
		exit();
	}
	
	
}else{
	header("Location: index.php");
	exit();
}





?>