<html>
<body>

<?php
session_start();

include_once "function.php";

if(isset($_POST['submit'])) {
	if( $_POST['password1'] != $_POST['password2']) {
		$register_error = "Passwords don't match. Try again?";
	}
	else {
		$check = user_exist_check($_POST['username'], $_POST['password1'],$_POST['type'],$_POST['birthdate'],$_POST['fname'],$_POST['lname'],$_POST['email']);	
		if($check == 1){
			//echo "Registration succeeds";
			$_SESSION['username']=$_POST['username'];
			header('Location: browse.php');
		}
		else if($check == 2){
			$register_error = "Username already exists. Please user a different username.";
		}
	}
}


?>
<form action="register.php" method="post">
	Username: <input type="text" name="username"> <br>
	Create Password: <input  type="password" name="password1"> <br>
	Repeat password: <input type="password" name="password2"> <br>
	Account Type-Normal: <input type = "radio" name="type" value="Normal"> <br>
	Account Type-Premium: <input type = "radio" name="type" value="Premium"> <br>
	BirthDate: <input type="date" name="birthdate" value="birthdate"> <br>
	First Name: <input type="text" name="fname" > <br>
	Last Name: <input type="text" name="lname" > <br>
	Email: <input type="email" name="email"><br>


	<input name="submit" type="submit" value="Submit">
</form>

<?php
  if(isset($register_error))
   {  echo "<div id='passwd_result'> register_error:".$register_error."</div>";}
?>

</body>
</html>
