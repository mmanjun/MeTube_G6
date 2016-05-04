<?php
session_start();
include_once "function.php";
$username=$_SESSION['username'];



  $channelname=$_GET['channelname'];

 ?>
<!DOCTYPE html>

<html lang="en">
  <head>
     <title>My Metube</title>
	<link rel="stylesheet" href="css/main.css">
  </head>

  <body>
			<div id="wrap">
				    <div id="regbar">
					    <div id="navthing">
					    <h2 class ="posLeft" ><a  href="mymetube.php"> MeTube</a></h2>
					    <h3 class="headRight" >Hi <?php echo $username;?></h3>
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
        <h2 style="color: #1abc9c;"><?php echo get_name($channelname);?>'s Channel </h2>
        <div class="row placeholders">
        <?php



        $query = "SELECT *   FROM upload
		  NATURAL JOIN media
		  WHERE username =  '$channelname'
		  AND permission =  'public' order by mediaid desc
		  LIMIT 0 , 30"; 
 	//echo "<br>".$query;
        $result = mysql_query( $query );
        if (!$result)
        {
          die ("Could not query the media table in the database: <br />". mysql_error());
        }
        while ($result_row = mysql_fetch_assoc($result))
        {
          ?>
          
             <div id="img-pic"><table>
			<tr>
             <td> <img src="<?php echo $result_row['thumbnailpath'];?>" alt="Image" width="30px" height="30px" ></td>
              <td><p>&nbsp;<a href="media.php?id=<?php echo $result_row['mediaid'];?>"><?php echo $result_row['title'];?></a></p></td>
			
              
			  </tr>
			  <table>
            </div>
        <?php
        }
        ?>
      </div>
        
      </div>


    </div> <!-- /container -->


   
  
  </body>
</html>