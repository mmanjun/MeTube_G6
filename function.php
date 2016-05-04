<?php
include "mysqlClass.inc.php";

function user_exist_check ($username, $password,$type,$birthdate,$fname,$lname,$email){
 
 
$password1= $_POST['password'];
$password2= $_POST['password'];
$Normal= $_POST['type'];
$Premium= $_POST['type'];
$birthdate= $_POST['birthdate'];
$fname= $_POST['fname'];
$lname= $_POST['lname'];
$email= $_POST['email'];
$type=$_POST['type'] ;
 
 
    $query = "select * from account where username='$username'";
    $result = mysql_query( $query );
    if (!$result){
        die ("user_exist_check() failed. Could not query the database: <br />". mysql_error());
    }   
    else {
        $row = mysql_fetch_assoc($result);
        if($row == 0){
            $query = "insert into account(`username`, `password`, `type`, `birthdate`, `fname`, `lname`, `email`)  values ('$username','$password','$type','$birthdate','$fname','$lname','$email')";
            echo "insert query:" . $query;
            $insert = mysql_query( $query );
            if($insert)
            {   
                return 1;
 
            }
            else
                die ("Could not insert into the database: <br />". mysql_error());        
        }
        else{
            return 2;
        }
    }
}


function is_user_exist ($username){
	$query = "select count(userid) from account where username='$username' limit 1";
	$result = mysql_query( $query );
	if (!$result)
	{
		die ("user_exist_check() failed. Could not query the database: <br />". mysql_error());
	}	
	else 
	{
		$row = mysql_fetch_row($result);
		if($row[0] == 0 ){
			return 0;	// False, the username is not exist
		}
		else{
			return 1;	
		}
	}

}

function register_user ($username, $password,$fname, $lname, $email,$dob){
	
	$query = "insert into account (`username`, `password`, `firstname`, `lastname`, `email`, `dob`) 
		  values ('$username','$password','$fname', '$lname', '$email', '$dob')";
	echo "insert query:" . $query;
	$insert = mysql_query( $query );
	if($insert){
		return 1;
		}
	else{
		die ("Could not insert into the database: <br />". mysql_error());		
		return 2;
	}
}



function user_pass_check($username, $password)
{
	
	$query = "select * from account where username='$username'";
	echo  $query;
	$result = mysql_query( $query );
		
	if (!$result)
	{
	   die ("user_pass_check() failed. Could not query the database: <br />". mysql_error());
	}
	else{
		$row = mysql_fetch_row($result);
		echo $row[1];
		if(strcmp($row[2],$password))
			return 2; //wrong password
		else 
			return 0; //Checked.
	}	
}

function updateMediaTime($mediaid)
{
	$query = "	update  media set lastaccesstime=NOW()
   						WHERE '$mediaid' = mediaid
					";
					 // Run the query created above on the database through the connection
    $result = mysql_query( $query );
	if (!$result)
	{
	   die ("updateMediaTime() failed. Could not query the database: <br />". mysql_error());
	}
}

function upload_error($result)
{
	//view erorr description in http://us2.php.net/manual/en/features.file-upload.errors.php
	switch ($result){
	case 1:
		return "UPLOAD_ERR_INI_SIZE";
	case 2:
		return "UPLOAD_ERR_FORM_SIZE";
	case 3:
		return "UPLOAD_ERR_PARTIAL";
	case 4:
		return "UPLOAD_ERR_NO_FILE";
	case 5:
		return "File has already been uploaded";
	case 6:
		return  "Failed to move file from temporary directory";
	case 7:
		return  "Upload file failed";
	}
}

function other()
{
	//You can write your own functions here.
}
	
function get_firstname($username)
{
	$query = "select fname from account where username='$username'";
	$result = mysql_query( $query );
	$row=mysql_fetch_row($result);
	$name=$row[0];
	return $name;
}

function get_name($username)
{
	$query = "select fname,lname from account where username='$username'";
	$result = mysql_query( $query );
	$row=mysql_fetch_row($result);
	$name=$row[0]." ".$row[1];
	return $name;
}
/*
function getSendingUsernameDate($username, $date)
{
	$query = "SELECT firstname,lastname FROM account WHERE username='$username'";
	$result = mysql_query( $query );
	$row=mysql_fetch_row($result);
	$resultString=$row[0]." ".$row[1]."-".$date;
	return $resultString;
}
*/

function getLastMessage($username, $fusername)
{
	$query = "SELECT lastMessageId FROM conversations WHERE username='$username' AND fusername = '$fusername'";
	$result = mysql_query( $query );
	$row=mysql_fetch_row($result);
	$mid=$row[0];
	
	
	$query = "SELECT message, sendUserId, DateSent FROM messages WHERE messageId = '$mid'";
	$result = mysql_query( $query );
	$row=mysql_fetch_row($result);
	
	//$userString = getSendingUsernameDate($row[1],$row[2]);
	$finalString = $row[0];
	return $finalString;
}

function getLastMessageSender($username, $fusername)
{
	$query = "SELECT lastMessageId FROM conversations WHERE username='$username' AND fusername = '$fusername'";
	$result = mysql_query( $query );
	$row=mysql_fetch_row($result);
	$mid=$row[0];
	
	
	$query = "SELECT sendUserId FROM messages WHERE messageId = '$mid'";
	$result = mysql_query( $query );
	$row=mysql_fetch_row($result);
	
	$userString = get_name($row[0]);
	
	return $userString;
}
function getLastMessageDate($username, $fusername)
{
	$query = "SELECT lastMessageId FROM conversations WHERE username='$username' AND fusername = '$fusername'";
	$result = mysql_query( $query );
	$row=mysql_fetch_row($result);
	$mid=$row[0];
	
	
	$query = "SELECT DateSent FROM messages WHERE messageId = '$mid'";
	$result = mysql_query( $query );
	$row=mysql_fetch_row($result);
	

	$finalString = $row[0];
	return $finalString;
}



function checkIfSeen($username, $fusername)
{
	$msg = "You have Unread Message(s).";
	$allRead = "All Messages Are Read.";
	$query = "SELECT lastMessageId, lastMessageSeenId FROM conversations WHERE username='$username' AND fusername = '$fusername'";
	$result = mysql_query( $query );
	$row=mysql_fetch_row($result);
	if($row[0] != $row[1]){
		return $msg;
	}
	else{
		return $allRead;
	}
}

function get_userid($username)
{
	$query = "select userid from account where username='$username'";
	$result = mysql_query( $query );
	$row=mysql_fetch_row($result);
	$name=$row[0];
	return $name;
}
?>