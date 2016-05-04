<?php 
session_start();
include_once "function.php";
$username=$_SESSION['username'];
$userid=$_SESSION['userid'];

$co_username = $_GET['co_username'];
$sub_username = $_GET['sub_username'];

if ($co_username == $sub_username)
{

      echo "own channel";
}


else
{
      $query = "SELECT * FROM subscribe  WHERE co_username = '$co_username' and sub_username= '$sub_username'";
      $result = mysql_query( $query );
      if(mysql_num_rows($result))
      {
	    $query = "INSERT INTO subscribe values(NULL,'$co_username','$sub_username')";
	    mysql_query($query);

      
      
	    echo "Already is subscribed";
      
      }

      else
      { 
	    $query = "INSERT INTO subscribe values(NULL,'$co_username','$sub_username')";
	    mysql_query($query);

	  
	    echo "Subscribed";
	    
      }
}
?>