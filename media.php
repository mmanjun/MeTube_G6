<?php
session_start();
include_once "function.php";
//include_once "sql.php";
$username=$_SESSION['username'];
$_SESSION['userid']=get_userid($username);
$mid=$_GET['id'];


// echo $_SESSION['userid'];
if(isset($_GET['id'])) {
  $query = "SELECT * FROM media WHERE mediaid='".$_GET['id']."'";
  $mediaid = $_GET['id'];
  $result = mysql_query( $query );
  $result_row = mysql_fetch_assoc($result);
  $filename=$result_row['filename'];
  $title=$result_row['title'];
  $co_username=$result_row['username'];
  $filepath=$result_row['filepath'];
  $type=$result_row['type'];
  $description=$result_row['description'];
}

  $flag=0;
  $viewnumber=0;	
  $viewquery = "SELECT * FROM views WHERE mediaid='".$_GET['id']."'";
  //echo "viewquery = ".$viewquery."<br>";
  $viewresult = mysql_query( $viewquery );
  //echo "viewresult = ".$viewresult."<br>";
  if(mysql_num_rows($viewresult)==0)
  {
  	$viewquery = "INSERT INTO views values('".$_GET['id']."','0')";
	//echo "viewquery".$viewquery."<br>";
  	mysql_query($viewquery);
  }

  else
  {
	$viewresult_row = mysql_fetch_row($viewresult);
	//echo "viewresult_row = ".$viewresult_row."<br>";
  	$viewnumber=intval($viewresult_row[1]);
  	//echo "viewnumber = ".$viewnumber."<br>";
  	//$viewnumber=$viewnumber + 1;
  	$viewnumber++;
//   	echo "<br><br><br><br><br>viewnumber = ".$viewnumber."<br>";
  	$viewupdatequery = "UPDATE views SET viewcount=$viewnumber WHERE mediaid='".$_GET['id']."'";
//   	echo "<br><br>view update query = ".$viewupdatequery."<br>";
  	$viewupdateresult = mysql_query( $viewupdatequery ) or die("Insert into views error in media_upload_process.php " .mysql_error());
  }
  
   
   $likequery = "SELECT likecount FROM likes WHERE mediaid=". $_GET['id'];
   $likeresult = mysql_query( $likequery );
   $res_like=mysql_fetch_assoc($likeresult);
   $likes=$res_like['likecount'];
	
  $ratequery = "SELECT ROUND(AVG( rate ),1) AS avg_rate FROM  `mediarating` WHERE mediaid = '".$_GET['id']."'";
//   echo "<br><br><br><br> rate query = ".$ratequery."<br>";
  $rateresult = mysql_query($ratequery);
//   echo "<br><br><br><br> rate_result = ".$rateresult."<br>";
  if ($rateresult == "") #handel empty response for new videos without any rate (no record in table)
  {
    $avg_rate = 1;
  }
  else			# return the actual result of rating
  {
    $result_row=mysql_fetch_assoc($rateresult);
    $avg_rate=$result_row['avg_rate'];
    
  }
//   echo "<br><br><br><br> avg_rate = ".$avg_rate."<br>";




?>


<!DOCTYPE html>

<html lang="en">
  <head>
    

    <title>MeTube Media</title>

     <link rel="stylesheet" href="css/main.css">
