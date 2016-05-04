<?php
session_start();
include_once "function.php";
$userid=$_SESSION['username'];
$note=$_GET['note'];
$mediaid=$_GET['id'];
 ?>

<html lang="en">

       <?php
	
//	  $query = "select discussion from media where mediaid='$mediaid'";
//	  $result = mysql_query( $query ) or die("Insert into comments error in addcomment.php " .mysql_error());
//	  echo $query."<br>";
//	  $permit_discussion=mysql_fetch_array($result);
//	  if($permit_discussion[0])
//	  {
// 		    echo $permit_discussion[0];
	
		    $query = "INSERT INTO comments (`mediaid`,`username`,`note` ) values('$mediaid','$userid', '$note')";
		    echo $query ;
		    $result = mysql_query($query) or die("Insert into comments error in addcomment.php  " .mysql_error());


		    $query1 = "SELECT note FROM comments WHERE mediaid= '$mediaid'";
		      $result1 = mysql_query( $query1 ) or die("Insert into comments error in addcomment.php  " .mysql_error());


		   

//	  }
//	  else
//	  {
//	  echo "error";
//	  }
	    
  ?>

</html>