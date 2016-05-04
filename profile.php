<?php
session_start();
include_once "function.php";
/*include_once "sql.php";*/
$username=$_SESSION['username'];

$query = "SELECT * from account where username='$username'"; 
$result = mysql_query( $query );
if(!$result)
{
  die ("Could not query the media table in the database: <br />". mysql_error());
}
while ($result_row = mysql_fetch_assoc($result))
{
  $username=$result_row['username'];
  $firstname=$result_row['fname'];
  $lastname=$result_row['lname'];
  $email=$result_row['email'];
  $dob=$result_row['birthdate'];
  
}
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
			<h3 class="headRight" >Hi <?php echo $_SESSION['username'];?>, <a href="profile.php" >Profile</a> | <a href="friend.php" >Friends</a> | <a href="logout.php" >Log Out</a> | <a href='uploadmedia.php'  style="color:#FF9900;">Upload File</a></h3>
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

   
      
      
        
		<div class="contentLeft">
		<h2>Profile</h2>
        <span id="profile">
          <h3 align="left">Username : <small><?php echo $username; ?></small></h3>
          <h3 align="left">Name : <small><?php echo $firstname; ?></small> <small><?php echo $lastname; ?></small></h3>
          <h3 align="left">Email : <small><?php echo $email; ?></small></h3>
		  <h3 align="left">Date of Birth : <small><?php echo $dob; ?></small></h3>
		  
        </span>
        </div>
        <div class="update">
          <form role="formholder" method="POST" action="profileUpdate.php">
            <div class="randompad">
			<fieldset>
              <h3 type="white" name="firstname">Firstname</h3>
              <input type="text" class="formholder" name="firstname" value="<?php echo $firstname;?>"/>
              <h3 name="lastname">Lastname</h3>
              <input type="text" class="formholder" name="lastname" value="<?php echo $lastname;?>"/>
              <h3 name="email">Email</h3>
              <input type="email" class="formholder" name="email" value="<?php echo $email;?>"/>
			  <h3 name="email">Date of Birth</h3>
              <input type="date" class="formholder" name="dob" value="<?php echo $dob;?>"/>
              <button class="styled-button-8" type="submit" id="btnupdate">submit</button>
               </fieldset>
            </div>
        </form> 
	</div>
	
	
    <script src='http://codepen.io/assets/libs/fullpage/jquery.js'></script>
	<script src="js/index.js"></script>
  </body>
</html>