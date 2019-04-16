<?php

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['uname']);
  $password = mysqli_real_escape_string($db, $_POST['psw']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM users 
				join user_role on user_role.user_id=users.user_id
				join roles on roles.role_id=user_role.role_id
				WHERE username='$username' AND parola='$password'";
  	$results = mysqli_query($db, $query);
	$q="SELECT user_id FROM users where username='$username'";
	$res = mysqli_query($db,$q);
	$r = mysqli_fetch_array($res,MYSQLI_ASSOC);
	if( empty($_POST["remember"]) ) {array_push($errors,"Checkbox left unchecked"); }
	if (mysqli_num_rows($results) == 1) {
	$_SESSION['username'] = $username;
	$_SESSION['success'] = "Te-ai logat!";
	$id = $r['user_id'];
	$que="UPDATE users 
			SET log_in=$id 
			WHERE username='$username'";
	mysqli_query($db,$que);
	header('location:profile.php');
  	} else {
  		array_push($errors, "Username sau parola gresita.");
  	}
  }
  


	$_SESSION['succes']="V-ati logat cu succes";
	$id = $r['user_id'];
}

//LOG OUT
if (isset($_SESSION['log_out']))
{
    $que="UPDATE users 
			SET log_in=NULL 
			WHERE username='$username'";
	  mysqli_query($db,$que);
	  session_destroy();

header('Location: login.php');
}
?>	