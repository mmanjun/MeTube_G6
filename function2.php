<?php
include "mysqlClass.inc.php";


function user_exist_check ($username, $password, $fname, $lname, $birthdate, $type){
	$query = "select * from account where username='$username'";
	$result = mysql_query( $query );
	if (!$result){
		die ("user_exist_check() failed. Could not query the database: <br />". mysql_error());
	}	
	else {
		$row = mysql_fetch_assoc($result);
		if($row == 0){
			$query = "insert into account values ('$username','$password', NULL, NULL, '$type', '$birthdate', '$fname', '$lname')";
			echo "insert query:" . $query;
			$insert = mysql_query( $query );
			if($insert)
				return 1;
			else
				die ("Could not insert into the database: <br />". mysql_error());		
		}
		else{
			return 2;
		}
	}
}

function user_update ($username, $password, $fname, $lname, $birthdate, $type){
	$query = "select * from account where username='$username'";
	$result = mysql_query( $query );
	if (!$result){
		die ("user_exist_check() failed. Could not query the database: <br />". mysql_error());
	}	
	else {
		$row = mysql_fetch_assoc($result);
		if($row == 0){
			
			$query = "UPDATE account
				SET password='$password',fname='$fname',lname='$lname'
				WHERE username='$username'"	
			echo "update query:" . $query;
			$update = mysql_query( $query );
			if($update)
				return 1;
			else
				die ("Could not update into the database: <br />". mysql_error());		
		}
		else{
			return 2;
		}
	}
}

function prefil_form ( $username, $fname) {
	$query = "select * from account where username = '$username'";
	$result =  mysql_query($query);
	$row = mysql_fetch_row($result);
	strcpy($row[1], $fname)
}

function user_pass_check($username, $password)
{
	
	$query = "select * from login where username='$username'";
	//echo  $query;
	$result = mysql_query( $query );		
	if (!$result)
	{
	   die ("user_pass_check() failed. Could not query the database: <br />". mysql_error());
	}
	else{
		$row = mysql_fetch_row($result);
		if($row[0]=="")
			return 1; //no user name
		else if(strcmp($row[1],$password)) 
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
	
?>
