<?php
session_start();
include_once "function.php";
$username=$_SESSION['username'];
$gid=$_GET['gid'];

$fname=$_GET['fname'];
if($fname!='none')
{
	$query="SELECT * from gmember where gid ='$gid' and username ='$fname'";
// 	echo $query;
	$result=mysql_query($query);
	if(mysql_num_rows($result) > 0)
	{
		echo "Member already added";
	}
	else
	{
		$query="INSERT into gmember (gid,username) values('$gid','$fname')";
		mysql_query($query) or die("cannot insert friend in group");
		echo get_name($fname)." added Successfully";

	}
}
else
{
	echo "Select member!";
}



?>