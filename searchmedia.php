<?php
session_start();
include_once "function.php";
$username=$_SESSION['username'];
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
			<h3 class="headRight" >Hi <?php echo $_SESSION['username'];?></h3>
			<p> <a href="profile.php" >Profile</a> | <a href="friend.php" >Friends</a> | <a href="logout.php" >Log Out</a> | <a href='uploadmedia.php'  style="color:#FF9900;">Upload File</a></p>
			</div>
		</div>			
	</div>
	<div class="left">
		<ul><a href="myMessages.php">My Messages</a></ul>
		<ul><a href="#">Playlist</a></ul>
		<ul><a href="#">Channels</a></ul>
		<ul><a href="#">Favourites</a></ul>
		<ul><a href="#">Categories</a></ul>
		
	</div>

          
          
    <?php
        $types = array();

	  if (isset($_GET['search']))
	  {
	      $search=$_GET['search'];
	      $search1=$_GET['search1'];
	      $s1 = str_replace("'", '', $search);
	      $s2 = preg_replace('/[^a-zA-Z0-9" "\']/', '', $s1);
	      $s2 = preg_replace( "/\s+/", " ", $s2 );
	      $sTerms = strip_tags($s2);
	      $searchTermDB = mysql_real_escape_string($sTerms);
	      $types=explode(" ", $searchTermDB);

	      if($search1 =="keyword")		
	      {
		      foreach ($types as &$value)
			  $value = " `keywords` LIKE '%{$value}%' ";
			  
			  $searchSQL = "SELECT * FROM `media` WHERE permission ='public' and ";
	  
			  $searchSQL .= implode(" OR ", $types) . " limit 0,10";
			  
			  echo "<h1>Search Results:</h1>";		
			  
			  $searchResult = mysql_query($searchSQL) or trigger_error("Error!<br/>" . mysql_error() . "<br />SQL Was: {$searchSQL}");
			  if (mysql_num_rows($searchResult) < 1) 
			  {
				    $error[] = "No Results";
				    die ("Could not find the media in the database: <br />". mysql_error());
			  }
			  else 
			  {
				  while ($result_row = mysql_fetch_assoc($searchResult)) 
				  {
			
				      ?>
				    
				      <div class="col-xs-6 col-sm-3 placeholder">
					<h4><a href="media.php?id=<?php echo $result_row['mediaid'];?>"><?php echo $result_row['filename'];?></a></h4>
					
				      </div>
				    <?php
				  }
			  }
		}       
	  
           else if($search1 == "title") 	
	  {
		echo "<h1>Search Results</h1>";		
		foreach ($types as &$value)
		    $value = " `title` LIKE '%{$value}%' ";
		
		$searchSQL = "SELECT * FROM `media` WHERE permission ='public' and";
	      

		$searchSQL .= implode(" OR ", $types) . " limit 0,10";
		$searchResult = mysql_query($searchSQL) or trigger_error("Error!<br/>" . mysql_error() . "<br />SQL Was: {$searchSQL}");
		
			
		
		if (mysql_num_rows($searchResult) < 1) 
		{
		      $error[] = "No Results";
		      die ("Could not find the media in the database: <br />". mysql_error());
		}
		else 
		{
		      while ($result_row = mysql_fetch_assoc($searchResult)) 
			  {
			  ?>
			  
			    <div class="col-xs-6 col-sm-3 placeholder">
			  			      <h4><a href="media1.php?id=<?php echo $result_row['mediaid'];?>"><?php echo $result_row['filename'];?></a></h4>
			      
			    </div>
			<?php
			}
		}

	  }
	    else 
	    {
		echo "<h1>General based search</h1>";	
		foreach ($types as &$value)
		$value = " `category` LIKE '%{$value}%' ";
		  

		$searchSQL = "SELECT * FROM `media` WHERE permission ='public' and";
		

		$searchSQL .= implode(" OR ", $types) . " limit 0,10";
		$searchResult = mysql_query($searchSQL) or trigger_error("Error!<br/>" . mysql_error() . "<br />SQL Was: {$searchSQL}");
		
		
		
		if (mysql_num_rows($searchResult) < 1) 
		{
		      $error[] = "No Results";
		      die ("Could not find the media in the database: <br />". mysql_error());
		}
		else 
		{
		      while ($result_row = mysql_fetch_assoc($searchResult)) 
		      {
			  ?>
		  
			    <div class="col-xs-6 col-sm-3 placeholder">
			      <h4><a href="media1.php?id=<?php echo $result_row['mediaid'];?>"><?php echo $result_row['filename'];?></a></h4>
			      
			    </div>
			<?php
		      }
		}

	}
}

            ?>
      </div>

    </div> <!-- /container -->


   
  </body>
</html>