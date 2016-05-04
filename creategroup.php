<?php
session_start();
include_once "function.php";
include_once "sql.php";
$username=$_SESSION['username'];
$userid=$_SESSION['userid'];
echo $username;
?>

<html>
<head> <script>
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
xmlhttp.open("GET","addmemberbackend.php?fname="+str,true);
xmlhttp.send();
}
</script></head>




<?php
if(isset($_POST['groupname']))
{
	$groupname=$_POST['groupname'];
	$query="SELECT * 
FROM  `friendlist` 
WHERE username =  '$username'
LIMIT 0 , 30";
	$friends = mysql_query($query) or die ("Failed to load friends");
	if(mysql_num_rows($friends)>0)
	{
		$query="insert into groups (groupname,username) values('$groupname','$username')";
		mysql_query($query) or die("cannot create group");
		
		$gid=mysql_insert_id();
		$_SESSION['gid']=$gid;
		$query="insert into groupmembers (gid,username) values('$gid','$username')";
		mysql_query($query) or die("cannot create group");

		echo "<select name='friendlist' id='friends' onChange='addgroupmember(this.value)'>";
		echo "<option value='none'>Add Members</option>";
		while($friend_result=mysql_fetch_assoc($friends))
		{
			echo "<option value=".$friend_result['fusername'].">".$friend_result['fusername']."</option>";

		}
		echo "</select>";
		

	}
	else
	{
		echo "No friends, cannot create group";
	}
	?>
	<p><span id="friendadded"></span></p>

<?php
}


?>
</html>