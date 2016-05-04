<?php
session_start();
include_once "function.php";
$username=$_SESSION['username'];
$fuser = $_GET['username'];


//Removing unread label
$query = "SELECT lastMessageId FROM conversations WHERE username = '$username' and fusername = '$fuser'"; 
$result = mysql_query( $query );
$result_array = mysql_fetch_array($result);
$mid = $result_array["lastMessageId"];


$query = "UPDATE conversations SET lastMessageSeenId = '$mid' WHERE username ='$username' AND fusername = '$fuser' ";
$result = mysql_query($query);


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


	
    <div class="contentLeft">
	<h2 style="color: #1abc9c;" >Messages:</h2>
        <?php
        $query = "SELECT * from messages where (sendUserId = '$username' or sendUserId='$fuser') and (receiveUserId='$username' or receiveUserId='$fuser') ORDER BY dateSent "; 
		$result = mysql_query( $query );
		if(!$result)
		{
			die ("Could not query the message table: <br />". mysql_error());
		}
		
        while ($result_row = mysql_fetch_assoc($result))
        {

        ?>
        <div >
             
              
			  <h3 class = "colWhite"><b><?php echo get_name($result_row['sendUserId']);?> </b>&nbsp &nbsp <?php echo$result_row['dateSent']?></h3>
			  <h3 class = "colWhite"><?php echo $result_row['message']; ?></h3>
            </div>
        <?php
        }
        ?>
		 <form action="processMessage.php" method="get">
          <input type="hidden" name="to" value="<?php echo $fuser; ?>">
          <textarea class="form-control" rows="5" cols="50" name="message" style="width:=500px"></textarea><br>
          <button type="submit" class="myButton">Send</button>
       </form>
      </div><!-- /container -->
	 
    

  


</script>
  </body>
</html>
