<?php 
session_start();

// initializing variables
	$username = "";
	$password = "";
	$errors = array(); 
// connect to the database
	$db = mysqli_connect('localhost', 'root', '22051998', 'twproiect');

?>