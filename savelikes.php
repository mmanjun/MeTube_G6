<?php
session_start();
include_once "function.php";
$mediaid=$_GET['mediaid'];



	$query="SELECT * from likes where mediaid ='$mediaid'";
	$result=mysql_query($query);
	
	if(mysql_num_rows($result) )
	{
		//echo "already added";
		$likequery = "SELECT likecount FROM likes WHERE mediaid='$mediaid'";
// 		echo $likequery."<br>";
		$likeresult = mysql_query( $likequery );
		
		$likescount = mysql_fetch_array($likeresult);
// 		$likescount[0] = $likescount[0] + 1 ;
		$tmp = $likescount['likecount'];
		$tmp += 1;
		$query="update likes set likecount = '$tmp' where mediaid ='$mediaid'";
// 		echo $query;
		mysql_query($query);
	}
	else
	{
		$query="INSERT into likes values('$mediaid',1)";
// 		echo $query;
		mysql_query($query) or die("cannot insert");
		

	}











	$likequery = "SELECT likecount FROM likes WHERE mediaid='$mediaid'";
	$likeresult = mysql_query( $likequery );
	$likes=mysql_fetch_array($likeresult);
	echo $likes[0];
//  	header('Location:mymetube.php');
?>