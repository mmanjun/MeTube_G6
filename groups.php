<?php
session_start();
include_once "function.php";
$username=$_SESSION['username'];
//$accid=$_SESSION['accid'];
 ?>
<!DOCTYPE html>

<html lang="en">
  <head>
   
    <title> Metube_G6</title>
	<link rel="stylesheet" href="css/main.css">

    <script>
	  function creategroup()
	  {

	  var xmlhttp=new XMLHttpRequest();
	  var results=document.getElementById("creategroup").value;
	  str = String(results);
	  xmlhttp.onreadystatechange=function()
	    {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
	      {
		

	      document.getElementById("displaygroups").innerHTML=xmlhttp.responseText;
	      }
	    }
	  xmlhttp.open("GET","creategroupbackend.php?gname="+str,true);
	  xmlhttp.send();
	  }

    </script> 
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
        
        <h2 style="color: #1abc9c;">Groups</h2>
        
          <div >
          <h3 class="colWhite" for="creategroup">Create Group</h3>
          <input type="text" class="form-control" id="creategroup" placeholder="Group name" name="groupname">
          <button type="button" class="myButton" onClick="creategroup()">Create</button>
          </div>
        
        <h2 style="color: #1abc9c;">Your Groups</h2>
       
<div id="displaygroups">
        <?php
        $query="SELECT * FROM groups where owner = '$username'";
        $result=mysql_query($query);
        if(mysql_num_rows($result))
        {
        while($row=mysql_fetch_assoc($result))
        {
          ?>
          <p><a href="groupdiscussion.php?gid=<?php echo $row['gid'];?>"><?php echo $row['gname'];?></a></p>
          <?php
        }}
         ?>
		<h2 style="color: #1abc9c;">Groups Joined by You:</h2>
       
		<div id="displaygroups">
        <?php
        $query="select * from groups inner join gmember on groups.gid = gmember.gid where gmember.username ='$username'";
        $result=mysql_query($query);
        if(mysql_num_rows($result))
        {
        while($row=mysql_fetch_assoc($result))
        {
          ?>
          <p><a href="groupdiscussion.php?gid=<?php echo $row['gid'];?>"><?php echo $row['gname'];?></a></p>
          <?php
        }}
         ?>
        <div>



    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>