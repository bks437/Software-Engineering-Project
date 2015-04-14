<?PHP 
	if(!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']){
		header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	}
?>	
<html>
	<head>		
		<title>CS 3380 Lab 8</title>
	</head>
	<body>
	<div align="center">
		<div id="login">
			<p>Please Register
				<form name="RegistrationProcess" action= "registration.php" method="POST">
				<label for="username">Username:</label>
				<input type="text" name ="username">
				<label for="password">Password:</label>
				<input type="password" name="password">
					<br>
					<br>
				<input type="submit" name="submit" value="Register">
					<br>
					<br>
				<input type="button" name="cancel" value="Click here to return to Login page" onclick="window.location.href ='index.php'">
				</form>
			</p>
		</div>
	</div>	
<?PHP
	//connect to database
		include("test/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
				or die('Could not connect: ' . pg_last_error());

	
	if (isset($_POST['submit'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$ip = $_SERVER['REMOTE_ADDR'];
		//salting and hashing password
		mt_srand();
		$salt = mt_rand();
		$salt = sha1($salt);
		$pass = ($password.$salt);
		$password_hash = sha1($pass);
		$action = "register";
		//inserting username into user_info
		
		$result = pg_prepare($dbconn, "register", "INSERT INTO DDL.user_info (username) VALUES ($1)");
		$result = pg_execute($dbconn, "register", array($username)) or die ("Username already taken");			
			
			if($result){
			//inserting username, password_hash, and salt into authentication table
			$result = pg_prepare($dbconn, "insert", 'INSERT INTO DDL.authentication(username, password_hash, salt) VALUES ($1,$2,$3)');
			$result = pg_execute($dbconn, "insert", array($username, $password_hash, $salt));

			if ($result){
				//inserting data into log table
				$result = pg_prepare($dbconn, "registration", 'INSERT INTO DDL.log( username, ip_address, action ) VALUES ($1,$2,$3)');
	            $result = pg_execute($dbconn, "registration", array($username, $ip, $action));

				if($result){
					//setting session to username and redirecting to home page
					$_SESSION['username'] = $username;
					header("Location: home.php");
				}
				else{
					echo "Please try again";
				}	
			}
			else{
				echo "Please try again";
			}
		}
		else{
			echo"Please try again";
		}
	}	
	pg_close($dbconn);	
?>
	</body>
</html>
