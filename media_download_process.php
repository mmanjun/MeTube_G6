<?php
session_start();
include_once "function.php";

/******************************************************
*
* download by username
*
*******************************************************/

$userid=$_SESSION['userid'];
$mediaid = $_GET['mediaid'];

//insert into upload table
$insertDownload="insert into download(id,userid,mediaid) values(NULL,'$userid','$mediaid')";
echo $insertDownload;
$queryresult = mysql_query($insertDownload)
	
?>


