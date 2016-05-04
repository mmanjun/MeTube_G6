<?php
session_start();
?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <title>Metube</title>
	<link rel="stylesheet" href="css/main.css">

    

  </head>

  <body>
    
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
      
      <div class="contentLeft" > <!--Body Container-->
      	
      	<form role="form" method="post" action="uploadmediaprocess.php" enctype="multipart/form-data" >
    		<div>
    			<h3 for="uploadTitle">Title</h3><br>
    			<input type="text" class="form-control" name="title" required style="width:75%"><br>
    		</div>
    		<div>
    			<h3 class= "colWhite" for="uploadDescription">Description</h3><br>
    			<textarea  class="form-control" name="description" rows="4" cols="25" style="width:75%"></textarea>
    		</div>
    		<div >
    			<h3 class= "colWhite" for="uploadDescription">Keywords</h3><br>
    			<input type="text" class="form-control" name="keyword" required style="width:75%">
    		</div>
       
	<div class="form-group">
          <h3 class= "colWhite">Category</h3><br>
          <select class="form-control" name="category" required style="width:75%">
          <option value="music">Music</option>
          <option value="sports">Sports</option>
          <option value="movies">Movies</option>
          <option value="kids">Kids</option>
          <option value="education">Education</option>
          </select>
        </div>
        <div class="form-group">
          <h3 class= "colWhite">Permission</h3><br>
          <select class="form-control" name="permission" required style="width:75%">
          <option value="public">Public</option>
          <option value="private">Private</option>
        </div>

    		<div class="form-group">
    			<h3 class= "colWhite" for="uploadFile">File input</h3><br>
    			<input class= "colWhite" type="file" id="uploadFile" name="file" style="padding-top:5px">
				<h4 class= "colWhite">Each file limit 50M</h4>
  			</div>
  			<button class= "myButton" type="submit" name="submit" value="Upload">Upload</button>
  		</form>
  	</div> <!-- /container -->


   
  </body>
</html>