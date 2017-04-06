<?php
session_start();
//connect to database
$host = 'localhost';
$user  = 'root';
$pass = 'password';
$db = 'test_database';

$con = mysqli_connect($host, $user, $pass, $db);
if ($con)
  echo 'connected successfully to test_database';

$username = "ERIC";
$email = "eric.c0504@gmail.com";
$password = "hihiapapa";

$sql="INSERT INTO users(username,email,password) VALUES('$username','$email','$password')";
mysqli_query($con,$sql);

?>