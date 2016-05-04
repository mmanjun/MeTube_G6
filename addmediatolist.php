<?php
session_start();
include_once "function.php";
$username=$_SESSION['username'];
$mediaid = $_GET['mediaid'];
$pid=$_GET['pid'];
if($pid!='none')
{
	$query="SELECT * from playlistmedia where mediaid ='$mediaid' and playlistid ='$pid'";
	
	$result=mysql_query($query);
	if(mysql_num_rows($result))
	{
		echo "Media Already Exists";
	}
	else
	{
		$query="INSERT into playlistmedia values('$pid','$mediaid')";
		mysql_query($query) or die("Add to Playlist");
		echo " Added to playlist";

	}
}
else
{
	echo "Select a playlist!";
}



?>