<!--     <script > -->
    <script type="text/javascript">
	function mr(str) 
	{
	  <?php
	  $mid= $_GET['id'];
	   
	  ?>
	    var xmlhttp=new XMLHttpRequest();
	    var results=document.getElementById("rate_list").value;
	    var mediaid_hidden_field=document.getElementById("mediaid").value;
	    
	    str_mediaid = String(mediaid_hidden_field); 
	    xmlhttp.onreadystatechange=function()
	      {
	      if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("rate_list").innerHTML=xmlhttp.responseText;
		}
	      }
	xmlhttp.open("GET","mediarating.php?mid=<?php echo $mid;?>&rid="+rate_list.value,true);
	xmlhttp.send();
	
	}   

    
	function addsubscribtion()
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
	    document.getElementById("btn-subscribe").innerHTML=xmlhttp.responseText;
	    }
	  }
	xmlhttp.open("GET","subscribe.php?co_username=<?php echo $co_username;?>&sub_username=<?php echo $username;?>",true);
	xmlhttp.send();
	}

	function addcomments()
	{
	    var xmlhttp=new XMLHttpRequest();
	    var results=document.getElementById("comment_note").value;
	    var mediaid_hidden_field=document.getElementById("mediaid").value;
	    str = String(results);
	    str_mediaid = String(mediaid_hidden_field); 
	    xmlhttp.onreadystatechange=function()
	      {
	      if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("comment-container").innerHTML=xmlhttp.responseText;
		}
	      }
// 	    alert(str+"&id="+str_mediaid);
	    xmlhttp.open("GET","addcomment.php?note="+str+"&id="+str_mediaid,true);
	    xmlhttp.send();
	    
	}
	
	
	function addtofavourites()
	{
		var xmlhttp=new XMLHttpRequest();
		var mediaid_hidden_field=document.getElementById("mediaid").value;
		
		str_mediaid = String(mediaid_hidden_field); 
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
				
		    document.getElementById("fav").innerHTML=xmlhttp.responseText;
		    }
		  }  
// 		alert(str_mediaid);
		xmlhttp.open("GET","addtofavouritelist.php?mediaid="+str_mediaid,true);
		xmlhttp.send();
	}
	
	
	
	
	
	function addtoplaylist()
	{
		var xmlhttp=new XMLHttpRequest();
		var mediaid_hidden_field=document.getElementById("mediaid").value;
		str_mediaid = String(mediaid_hidden_field); 
		
		var results=document.getElementById("list").value;
		// document.getElementById("listresult").innerHTML = results;
		str = parseInt(results);
		
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
		    document.getElementById("plist").innerHTML=xmlhttp.responseText;
		    }
		  }  
//  		alert(str_mediaid);
//  		alert(str);
		xmlhttp.open("GET","addmediatolist.php?mediaid="+str_mediaid+"&pid="+str,true);
		xmlhttp.send();
	}
	
	
	
	function saveDownload(id)
	{
		window.location.href = "<?php echo $filepath.$filename;?>";
		
		var xmlhttp=new XMLHttpRequest();
		var mediaid_hidden_field=document.getElementById("mediaid").value;
		str_mediaid = String(mediaid_hidden_field); 
		
				
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
		    document.getElementById("mainframe").innerHTML=xmlhttp.responseText;
		    }
		  }  
 		//alert(str_mediaid);
 		
		xmlhttp.open("GET","media_download_process.php?mediaid="+str_mediaid,true);
		xmlhttp.send();
	} 
	
	
	function savelikes()
	{
	    var xmlhttp=new XMLHttpRequest();
	    var results=document.getElementById("comment_note").value;
	    var mediaid_hidden_field=document.getElementById("mediaid").value;
	    str = String(results);
	    str_mediaid = String(mediaid_hidden_field); 
	    xmlhttp.onreadystatechange=function()
	      {
	      if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("likes").innerHTML=xmlhttp.responseText;
		}
	      }
