<?php
session_start();
include_once "function.php";

$username=$_SESSION['username'];
$fuser = $_GET['username'];
$relation;	


$query = "SELECT * from account where username='$fuser'"; 
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
  //echo $uname;
  
}


/*
 * Managing Friend Request Buttons according to 
 * the relationship status of user
 * 
 * 
 */
$query = "SELECT * FROM user_contact WHERE username='$username' and fusername='$fuser' and status=0";
$result = mysql_query( $query );
$resultRows = mysql_num_rows($result);
//echo $resultRows;


/**If friend Request is sent**/
if($resultRows> 0){
	$relation = "fSent";
	$string = "Undo Friend Request";
	$declineType = "hidden";
}
else{

		$query = "SELECT * FROM user_contact WHERE username='$fuser' and fusername='$username' and status=0";
		$r = mysql_query( $query );
		$resultRows = mysql_num_rows($r);
		//echo $resultRows;
		if($resultRows>0){
			$relation = "fReceived";
			$string = "Accept Friend Request";
			$declineType = "submit";
		}
		else{
			$relation = "fOther";
			$string = "Send Friend Request";
			$declineType = "hidden";
		}

}

/*
 * Option of adding to the contact list according to relationship
 * with the user
 * 
 * 
 */
$query = "SELECT * FROM user_contact WHERE username='$username' and fusername='$fuser' and status=1";
$result = mysql_query( $query );
$resultRows = mysql_num_rows($result);
//echo $resultRows;

/**If friend Request is sent**/
if($resultRows> 0){
	$contact = "inContact";
	$stringC = "Remove from contacts";
	
}
else{
	
	$contact = "notInContact";
	$stringC = "Add to contacts";	

}

 
?>



<!DOCTYPE html>

<html lang="en">
  <head>
   <title>View Profile</title>
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
    
     
      <div class="contentLeft"> <!--Body Container-->
        <h2	style="color: #1abc9c;"><?php echo $firstname; echo" "; echo $lastname?></h1>
		<form  method="POST" action=''>
		
             <input class="myButton" type="submit" name="<?php echo $relation;?>" id="<?php echo $relation;?>" value="<?php echo $string;?>" /> 
             <input class="myButton" type="<?php echo $declineType;?>" name="decline" id="decline" value="Decline Friend Request" />
			  <input class="myButton" type="submit" name="block" id="block" value="Block"/> 
			  <input class="myButton" type="submit" name="message" id="message" value="Message" />
			  <input class="myButton" type="submit" name="<?php echo $contact;?>" id="<?php echo $contact;?>" value="<?php echo $stringC;?>" /> 
			  
			      
        </form>
		
        <p class="colWhite">Name : <small><?php echo get_name($uname); ?></small></h3>
        <p class="colWhite">Email : <small><?php echo $email; ?></small></h3>
        
     
    
    
    
    
	<?php
		
		/*Message*/
		if(isset($_POST['message']))
		{
			header('Location:message.php?username='.$uname);
			
		}
		/*Block*/
		if(isset($_POST['block']))
		{
			$query = "	DELETE from user_contact where (username='$fuser' OR username='$username') 
						AND (fusername='$username' or fusername='$fuser') AND (status= 2 OR status= 1 OR status= 0)";
			$result=mysql_query($query);
			
			$query = "INSERT INTO user_contact where username='$username' AND fusername='$fuser' AND status=-1";
			$result=mysql_query($query);
			
			header('Location:friend.php');
			
		}
		
		/*fSent*/
		if(isset($_POST['fSent']))
		{
			
			$query = "DELETE from user_contact where username='$username' and fusername='$fuser' and status= 0";
			$result=mysql_query($query);
			header('Location:selectProfileType.php?username='.$fuser);
			
		}
		/*fReceived*/
		if(isset($_POST['fReceived']))
		{
			
			//Insert user and fuser as friend (2)
			$query="insert into user_contact (username,fusername,status) values('$username','$fuser',2)";
			$result=mysql_query($query);
			
			//Insert fuser and user as friend (2)
			$query="insert into user_contact (username,fusername,status) values('$fuser','$username',2)";
			$result=mysql_query($query);
			
			//Delete the entry for friend request (0)
			$query = "	DELETE from user_contact WHERE (username='$fuser' OR username='$username') 
						AND (fusername='$username' OR fusername='$fuser') AND (status=0 OR status=1)";
			$result=mysql_query($query);
			
			header('Location:selectProfileType.php?username='.$fuser);
			
			
		}
		
		
		/*decline*/
		if(isset($_POST['decline']))
		{
			
			$query = "DELETE from user_contact where username='$fuser' and fusername='$username' and status= 0";
			$result=mysql_query($query);
			header('Location:selectProfileType.php?username='.$fuser);
			
		}
		/*fOther*/
		if(isset($_POST['fOther']))
		{
			
			//Insert Friend Request
			$query="insert into user_contact (username,fusername,status) values('$username','$fuser',0)";
			$result=mysql_query($query);
			header('Location:selectProfileType.php?username='.$fuser);
			
		}
		
		/*User contacts*/
		if(isset($_POST['inContact']))
		{
			//Delete from contact list
			$query = "DELETE from user_contact where username='$username' and fusername='$fuser' and status= 1";
			$result=mysql_query($query);
			header('Location:selectProfileType.php?username='.$fuser);	
		}
		if(isset($_POST['notInContact']))
		{
			//Delete from contact list
			$query="insert into user_contact (username,fusername,status) values('$username','$fuser',1)";
			$result=mysql_query($query);
			header('Location:selectProfileType.php?username='.$fuser);	
		}
		
	?>
      

    
	
        <h2 style="color: #1abc9c;"><?php echo get_name($fuser)?>'s Media: </h2>
        <div >
        <?php


	
        $query = "SELECT * from views natural join media  WHERE permission ='public' and username='$fuser' order by viewcount desc"; 
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
              <td><p><a href="media.php?id=<?php echo $result_row['mediaid'];?>"><?php echo $result_row['title'];?></a></p></td>
			
              <td><span class="contentLeft"><a href="<?php echo $result_row['title'].$result_row['title'];?>" target="_blank" onclick="javascript:saveDownload(<?php echo $result_row['mediaid'];?>);">Download</a></span></td>
			  </tr>
			  <table>
            </div>
        <?php
        }
        ?>
      </div>
	</div>
  </body>
</html>
