<?php
session_start();
include_once "function.php";

$username=$_SESSION['username'];

$fuser = $_GET['username'];
echo $fuser;
$query = "SELECT * FROM user_contact WHERE username='$username' and fusername='$fuser' and status=2";
$result = mysql_query( $query );
$resultRows = mysql_num_rows($result);
echo $resultRows;

/**Friends**/
if($resultRows > 0 ){
	echo "Here";
	header('Location:viewFriendProfile.php?username='.$fuser);
	
}
else{
	echo "Here1";
	$query = "SELECT * FROM user_contact WHERE username='$username' and fusername='$fuser' and status=-1";
	$result = mysql_query( $query );
	$resultRows = mysql_num_rows($result);
	echo $resultRows;
	/**If friend Request is blocked**/
	if($resultRows >0){
		echo "Here2";
		header('Location:viewBlockedProfile.php?username='.$fuser);
	}
	else{
	
		//View all other profile
		header('Location:viewOtherProfile.php?username='.$fuser);
			
		
	}

}





 
 ?>