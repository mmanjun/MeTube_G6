<?php
session_start();
include_once "function.php";
$username=$_SESSION['username'];
$stringName = $_GET['name'];






 ?>
<!DOCTYPE html>

<html lang="en">
  <head>
    

    <title>Search Friends</title>


     <link rel="stylesheet" href="css/main.css">
  </head>

<body>
  
  <div id="wrap">
    <div id="regbar">
      <div id="navthing">
      <h2 class ="posLeft" ><a  href="mymetube.php"> MeTube</a></h2>
      <h3 class="headRight" >Hi <?php echo $_SESSION['username'];?></h3><p> <a href="profile.php" >Profile</a> | <a href="friend.php" >Friends</a> | <a href="logout.php" >Log Out</a> | <a href='uploadmedia.php'  style="color:#FF9900;">Upload File</a></p>
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
  <h2 style="color: #1abc9c;">Results:</h2>
   
        <?php
        $query = "SELECT account.username from account where username!='.$username.'";

        $result = mysql_query( $query );
        if (!$result)
        {
          die ("Could not query the  table in the database: <br />". mysql_error());
        }
        while ($result_row = mysql_fetch_assoc($result))
        {

        ?>
        <div >
             
              <h3><a href="selectProfileType.php?username=<?php echo $result_row['username'];?>"><?php echo get_name($result_row['username']); ?></a></h3>
            </div>
        <?php
        }
        ?>
      </div>
      </div> <!-- /container -->
    


  


</script>
  </body>
</html>