// 	    alert(str+"&id="+str_mediaid);
	    xmlhttp.open("GET","savelikes.php?mediaid="+str_mediaid,true);
	    
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
 
	<form  role="search" method=get action="searchmedia.php" style="position:relative;left:100px">
		<div class="form-group" >
		      <input type="text" class="contentLeft" name="search" placeholder="Videos, Images.." style="width:360px; height:32px">
		</div>
		      <button type="submit" class="styled-button-8"  style="position:relative;left:-8px;border-top-left-radius:0;border-bottom-left-radius:0;"><span class="glyphicon glyphicon-search"></span> Search</button>
		<div class="radio">
			<label>
				<input type="radio" name="search1" value="keyword" checked>Keywords 
			</label>
			<label>
				<input type="radio" name="search1" value="title">Title
			</label>
		
		</div>
          </form>
	  
	  
	  

    <div class="contentLeft">
      <div>
      
      	<div  id="mainframe"> <!--video container-->   		
      		<div>
      			<div>

              <?php if (stripos($type,"video")!==false)
              {?>
              <video src="<?php echo $filepath.$filename; ?>" width="500" height="390" controls>
      				Your browser does not support the video tag.
      				</video>
              <?php }?>
      			  
              <?php if (stripos($type,"audio")!==false)
              {?>
              <audio src="<?php echo $filepath.$filename; ?>" width="680" controls>
              Your browser does not support the video tag.
              </audio>
              <?php }?>

              <?php if (stripos($type,"image")!==false)
              {?>
              <img src="<?php echo $filepath.$filename; ?>" width="680" height="390" controls>
              </img>
              <?php }?>




            </div>
      		</div>
			</div>
        <?php  $query="SELECT *  FROM  `playlists` 
			  WHERE username =  '$username'
			  LIMIT 0 , 30";
		$plist = mysql_query($query) or die ("Failed to load playlist");
		?>
      		<div > <!--box below video-->
      			<div >
      				<h3><?php echo $title;?></h3>
      			</div>
      		</div>
      		
      		<div >
      			<div >
      			<p style="color: #1abc9c;">Uploaded by <span style="font-weight:bold;font-size:120%;"><a href=""><?php echo $co_username;?></a></span></p>
      			<span><button class="myButton" onClick="addsubscribtion()" id="btn-subscribe">Subscribe</button></span>
      			
            
             <button class="myButton" onClick= 'addtofavourites()'><span id="fav">Add to Favourites<span></button>
             
             <a href="<?php echo $filepath.$filename;?>"  download="<?php echo $filepath.$filename;?>"  onclick="javascript:saveDownload(<?php echo $mediaid;?>);">&nbsp;Download</a>
            <?php
		$query="SELECT * FROM  `playlists` 
			WHERE username =  '$username'
			LIMIT 0 , 30";
		$plist = mysql_query($query) or die ("Failed to load playlist");
		  
		  echo "<select name='playlistlist' id='list'>";
		  echo "<option value='none'>Pick playlist</option>";
		  while($result=mysql_fetch_assoc($plist))
		  {
		    echo "<option value=".$result['pid'].">".$result['pname']."</option>";

		  }
		  echo "</select>";
		  

	    
	    ?>
	    <button class="myButton" onClick= 'addtoplaylist()'><span id="plist">Add to Playlist<span></button>   
	    
              </select>  <h4 id="listresult"> </h4>   			
      			</div>
            <div>
              <label style="color: #1abc9c;">Rating</label>
              <select id="rate_list" onChange='mr(this.value)'>
              <option value="1">1 Star</option>
              <option value="2">2 Star</option>
              <option value="3">3 Star</option>
              <option value="4">4 Star</option>
              <option value="5">5 Star</option>
              </select>
