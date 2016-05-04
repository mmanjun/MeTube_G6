<?php
session_start();
include_once "function.php";
$username=$_SESSION['username'];
$pname=$_GET['pname'];
 ?>

<html lang="en">


       <?php

	
	$query = "SELECT * FROM playlists WHERE username= '$username' and pname ='$pname'";
	  $result = mysql_query( $query ) or die("Insert into Media error in media_upload_process.php " .mysql_error());
		
	if(mysql_num_rows($result))
	{
	  echo "playlist already exists";
	  $query = "SELECT * FROM playlists WHERE username= '$username' and pname ='$pname'";
	  $result = mysql_query( $query ) or die("Insert into Media error in media_upload_process.php " .mysql_error());
	  while ($result_row = mysql_fetch_assoc($result))
	      { 
	      ?>
		    <h4><a href="displayplaylist.php?pid=<?php echo $result_row['pid'];?>"> <?php echo $result_row['pname'];?></a></h4>

		    <?php
	      }
	      }

	else
	    {
	  $query = "INSERT INTO playlists values(NULL,'$pname', '$username')";
	  $result = mysql_query($query) or die("Insert into Media error in media_upload_process.php " .mysql_error());


	  $query1 = "SELECT * FROM playlists WHERE username= '$username'";
	    $result1 = mysql_query( $query1 ) or die("Insert into Media error in media_upload_process.php " .mysql_error());


	  while ($result_row1 = mysql_fetch_assoc($result1))
		{ 
		?>
		      <h4><a href="displayplaylist.php?pid=<?php echo $result_row1['pid'];?>"> <?php echo $result_row1['pname'];?></a></h4>

		      <?php
	  }


	    }
  ?>



</html>