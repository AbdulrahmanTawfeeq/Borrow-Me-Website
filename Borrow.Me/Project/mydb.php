<?php 
$servername='localhost';
$username='root';
$password='';

$conn2=new mysqli($servername,$username,$password);
if(mysqli_connect_error()){
	die("Connection Failed: ".mysqli_connect_error());
}else{
	$sql="CREATE DATABASE my_database2";
	if($conn2->query($sql)===TRUE){
		echo "<script>alert('Database created successfully.');</script>";
	}elseif($conn2->error=="Can't create database 'my_database2'; database exists"){
	}else{
		echo "Error creating the database:".$conn2->error;
		
	}
}


$myDB='my_database2';
$conn=new mysqli($servername,$username,$password,$myDB);
if(mysqli_connect_error()){
	die("Connection Falied: ".mysqli_connect_error());
}else{
	$sql2="CREATE TABLE users(
		id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
		first VARCHAR (256) NOT NULL,
		last VARCHAR (256) NOT NULL,
		username VARCHAR (256) NOT NULL,
		email VARCHAR(256) NOT NULL,
		city VARCHAR(256),
		neighborhood VARCHAR(256),
		phone VARCHAR(256) NOT NULL,
		password VARCHAR (256) NOT NULL,
		status BOOLEAN NOT NULL

	)";

	if($conn->query($sql2)===TRUE){
		echo "<script>alert('Table created successfully.');</script>";
	}elseif($conn->error=="Table 'users' already exists"){

	}else{
		echo "Error creating the table: ".$conn->error;
	}

	$sql3="CREATE TABLE imguploads(
		id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		user VARCHAR(256) NOT NULL,
		status INT(11) NOT NULL
	)";

	if($conn->query($sql3)===TRUE){
		echo "<script>alert('Table created successfully.');</script>";
	}elseif($conn->error=="Table 'imguploads' already exists"){

	}else{
		echo "Error creating the table: ".$conn->error;
	}

	$sql4="CREATE TABLE offers(
		id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		user VARCHAR(256) NOT NULL,
		offerName VARCHAR(256) NOT NULL,
		offerType VARCHAR(256) NOT NULL,
		offerImage VARCHAR(256) NOT NULL,
		offerCity VARCHAR(256) NOT NULL,
		offerStatus INT(11) NOT NULL
	)";

	if($conn->query($sql4)===TRUE){
		echo "<script>alert('Table created successfully.');</script>";
	}elseif($conn->error=="Table 'offers' already exists"){

	}else{
		echo "Error creating the table: ".$conn->error;
	}

	$sql5="CREATE TABLE favourite(
		id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		user VARCHAR(256) NOT NULL,
		favImage VARCHAR(256)
	)";

	if($conn->query($sql5)===TRUE){
		echo "<script>alert('Table created successfully.');</script>";
	}elseif($conn->error=="Table 'favourite' already exists"){

	}else{
		echo "Error creating the table: ".$conn->error;
	}

	$sql6="CREATE TABLE IF NOT EXISTS `my_database2`.`contact` (
	  `cID` INT NOT NULL AUTO_INCREMENT,
	  `username` VARCHAR(45) NULL,
	  `cSubmitTime` TIMESTAMP NOT NULL,
	  `cFullName` VARCHAR(45) NULL,
	  `cSubject` VARCHAR(45) NULL,
	  `cMessage` VARCHAR(1000) NULL,
	  `to` VARCHAR(45) NULL,
	  `seen` boolean NOT NULL,
	  PRIMARY KEY (`cID`));
	";

	if($conn->query($sql6)===TRUE){
		//echo "<script>alert('Table created successfully.');</script>";
	}elseif($conn->error=="Table 'favourite' already exists"){

	}else{
		echo "Error creating the table: ".$conn->error;
	}


	}



	?>


