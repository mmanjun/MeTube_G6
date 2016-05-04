<?php
session_start();
include_once "function.php";

$username=$_SESSION['username'];
$fuser = $_GET['username'];
$relation;	




$query = "SELECT * from account where username='$_GET[username]'"; 
$result = mysql_query( $query );
if(!$result)
{
  die ("Could not query the media table in the database: <br />". mysql_error());
}
while ($result_row = mysql_fetch_assoc($result))
{
  $uname=$result_row['username'];
  $firstname=$result_row['fname'];
  $lastname=$result_row['lname'];
  $email=$result_row['email'];
  
}
 
 ?>

<!DOCTYPE html>

<html lang="en">
  <head>
   <title>View Profile</title>
	<link rel="stylesheet" href="css/style.css">
  </head>

  <body>
   
	<div id="wrap">
		<div id="regbar">
			<div id="navthing">
			<h2 class ="posLeft" ><a  href="mymetube.php"> MeTube</a></h2>
			<p class="headRight" >Hi <?php echo $_SESSION['username'];?>, <a href="profile.php" >Profile</a> | <a href="friend.php" >Friends</a> | <a href="logout.php" >Log Out</a> | <a href='uploadmedia.php'  style="color:#FF9900;">Upload File</a></p>
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
        <h2	style="color: #1abc9c;"><?php echo $firstname; echo" "; echo $lastname?></h2>
		<form  method="POST" action=''>
		
             <input class="myButton" type="submit" name="unblock" id="unblock" value="Unblock" /> 
			  
        
           
        </form>
		
        
        <h3 align="left">Username : <small><?php echo $uname; ?></small></h3>
        <h3 align="left">Email : <small><?php echo $email; ?></small></h3>
        
      </div>    
      
      </div> <!-- /container -->
    </div>
	<?php
		if(isset($_POST['unfriend']))
		{
			$query = "DELETE from user_contact where username='$username' and fusername='$_GET[username]' and status= -1";
			$result=mysql_query($query);
			
			//location to redirect to change.........
			header('Location:friend.php');
			
		}
		
		
	?>

    <!--================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    

  </body>
</html>