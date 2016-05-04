<link rel="stylesheet" type="text/css" href="css/default.css" />
<?php
session_start();
session_destroy();
?>

	<html>
	<head>
	<title>Basic Logout Script</title>


	</head>
	<body>

	You are logged out.
	<?php
	sleep(1);
	header('Location: login.php');
	?>
	</body>
	</html>