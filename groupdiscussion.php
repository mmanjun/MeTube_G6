<?php
session_start();
include_once "function.php";
$username=$_SESSION['username'];
$gid=$_GET['gid'];
?>


<!DOCTYPE html>

<html lang="en">
  <head>
      <title>My Metube</title>
	<link rel="stylesheet" href="css/main.css">
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	    <script>
		    function addgroupmember(str)
		    {
		    var xmlhttp;
		    if (window.XMLHttpRequest)
		      {// code for IE7+, Firefox, Chrome, Opera, Safari
		      xmlhttp=new XMLHttpRequest();
		      }
		    else
		      {// code for IE6, IE5
		      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		      }
		    xmlhttp.onreadystatechange=function()
		      {
		      if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
			document.getElementById("friendadded").innerHTML=xmlhttp.responseText;
			}
		      }
	// 	    alert(str);
		    xmlhttp.open("GET","addmemberbackend.php?gid=<?php echo $gid;?>&fname="+str,true);
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
        <h2 style="color: #1abc9c;">Add your friends: </h2>
        <?php
        
          $gid=$_GET['gid'];
          $query="SELECT * FROM groups where gid='$gid'";
          $result = mysql_query($query) or die ("Failed to load group");
          $row = mysql_fetch_assoc($result);
        if($row['owner'] == $username)
        { 
        $query="SELECT *  FROM  user_contact 
		WHERE username =  '$username' and status = 2
		LIMIT 0 , 30";
        $friends = mysql_query($query) or die ("Failed to load friends");
        echo "<select name='friendlist' id='friends' onChange='addgroupmember(this.value)'>";
        echo "<option value='none'>Add Members</option>";
        
        if(mysql_num_rows($friends))
        {
          while($friend_result=mysql_fetch_assoc($friends))
            {
                echo "<option value=".$friend_result['fusername'].">".$friend_result['fusername']."</option>";
        }
      }
      else
      {
        echo "You have no friends to add in group";
      }
      echo "</select>";
    }
      
    ?>
        
        <p><span id="friendadded"></span></p>


        <div > 
            <div >
              <h4 style="color: #1abc9c;">Group Discussion</h4>
              <hr>
              <div id="comment-container">
            <?php  $query1 = "SELECT * FROM  gdiscussion NATURAL JOIN `account` WHERE gid = '$gid' ORDER BY TIME DESC LIMIT 0 , 30"; 
// 		    echo $query1;
                    $result1 = mysql_query( $query1 );
                    if (!$result1)
                        {
                             die ("Could not query the media table in the database: <br />". mysql_error());
                        }
                            while($result_row1 = mysql_fetch_assoc($result1))
                            {
                ?>
                                <h5 style="color: #fff;"><b><?php echo $result_row1['fname']." ".$result_row1["lname"]; ?></b>
                                <small><?php echo $result_row1['time'];?></small></h5>
                                <p style="color: #fff;"> <?php echo $result_row1['comment']; ?></p>
                    <?php }  ?>
                  </div>
                  </div>
            </div> <!--comments-->

            <div class="well" id="comment-box" > <!-- the comment box -->
              <h4 style="color: #1abc9c;">Leave a Comment on this discussion:</h4>
              <form role="form" id="comment" >
                <div >
                  <textarea class="form-control" rows="5" cols= "50" name="comment"></textarea>
                </div>
                <input type="hidden" name="gid" value="<?php echo $gid;?>">
                <button type="submit" class="myButton" id="Cbutton">Submit</button>
              </form>
            </div>
          </div> <!--comment box-->


      </div> <!--inner container-->

    </div> <!-- /container -->


   
    <script>
	  $(document).ready(function(){
	  $("#comment").submit(function(){
		event.preventDefault();
		var values = $(this).serialize();
// 		alert(values);
		$.ajax({
		  url: "groupcomment.php",
		  type: "post",
		  data: values,
		  success: function(data, textStatus, jqXHR){
		    $('#comment-container').html(data);
		    
		  },
		  error:function(){
		    alert("failure");
		      }
	      });
	      });
	  });
    </script>

  </body>
</html>