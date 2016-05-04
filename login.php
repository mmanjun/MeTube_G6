<link rel="stylesheet" type="text/css" href="css/main.css" />
<?php
session_start();

include_once "function.php";

if(isset($_POST['submit'])) {
		if($_POST['username'] == "" || $_POST['password'] == "") {
			$login_error = "One or more fields are missing.";
		}
		else {
			$check = user_pass_check($_POST['username'],$_POST['password']); // Call functions from function.php
			if($check == 1) {
				$login_error = "User ".$_POST['username']." not found.";
			}
			elseif($check==2) {
				$login_error = "Incorrect password.";
			}
			else if($check==0){
				$_SESSION['username']=$_POST['username']; //Set the $_SESSION['username']
				header('Location: browse.php');
			}		
		}
}


 
?>
	<form method="post" action="<?php echo "login.php"; ?>">
        <div class= "container">
	 <div class= "login">
         <style>
	 body{  
		
		background-image: url("public_html/images/img1.jpg");

 		
	     }
        </style>
        <h1> Login </h1>
        <p>
	<table width="100%">
		<tr>
			<td  style="color : blue" width="20%" >Username:</td>
			<td   width="80%"><input class="text"  type="text" name="username"><br /></td>
		</tr>
		<tr>
		  <td  style="color : blue" width="20%">Password:</td>
		  <td width="80%"><input class="text"  type="password" name="password"><br /></td>
		</tr>
		<tr>
        <td><input name="submit" type="submit" value="Login">&nbsp;<input                     name="reset" type="reset" value="Reset"><br /></td></tr>

<tr><td>
<input type="checkbox" name="remember_me" id="remember_me">Remember me on this computer<br/></td></tr>
	</table>
</p>
	</div>
	</div>
	</form>

<?php
  if(isset($login_error))
   {  echo "<div id='passwd_result'>".$login_error."</div>";}
?>
