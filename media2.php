<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
	include_once "function.php";
?>	
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media</title>
<script src="Scripts/AC_ActiveX.js" type="text/javascript"></script>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

<body>
<?php
if(isset($_GET['id'])) {
	$query = "SELECT * FROM media WHERE mediaid='".$_GET['id']."'";
	$result = mysql_query($query);
	$result_row = mysql_fetch_row($result);
	
//	$cursor = mysql_query($searchroute); // for example
//	$result = mysql_fetch_row($cursor); 
	
	//updateMediaTime($_GET['id']);
	
	$filename=$result_row[0];   ////0, 4, 2
	$filepath=$result_row[3]; 
	$type=$result_row[1];
	$type2='.mp4';
	if(substr($type,0,5)=="image") //view image
	{
		echo "Viewing Picture:";
		echo $result_row[1]; // changing from 4 to image
		echo "<img src='".$filepath."'/>";
		
		echo '<img src="./' . $filepath . '" />';
		
	//	echo '<ul><img src='images.jpg' alt='".$filepath."'/></ul>';
	
	}
	else //view movie
	{	
?>
	<!-- <p>Viewing Video:<?php echo $result_row[2].$result_row[1];?></p> -->
	<p>Viewing Video:<?php echo $result_row[3];?></p>
	      
	
    <object id="MediaPlayer" width=320 height=286 classid="CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95" standby="Loading Windows Media Player components…" type="application/x-oleobject" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112">
    <param name="filename" value="<?php echo $result_row[3];?>">
	<!-- echo $result_row[2].$result_row[1];  -->
	<param name="Showcontrols" value="True">
	<param name="autoStart" value="True">
	<embed type="application/x-mplayer2" src="<?php echo '$filepath';  ?>" name="MediaPlayer" width=320 height=240></embed>

		  
	
	

</object>

          
          
          
       
              
<?php
	}
}
else
{
?>
<meta http-equiv="refresh" content="0;url=browse.php">
<?php
}
?>
</body>
</html>
