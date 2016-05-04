<?php 
session_start();
include_once "function.php";
$username=$_SESSION['username'];
$_SESSION['userid']=get_userid($username);
$userid=$_SESSION['userid'];
// echo "userid=".$_SESSION['userid']."<br>";
$mediaid = $_GET['mid'];
$rate = $_GET['rid'];


  $ratequery = "SELECT count(*) FROM mediarating  WHERE mediaid= $mediaid and userid='$userid'";

  $rateresult = mysql_query( $ratequery );
  $numberofresult = mysql_fetch_array($rateresult);
  
  
  
  
  
//   echo "#result = ".$numberofresult[0];
  if($numberofresult[0]==0)
  {

  	$ratequery = "INSERT INTO mediarating values(NULL,'$userid','$mediaid','$rate')";

  	mysql_query($ratequery);

  	$ratequery1 = "SELECT ROUND(AVG( rate ),1) AS score FROM  `mediarating` WHERE mediaid = $mediaid";
//   	echo "<br>".$ratequery1;
  	$rateresult1 = mysql_query($ratequery1);
  	$result_row=mysql_fetch_assoc($rateresult1);
//   	echo $result_row['score'];
  	echo "rating submitted : " .$result_row['score'];
  }

  else
  { 
// 	echo "<br>"."inside Else";
	$updatequery="UPDATE `mediarating` SET `rate`='$rate' WHERE mediaid= $mediaid and userid=$userid";
// 	echo "<br>".$ratequery;
	mysql_query($updatequery);
  	$ratequery1 = "SELECT ROUND(AVG( rate ),1) AS score FROM  `mediarating` WHERE mediaid = $mediaid";
//   	echo "<br> q1 =".$ratequery1;
  	$rateresult1 = mysql_query($ratequery1);
  	$result_row=mysql_fetch_assoc($rateresult1);
//    	echo $result_row['score'];
  	echo "already rated";
  }
?>