<!--<span><button class="myButton" id="btnrate" name = "Rate" onClick='mr(this.value)'></button></span><br>-->
              Rating : <?php echo $avg_rate; ?>
            </div>
			<span id="exp">
      			<div >
      				<span><h4 style="color: #1abc9c;"><?php echo $viewnumber;?> Views<h4></span>
      			</div>
      		</div>
           <div style="position:absolute;left:400px;">
              <span id="like-div"><button class="myButton" id="btnlike" onClick='savelikes()'>Like <span class="glyphicon glyphicon-thumbs-up"></span></button></span>
            </div>
          <div > <!--like div component-->
            <div >
              <h4 style="color: #1abc9c;"><span id="likes"><?php echo $likes;?></span> Likes<br> 

            </div>           
           
          </div>

      		<div >
      			<div>
      			<h4 style="color: #1abc9c;">Description</h4>
      			<p class="colWhite"><?php echo $description?></p>
      			<hr>
      			</div>
      		</div>
      		

      		<div > 
      			<div>
      				<h4 style="color: #1abc9c;">Comments</h4>
      				<hr>
              <div  id="comment-container">
      			<?php  $comment_query = "SELECT note,username,time FROM  comments          
					  NATURAL JOIN account                                                        
					 
					  WHERE mediaid = '$mid'
					  ORDER BY time DESC 
					  LIMIT 0,30"; 

			    $comment_result = mysql_query( $comment_query );

			    if (!$comment_result)
				{
				    die ("Could not query the comment table join to account table to retreive the comments in the database: <br />". mysql_error());
				}
		    
				    
				    while($comment_result_row = mysql_fetch_row($comment_result))
				    {
					 
					 ?> 
					 

					  <h5 class = "colWhite"> <?php echo $comment_result_row[1]." --    ".$comment_result_row[0]."  &nbsp;   ".$comment_result_row[2]; ?></h5>
				    <?php 
				    }  
				    ?> 
               		
               		</div>
                  </div>
            </div> <!--comments-->

      		<div >
      			<div  id="comment-box" id="comment-box"> 
      				<h4 style="color: #1abc9c;">Leave a Comment:</h4>
      				<form role="form" id="comment" >
      					<div class="form-group">
      						<textarea id="comment_note" class="form-control" rows="10" cols="50" name="comment"></textarea>
      					</div>
       					<input id="mediaid" type="hidden" name="id" value="<?php echo $_GET['id'];?>"> 
       					<button type="submit" onClick="addcomments()" class="myButton" id="comment_button">Submit</button> 
      					<!--<button type="submit" onclick="addcomments()" class="myButton" id="comment_button">Submit</button>-->
      					
      				</form>
      			</div>
      		</div> <!--comment box-->

      		

    


      	</div><!-- /video container -->


    </div> <!-- /container -->


    <?php

 
// handle new searches
if (isset($_GET['action']) and $_GET['action'] == 'keywords')
{
    // get the current time
    $now = date("Y-m-d H:i:s");
 
    // get the submitted term and prepare it for the database query
    $keyword = mysql_real_escape_string(strip_tags(trim($_GET['keyword'])));
 
}
 
// prepare the tag cloud array for display
$terms = array(); // create empty array
$maximum = 0; // $maximum is the highest counter for a search term
 
$query = mysql_query("SELECT keyword FROM keywords WHERE mediaid='$mid'");
 
while ($row = mysql_fetch_array($query))
{
    $keyword = $row['keyword'];
  
 
   
 
    $terms[] = array('keyword' => $keyword);
 
}
 
// shuffle terms unless you want to retain the order of highest to lowest
shuffle($terms); 

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Tag Cloud Example</title>
        <style type="text/css">
            #tagcloud {
                width: 300px;
                background:#CFE3FF;
                color:#0066FF;
                padding: 10px;
                border: 1px solid #559DFF;
                text-align:center;
                -moz-border-radius: 4px;
                -webkit-border-radius: 4px;
                border-radius: 4px;
            }

            #tagcloud a:link, #tagcloud a:visited {
                text-decoration:none;
                color: #333;
            }

            #tagcloud a:hover {
                text-decoration: underline;
            }

            #tagcloud span {
                padding: 4px;
            }

            #tagcloud .smallest {
                font-size: x-small;
            }

            #tagcloud .small {
                font-size: small;
            }

            #tagcloud .medium {
                font-size:medium;
            }

            #tagcloud .large {
                font-size:large;
            }

            #tagcloud .largest {
                font-size:larger;
            }
        </style>
    </head>

    <body>
        
        <form id="search" method="get" action="?action=search">
           
           
        </form>
        
        <h2>Popular Searches</h2>
        <div id="tagcloud">
            <?php 
            // start looping through the tags
            foreach ($terms as $keyword):
               echo " ";
            ?>
            <span class="<?php echo $class; ?>">
                <a href="searchmedia.php?search=<?php echo urlencode($keyword['keyword']); ?>"><?php echo $keyword['keyword']; ?></a>
            </span>
            <?php endforeach; ?>
        </div>
    </body>
</html>
  </body>
</html>