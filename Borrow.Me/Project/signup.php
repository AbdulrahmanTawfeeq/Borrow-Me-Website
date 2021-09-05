<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['submitSignup'])){
		require 'mydb.php';
		

		$first=$conn->real_escape_string($_POST['first']);
		$last=$conn->real_escape_string($_POST['last']);
		$username=$conn->real_escape_string($_POST['username']);
		$email=$conn->real_escape_string($_POST['email']);
		$city=$conn->real_escape_string($_POST['city']);
		$telephone=$conn->real_escape_string($_POST['telephone']);
		$password=$conn->real_escape_string($_POST['password']);
		$confirmPassword=$conn->real_escape_string($_POST['confirmPassword']);

		



		if(!preg_match("/^[a-zA-Z-]*$/", $first)&&!preg_match("/^[a-zA-Z-]*$/", $last)&&!preg_match("/^[ a-zA-Z0-9-]*$/", $username)){
			header("Location: signup-form.php?all=LettersOnly!&samefirst=$first&samelast=$last&sameusername=$username&sameemail=$email&samecity=$city&sameneighborhood=$neighborhood&sametelephone=$telephone");
			exit();
		}elseif(!preg_match("/^[a-zA-Z-]*$/", $first)&&!preg_match("/^[a-zA-Z-]*$/", $last)){
			header("Location: signup-form.php?first=LettersOnly!&last=LettersOnly!&samefirst=$first&samelast=$last&sameusername=$username&sameemail=$email&samecity=$city&sameneighborhood=$neighborhood&sametelephone=$telephone");
			exit();
		}elseif(!preg_match("/^[a-zA-Z-]*$/", $first)&&!preg_match("/^[ a-zA-Z0-9-]*$/", $username)){
			header("Location: signup-form.php?first=LettersOnly!&samefirst=$first&samelast=$last&sameusername=$username&sameemail=$email&samecity=$city&sameneighborhood=$neighborhood&sametelephone=$telephone");
			exit();
		}elseif(!preg_match("/^[a-zA-Z-]*$/", $last)&&!preg_match("/^[ a-zA-Z0-9-]*$/", $username)){
			header("Location: signup-form.php?last=LettersOnly!&samefirst=$first&samelast=$last&sameusername=$username&sameemail=$email&samecity=$city&sameneighborhood=$neighborhood&sametelephone=$telephone");
			exit();
		}elseif(!preg_match("/^[a-zA-Z-]*$/", $first)){
			header("Location: signup-form.php?first=LettersOnly!&samefirst=$first&samelast=$last&sameusername=$username&sameemail=$email&samecity=$city&sameneighborhood=$neighborhood&sametelephone=$telephone");
			exit();
		}elseif(!preg_match("/^[a-zA-Z-]*$/", $last)){
			header("Location: signup-form.php?last=LettersOnly!&samefirst=$first&samelast=$last&sameusername=$username&sameemail=$email&samecity=$city&sameneighborhood=$neighborhood&sametelephone=$telephone");
			exit();
		}elseif(!preg_match("/^[ a-zA-Z0-9-]*$/", $username)){
			header("Location: signup-form.php?username=LettersOnly!&samefirst=$first&samelast=$last&sameusername=$username&sameemail=$email&samecity=$city&sameneighborhood=$neighborhood&sametelephone=$telephone");
			exit();
		}elseif(preg_match("/^[ a-zA-Z0-9-]*$/", $username)){
			$sql0="SELECT username FROM users WHERE username=?"; //we can use an easer way by fetch them all then comparing them with $username.
			$stmt=$conn->prepare($sql0);
			$stmt->bind_param("s",$username);
			$stmt->execute();
			$stmt->bind_result($var);

					while($stmt->fetch()){
						$var;
						if($var==$username){
							header("Location: signup-form.php?used=ThisUserNameIsAlreadyTaken!&samefirst=$first&samelast=$last&sameusername=$username&sameemail=$email&samecity=$city&sameneighborhood=$neighborhood&sametelephone=$telephone");
							exit();
						}else{

						}
					}
			$stmt->close();
				
		}if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			header("Location: signup-form.php?email=InvalidEmail&samefirst=$first&samelast=$last&sameusername=$username&sameemail=$email&samecity=$city&sameneighborhood=$neighborhood&sametelephone=$telephone");
			exit();
		}elseif(!preg_match("/^[ 0-9]*$/", $telephone)){
			header("Location: signup-form.php?telephone=numbersOnly!&samefirst=$first&samelast=$last&sameusername=$username&sameemail=$email&samecity=$city&sameneighborhood=$neighborhood&sametelephone=$telephone");
			exit();
		}elseif($password!=$confirmPassword){
			header("Location: signup-form.php?password=NotMatched&confirmPassword=NotMatched&samefirst=$first&samelast=$last&sameusername=$username&sameemail=$email&samecity=$city&sameneighborhood=$neighborhood&sametelephone=$telephone");
			exit();
		}else{
			$passwordHashed=password_hash($password, PASSWORD_DEFAULT);


			$sql="INSERT INTO users (first,last,username,city,phone,email,password) VALUES (?,?,?,?,?,?,?)";
			$stmt=$conn->prepare($sql);
			if(!$stmt){
				header("Location: signup-form.php?fail=DataIsNotInserted!");
				exit();
			}else{
				$stmt->bind_param("sssssss",$first,$last,$username,$city,$telephone,$email,$passwordHashed);
				$stmt->execute();
				$stmt->close();

				$sql2="SELECT username FROM users WHERE username=?";
				$stmt2=$conn->prepare($sql2);
				if(!$stmt2){
					header("Location: signup-form.php?ErrorSelectingTheData!");
					exit();
				}else{
					$stmt2->bind_param("s",$username);
					$stmt2->execute();
					$stmt2->bind_result($var1);
					$stmt2->fetch();
					$var1;
					$conn3=new mysqli('localhost','root','','my_database2');
					if(mysqli_connect_error()){
						die("Connection2 failed: ".mysqli_connect_error());
					}else{
						$sql3="INSERT INTO imguploads (user,status) VALUES ('$var1',1)";
						if($conn3->query($sql3)===TRUE){
							//header("Location: signup-form.php?success=DataIsInsertedSuccessfully");
							?>
								<form action='login.php' method="POST">
									<input type="hidden" placeholder="Enter Username" name="username" value="<?php echo $username?>">
      								<input type="hidden" placeholder="Enter Password" name="password" value="<?php echo $password?>">
      								<button id="click" type="submit" name='submitLogin'></button>
								</form>

								<script type="text/javascript">
									function fclick(){
										document.getElementById('click').click();
									}
									fclick();
								</script>
							<?php
						}else{
							header("Location: signup-form.php?ErrorInserting2");
							exit();
					}
				}
					
				}
			}
		}
	}else{
		header("Location: signup-form.php?Error2=FillThesignup-formAndClickSubmitFirst!");
	}
}else{
	header("Location: signup-form.php?Error1=CannotAccessThisPageDirectly!");
}



?>
	
