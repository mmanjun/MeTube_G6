<?php
session_start();
include_once "function.php";

//$username=$_SESSION['username'];
$username='shoab101';
$mediaid='22';
?>

<html>
<head> 
      <script>
	    function addtoplaylist()
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
	      var results=document.getElementById("list").value;
	      // document.getElementById("listresult").innerHTML = results;
	      str = toString(results);
	      xmlhttp.onreadystatechange=function()
	      {
	      if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("listresult").innerHTML=xmlhttp.responseText;
		}
	      }
	    xmlhttp.open("GET","addmediatolist.php?mediaid=<?php echo $mediaid;?>&pid="+ str,true);
	    xmlhttp.send();
	    }
      </script>
</head>




<?php
	
	$query="SELECT * FROM  `playlists` 
	WHERE username =  '$username'
	LIMIT 0 , 30";
?>


	<?php

	$plist = mysql_query($query) or die ("Failed to load friends");
	   // echo "<select name='playlistlist' id='list' onChange='addtoplaylist(this.value)'>"; 
	   echo "<select name='playlistlist' id='list'>";
		echo "<option value='none'>choose playlist</option>";
		while($result=mysql_fetch_assoc($plist))
		{
			echo "<option value=".$result['pid'].">".$result['pname']."</option>";

		}
		echo "</select>";
		

	
	?>
	<input type="button" value="click" onClick= 'addtoplaylist()' />

<p id="listresult"></p>
</html>