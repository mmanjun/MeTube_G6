<?php
session_start();
include_once "function.php";

$username=$_SESSION['username'];
$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$email=$_POST['email'];
$dob=$_POST['dob'];
$query= "UPDATE `account` SET `birthdate`='$dob',`fname`='$firstname',`lname`='$lastname',`email`='$email' WHERE `username`='$username'";
$result=mysql_query($query);
header('Location: profile.php');
?>
