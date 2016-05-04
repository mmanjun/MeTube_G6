<html>
<body>

<?php
session_start();

include_once "function.php";

if(isset($_POST['add_contact'])) {
	
		$check = contact_exist_check($_POST['email'], $_POST['fname'], $_POST['lname']);	
		if($check == 1){
			//echo "Contact add succeeds";
			$_SESSION['email']=$_POST['email'];
			header('Location: contacts.php');
		}
		else if($check == 2){
			$contact_add_error = "Username does not exist. Please user a different username.";
		}
	}


?>
<form action="contacts.php" method="post">
	Email: <input type="text" name="email"> <br>
	First Name: <input type="text" name="fname"> <br>
	Last Name: <input type="text" name="lname"> <br>


	<input name="Add Contact" type="submit" value="add_contact">
</form>

<?php
  if(isset($contact_add_error))
   {  echo "<div id='passwd_result'> contact_add_error:".$contact_add_error."</div>";}
?>

</body>
</html>
