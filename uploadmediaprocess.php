<?php
session_start();
include_once "function.php";
//include_once "sql.php";
/******************************************************
*
* upload document from user
*
*******************************************************/
$username=$_SESSION['username'];
$title=$_POST['title'];
$keyword=$_POST['keyword'];
$description=$_POST['description'];
$permission=$_POST['permission'];
$category=$_POST['category'];

echo $username;
//Create Directory if doesn't exist
if(!file_exists('uploads/'))
	mkdir('uploads/', 0755);
$dirfile = 'uploads/'.$username.'/';
if(!file_exists($dirfile))
	mkdir($dirfile, 0755);


	if($_FILES["file"]["error"] > 0 )
	{ $result=$_FILES["file"]["error"];} //error from 1-4
	else
	{
	  $upfile = $dirfile.urlencode($_FILES["file"]["name"]);
	  
	  if(file_exists($upfile))
	 {
	  		$result="5"; //The file has been uploaded.
	  }
	  else{
			if(is_uploaded_file($_FILES["file"]["tmp_name"]))
			{
				if(!move_uploaded_file($_FILES["file"]["tmp_name"],$upfile))
				{
					$result="6"; //Failed to move file from temporary directory
				}
				else /*Successfully upload file*/
				{
					//insert into media table
					$type=$_FILES["file"]["type"];
					echo $_FILES["file"]["type"];
					echo $_FILES["file"]["name"];
					
					if(stripos($type,"video")!==false || stripos($type,"application")!==false)
					{
						$thumbnailpath=$dirfile.$_FILES["file"]["name"];
						echo $thumbnailpath;

					}
					else if(stripos($type,"audio")!==false)
					{
						$thumbnailpath="image/audio.jpg";
					
					}

					else if (stripos($type,"image")!==false)
					{
						$thumbnailpath=$dirfile.$_FILES["file"]["name"];
						echo $thumbnailpath;

						
					}
					
				//	$mediaid = mysql_insert_id();

					$insert="INSERT INTO `media`(`filename`, `type`, `title`, `filepath`, `username`, `thumbnailpath`, `description`,`keywords`, `category`, `permission`, `mediaid`) VALUES 
					('". urlencode($_FILES["file"]["name"])."', '".$_FILES["file"]["type"]."','$title','$dirfile','$username','$thumbnailpath','$description','$keyword','$category','$permission', NULL)";
					$queryresult = mysql_query($insert)
						  or die("Insert into Media error in media_upload_process.php " .mysql_error());
					var_dump($insert);
					$result="0";

					
					
					$mediaid = mysql_insert_id();

					$ktypes=array();
					$search=$keyword;
         			$s1 = str_replace("'", '', $search);
         			$s2 = preg_replace('/[^a-zA-Z0-9" "\']/', ' ', $s1);
         			$s2 = preg_replace( "/\s+/", " ", $s2 );
         			$sTerms = strip_tags($s2);
    				$searchTermDB = mysql_real_escape_string($sTerms);
    				$ktypes=explode(" ", $searchTermDB);
    				foreach ($ktypes as &$value)
    				{
    					$query="INSERT into keywords (mediaid,keyword) values('$mediaid','$value')";
    					mysql_query($query);
    				}




					
					$insertUpload="insert into upload(uploadid,username,mediaid) values(NULL,'$username','$mediaid')";
					$queryresult = mysql_query($insertUpload)
						  or die("Insert into view error in media_upload_process.php " .mysql_error());
						  chmod($dirfile.$_FILES["file"]["name"], 0755);
				
				}
			}
			else  
			{
					$result="7"; //upload file failed
			}
		}
	}
	
	//You can process the error code of the $result here.
?>

<meta http-equiv="refresh" content="0;url=uploadmedia.php?result=<?php echo $result;?>">
