<?php
session_start();
include_once "function.php";

$username=$_SESSION['username'];

$query = "SELECT * from contact_list where username='$username' and fusername='$_GET[username]' and status=1";
$result = mysql_query( $query );
$flag=0;
if(mysql_num_rows($result))
{
  $flag=1;
}
else
{
  $flag=0;
}

$query = "SELECT * from contact_list where username='$username' and fusername='$_GET[username]' and status=0";
$result = mysql_query( $query );
if(mysql_num_rows($result))
{
  $flag=2;
}


$query = "SELECT * from account where Username='$_GET[username]'"; 
$result = mysql_query( $query );
if(!$result)
{
  die ("Could not query the media table in the database: <br />". mysql_error());
}
while ($result_row = mysql_fetch_assoc($result))
{
  $uname=$result_row['username'];
  $firstname=$result_row['fname'];
  $lastname=$result_row['lname'];
  $email=$result_row['email'];
  
}
 ?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Metube</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <!--<link href="/metube/css/signin.css" rel="stylesheet"> -->
    <link href="/metube/css/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            
          </button>
          <a class="navbar-brand" href="/metube/homex.php">MeTube - All Media.One Source</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="profile.php">Hello,<?php echo get_firstname($username); ?></a></li>
            <li><a href="uploadmedia.php">Upload</a></li>
            <li><a href="signout.php">Sign out</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </div>


    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="homex.php">Home</a></li>
            <li><a href="profile.php">Profile</a></li>
            <!--<li><button type="button" onclick="playlistfunc()">playlists</button></li>-->
            <li><a href="mymedia.php">My Media</a></li>
            <li><a href="messages.php">Messages</a></li>
            <li><a href="channels.php">Channels</a></li>
            <li><a href="playlists.php">Playlists</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item</a></li>
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
            <li><a href="">More navigation</a></li>
          </ul>
        </div>
      
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="mainframe"> <!--Body Container-->
        <h1 class="page-header"><?php echo $firstname; echo" "; echo $lastname?></h1>
        <span id="Fbutton"><button class="btn btn-primary" id="Fbutton">Request Friend</button></span>
        <button class="btn btn-default">Message</button>
        
        <h3 align="left">Username : <small><?php echo $uname; ?></small></h3>
        <h3 align="left">Email : <small><?php echo $email; ?></small></h3>
        <h3 align="left">Date of Birth : <small><?php echo $dob; ?></small></h3>
        <h3 align="left">Sex : <small><?php echo $sex; ?></small></h3>
        <h3 align="left">About : <small><?php echo $about; ?></small></h3>
      </div>    
      
      </div> <!-- /container -->
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function()
    {
      if(<?php echo $flag; ?> == 1)
      {
        $('#Fbutton').html('<button type="button" class="btn btn-info btn-primary" disabled="disabled">Friend  <span class="glyphicon glyphicon-ok"></span></button>');
      }
      else if (<?php echo $flag; ?> == 2) 
      {
        $('#Fbutton').html('<button type="button" class="btn btn-info btn-success" disabled="disabled">Friend Requested</button>');
      };

      $("#Fbutton").click(function() 
      {
        $('#Fbutton').html('<button class="btn btn-success" id="Fbutton" disabled="disabled">Request Sent!</button>');
        
        var xmlhttp=new XMLHttpRequest();
        xmlhttp.open("GET","sendfriendrequest.php?username=<?php echo $username;?>&fusername=<?php echo $_GET['username'];?>",true);
        xmlhttp.send();

      });
    });
    </script>

  </body>
</html>