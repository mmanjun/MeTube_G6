<?php
session_start();
include_once "function.php";
$username=$_SESSION['username'];

if(isset($_POST['freq']))
{
  $fusername=$_POST['fusername'];
  $freq=$_POST['freq'];
  if($freq=='accept')
  {
	//Add user and fuser as friend (2)
    $query="insert into user_contact (username,fusername,status) values('$username','$fusername',2)";
    $result=mysql_query($query);
	//Add fuser and user as friend (2)
    $query="insert into user_contact (username,fusername,status) values('$fusername','$username',2)";
    $result=mysql_query($query);
	//Delete the entry for friend request (0)
    $query = "DELETE from user_contact where username='$fusername' and fusername='$username' and (status=0 OR status=1)";
    $result=mysql_query($query);
	//Delete the entry in user's contact list (1)
	$query = "DELETE from user_contact where username='$username' and fusername='$fusername' and status=1)";
    $result=mysql_query($query);
  }
  else if($freq=='block')
  {
	//Set Friendship status to Block(-1)
	$query="insert into user_contact (username,fusername,status) values('$username','$fusername',-1)";
    $result=mysql_query($query);
	//Revoke all other associations
    $query = "DELETE from user_contact where username='$fusername' and fusername='$username' and status>-1";
    $result=mysql_query($query);
	//Revoke all other associations
	$query = "DELETE from user_contact where username='$username' and fusername='$fusername' and status>-1";
    $result=mysql_query($query);
  }
  else if($freq=='decline')
  {
    $query = "DELETE from user_contact where username='$fusername' and fusername='$username' and status=0";
    $result=mysql_query($query);
  }
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
    
      <form  role="search" method=get action="searchProfile.php" style="position:relative;left:100px"><!--search Friends-->
            <div class="form-group" >
              <input type="text" class="contentLeft" name="name" placeholder="Find Friends" style="width:360px; height:32px">
            </div>
            <button type="submit" class="styled-button-8"  style="position:relative;left:-8px;border-top-left-radius:0;border-bottom-left-radius:0;"><span class="glyphicon glyphicon-search"></span> Search</button>
           
          </form>
      <div class="contentLeft"> <!--Body Container-->
        <h2 style="color: #1abc9c;"><u>Friend Requests:</u></h2>
        <div id="table">
          <table class="table">
        <?php
        $query = "SELECT username from user_contact where fusername='$username' AND status = 0"; 
        $result = mysql_query( $query );
        if (!$result)
        {
          die ("Could not query the database: <br />". mysql_error());
        }
        while ($result_row = mysql_fetch_array($result,MYSQL_ASSOC))
        {
          ?>
          
          <tr>
            <td><form action="friend.php" method="post">
				<h4><a href="selectProfileType.php?username=<?php echo $result_row['username'];?>"><?php echo get_name($result_row['username']);?></a> 
              <button class="myButton" type="submit" name="freq" value="accept">Accept</button>
              <button class="myButton" type="submit" name="freq" value="decline">Decline</button>
			   <button class="myButton" type="submit" name="freq" value="block">Block</button>
              <input type="hidden" value="<?php echo $result_row['username'];?>" name="fusername">
            </form>
            </h4> 
          </td>
          </tr>

        <?php
        }
        ?>
      </table>
    </div>
	
	
	<h2 style="color: #1abc9c;"><u>Contacts:</u></h2>
    <div class="row placeholders">
        <?php
        $query = "SELECT fusername from user_contact where username='$username' AND status >= 1"; 
        $result = mysql_query( $query );
        if (!$result)
        {
          die ("Could not query the  table in the database: <br />". mysql_error());
        }
        while ($result_row = mysql_fetch_assoc($result))
        {

        ?>
        <div >
             
              <h4><a href="selectProfileType.php?username=<?php echo $result_row['fusername'];?>"><?php echo get_name($result_row['fusername']); ?></a></h4>
            </div>
        <?php
        }
        ?>
      </div>


      
    <h2 style="color: #1abc9c;"><u>Friends:</u></h2>
    <div class="row placeholders">
        <?php
        $query = "SELECT fusername from user_contact where username='$username' AND status = 2"; 
        $result = mysql_query( $query );
        if (!$result)
        {
          die ("Could not query the table in the database: <br />". mysql_error());
        }
        while ($result_row = mysql_fetch_assoc($result))
        {

        ?>
        <div >
             
              <h4><a href="selectProfileType.php?username=<?php echo $result_row['fusername'];?>"><?php echo get_name($result_row['fusername']); ?></a></h4>
            </div>
        <?php
        }
        ?>
      </div>


      </div> <!-- /container -->

</div> <!-- /container -->
  


</script>
  </body>
</html>
