if(isset($_POST['reg_user'])){
		//receive all input values from the form
		$fullname = mysqli_real_escape_string($db,$_POST['fullname']);
		$email = mysqli_real_escape_string($db,$_POST['email']);
		$city = mysqli_real_escape_string($db,$_POST['city']);
		$password_1 = mysqli_real_escape_string($db,$_POST['password']);
		$cpassword = mysqli_real_escape_string($db,$_POST['repeatpass']);
		
		// form validation: ensure that the form is correctly filled ...
		// by adding (array_push()) corresponding error unto $errors array
		if(empty($fullname)) { array_push($errors,"Trebuie sa introduceti numele.");}
		if(empty($email)) { array_push($errors,"Trebuie sa introduceti email-ul.");}
		if(empty($city)) { array_push($errors,"Trebuie sa introduceti localitatea.");}
		if(empty($password_1)) { array_push($errors,"Trebuie sa introduceti parola.");}
		if($password != $cpassword ) { array_push($errors , "Cele doua parole nu coincid.");}
		
		if(strlen($password) < 6) {array_push($errors, "Parola trebuie sa aiba cel putin 6 caractere!");}
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){array_push($errors,"Introduceti un email valid!");}
		if(!preg_match("/^[a-zA-Z ]+$/",$fullname)){array_push($errors,"Full name trebuie sa contina doar litere si spatii");}
		if(!preg_match("/^[a-zA-Z -]+$/",$localitate)){array_push($errors,"Localitatea  trebuie sa contina doar litere ,spatii sau cratima");}
		
		//first ceck the database to make sure
		//a user does not already exist with the same username
		$user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
		$result = mysqli_query ($db , $user_check_query);
		$user = mysqli_fetch_assoc($result);
		
		if($user){ //if user exists
			if($user['email'] === $email){
				array_push($errors , "Email-ul a fost utilizat");}
			}
			
		//Finally , register user is there are no errors in the form
		if(!count($errors)){
			$password = base64_encode($password_1); //encrypt the password before saving in database
			$query="INSERT INTO users ( nume,prenume,username,email,localitate,parola)
					VALUES ('$nume','$prenume','$username','$email','$localitate','$password')";
			mysqli_query($db, $query);
			$q = "SELECT user_id FROM USERS WHERE username='$username'";
			$rw=mysqli_query($db,$q);
			$ras=mysqli_fetch_array($rw,MYSQLI_ASSOC);
			$idd=$ras['user_id'];
			$qq="INSERT INTO user_role (user_id,role_id) values ('$idd',2)";
			mysqli_query($db,$qq);
			$success_message = "<center>V-ati inregistrat cu succes! Acum va puteti loga.  
									<a href='login.php'>Login </a></center>";
			}
	}