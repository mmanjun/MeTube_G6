<?php
session_start();
include_once "function.php";

$username=$_SESSION['username'];
$to=$_GET['to'];
$message=$_GET['message'];
$dateSent =  date('Y-m-d H:i:s');
//$sendTime = new date_create()->format('Y-m-d H:i:s');
		echo $username;;
		echo $to;
		echo $message; '&nbsp';
		echo $dateSent; "&nbsp";
		//Run query only if the user has typed in message.
		if($_GET['message']!= ""){
			
			//Insert message into messages table
			$query="INSERT INTO messages (sendUserId, receiveUserId, dateSent, message) values ('$username','$to', '$dateSent','$message')";
			mysql_query($query) or die("cannot send message");
			
			//get the message id i.e. $mid
			$query="SELECT messageId FROM messages WHERE sendUserId = '$username'AND receiveUserId = '$to'AND dateSent = '$dateSent'AND message = '$message'";
			$result = mysql_query($query);
			$result_array = mysql_fetch_array($result);
			$mid = $result_array[0];
			$test='ZZZ';
			$test1='AAA';
			
			//Select user - fuser conversation data from conversations table
			$query = "SELECT * FROM conversations WHERE username = '$username' AND fusername = '$to' ";
			$result = mysql_query($query); 
			
			$row = mysql_fetch_array($result);
			$num_results = mysql_num_rows($result);
			/*
$query= 'SELECT * FROM table'." WHERE id IS NOT NULL";
$result = mysql_query($query) or die ("Error in query: $query " . mysql_error());
$row = mysql_fetch_array($result);
$num_results = mysql_num_rows($result);
if ($num_results > 0){
echo $row['category'];
}else{
echo 'no category'
}
			*/
//			if($result==0)
			
			if($num_results > 0){
				//Update conversations table if the enteries exist
				$query = "UPDATE conversations SET lastMessageId='$mid', lastMessageSeenId = '$mid' WHERE username ='$username' AND fusername = '$to' ";
				$result = mysql_query($query);
			//	$query = "UPDATE conversations SET lastMessageId='$mid' WHERE username ='$to' AND fname = '$username' ";
			//	$result = mysql_query($query);
			echo $test;
			}
			else{
				//Create enteries if they do not exist.
				$query = "INSERT into conversations (username, fusername,lastMessageId, lastMessageSeenId) values ('$username', '$to','$mid', '$mid') ";
				$result = mysql_query($query);
			//	$query = "INSERT into conversations (username, fname,lastMessageId, lastMessageSeenId) values ('$to', '$username','$mid',0) ";
			//	$result = mysql_query($query);
			echo $test1;	
			}
			
/*			if($result==0)
			{
				//Create enteries if they do not exist.
				$query = "INSERT into conversations (username, fname,lastMessageId, lastMessageSeenId) values ('$username', '$to','$mid', '$mid') ";
				$result = mysql_query($query);
			//	$query = "INSERT into conversations (username, fname,lastMessageId, lastMessageSeenId) values ('$to', '$username','$mid',0) ";
			//	$result = mysql_query($query);
			echo $test1;	
			}
			else{
				//Update conversations table if the enteries exist
				$query = "UPDATE conversations SET lastMessageId='$mid', lastMessageSeenId = '$mid' WHERE username ='$username' AND fname = '$to' ";
				$result = mysql_query($query);
			//	$query = "UPDATE conversations SET lastMessageId='$mid' WHERE username ='$to' AND fname = '$username' ";
			//	$result = mysql_query($query);
			echo $test;
			}
*/			
		}
		header('Location:messages.php?username='.$to);
		//echo $mid;
		
		
?>


