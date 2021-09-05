<?php
if(isset($_POST['removeOffersubmit'])){
	$image=$_POST['offerImageFullName'];
	require 'mydb.php';
	$sql="DELETE FROM offers WHERE offerImage='$image'";
	if($conn->query($sql)===TRUE){
		$search=glob($image);
		unlink($search[0]);
		session_start();
		if($_SESSION['user']==="ADMIN"){
			header("Location: index.php");
		}else{
			header("Location: profile.php?offerDeleted=offerDeletedSuccessfully.");
		}
		
	}else{
		header("Location: index.php?ErrorRemovingTheOffer!");
		exit();
	}
}else{
	header("Location: index.php?CannotAccessItDirectly!");
	exit();
}


?>