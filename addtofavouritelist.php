<?php
session_start();
include_once "function.php";
$username=$_SESSION['username'];
$mediaid = $_GET['mediaid'];

	$query="SELECT * from favourite where mediaid ='$mediaid' and username ='$username'";
	$result=mysql_query($query);
	if(mysql_num_rows($result))
	{
// 	  header('Location:media.php?id='.$mediaid);
// 		header('Location:mymetube.php');
		echo "already added";
	}
	else
	{
		$query="INSERT into favourite values(NULL,'$mediaid','$username')";
		//echo $query;
		mysql_query($query) or die("cannot insert friend in group");
		echo "Added to Favorites";
// 		header('Location:mymetube.php');
// 		header('Location:media.php?id='.$mediaid);

	}




?>