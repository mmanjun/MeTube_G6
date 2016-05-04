<?php
session_start();
include_once "function.php";
$username=$_SESSION['username'];
 ?>
<!DOCTYPE html>

<html lang="en">
   <head>
    <title>My Metube</title>
	<link rel="stylesheet" href="css/main.css">
  				
				
				
   
    <script>
	function createplaylist()
	{
	    var xmlhttp=new XMLHttpRequest();
	    var results=document.getElementById("txt").value;
	    str = String(results);
	    xmlhttp.onreadystatechange=function()
	      {
	      if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("mainframe").innerHTML=xmlhttp.responseText;
		}
	      }
	    xmlhttp.open("GET","createplaylistbackend.php?pname="+str,true);
	    xmlhttp.send();
	}

    </script> 
 </head>

  
			<div id="wrap">
				    <div id="regbar">
					    <div id="navthing">
					    <h2 class ="posLeft" ><a  href="mymetube.php"> MeTube</a></h2>
					    <h3 class="headRight" >Hi <?php echo $_SESSION['username'];?></h3>
					    <p> <a href="profile.php" >Profile</a> | <a href="friend.php" >Friends</a> | <a href="logout.php" >Log Out</a> | <a href='uploadmedia.php'  style="color:#FF9900;">Upload File</a></p>
					    </div>
				    </div>			
			    </div>
				<div class="left">
					<ul><a href="mymessages.php">My Messages</a></ul>
					<ul><a href="allplaylist.php">Playlist</a></ul>
					<ul><a href="mychannel.php">Channels</a></ul>		
					
					<ul><a href="showfavourites.php">Favourites</a></ul>
					<ul><a href="categoryPage.php?cName=movies">Categories</a></ul>
					<ul><a href="groups.php">Groups</a></ul>
					
					
				</div>

      
      <div class="contentLeft"> <!--Body Container-->
      
  

      <p style="color: #1abc9c;">Create new playlist</p>
       <h4 class="colWhite">Name:</h4>
      <input type="text" name="txt" id="txt"/>
      <button type="button" onclick="createplaylist()">create playlist</button> 

      <p style="color: #1abc9c;"> Playlists: </p>
      <div id="mainframe"> 
      <?php
      $query = "SELECT * FROM playlists WHERE username= '$username'";
      $result = mysql_query( $query ) or die("Insert into Media error in media_upload_process.php " .mysql_error());

      while ($result_row = mysql_fetch_assoc($result))
	  { 
	  ?>
		<h4> <a href="displayplaylist.php?pid=<?php echo $result_row['pid'];?>" > 

							<?php  echo $result_row['pname'];?></a></h4>
      
	    <?php
	  }
	  ?> 
     
      </div>
      
	  </div> <!-- /container -->


	
      
  </body>
</html>