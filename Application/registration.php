<?PHP 
	session_start();

	if(!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']){
		header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	}
	if (isset($_POST['submit'])){
		//connect to database
		include("../connect/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
				or die('Could not connect: ' . pg_last_error());
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
		
					
			
			//if($result){
			//inserting username, password_hash, and salt into authentication table
			$result = pg_prepare($dbconn, "insert", 'INSERT INTO DDL.Login(username, password_hash, salt) VALUES ($1,$2,$3)') or die(pg_last_error());
			$result = pg_execute($dbconn, "insert", array($username, $password_hash, $salt)) or die("Username alread taken ". pg_last_error());
			
			$result = pg_prepare($dbconn, "register", "INSERT INTO DDL.Person (username,fname,lname) VALUES ($1,$2,$3)");
			$result = pg_execute($dbconn, "register", array($username,$_POST['fname'],$_POST['lname'])) or die (pg_last_error());

			if ($result){
				//inserting data into log table
				$result = pg_prepare($dbconn, "registration", 'INSERT INTO DDL.log( username, ip_address, action ) VALUES ($1,$2,$3)');
	            $result = pg_execute($dbconn, "registration", array($username, $ip, $action))or die("error");

				if($result){
					//setting session to username and redirecting to home page
					$_SESSION['username']=$username;
					$_SESSION["authority"] = "applicant";
					header("Location: basicinfo.php");
				}
				else{
					echo "Please try again3";
				}	
			}
			else{
				echo "Please try again2";
			}
		//}
		// else{
		// 	echo"Please try again1";
		// }
	pg_close($dbconn);	
	}	
?>	
<html>
<head>		
	<title>CS4320 - Group G</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">	
	<script src="../js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="../js/courses.js"></script>
	<script src="../js/ajax.js"></script>
</head>
<body>
		<!-- Header/Footer -->
			
			<div class="header shadowheader">			
				<h1>Please Register</h1>		
			</div>			
			
			<div class="footer shadowfooter">			
				<h4>Copyright &copy; Group G - Computer Science Department</h4>		
			</div>	
		
		<!-- Home/Logout -->
	
		<div class="centerhomelogout">
			<br>
			<!--<input class="home" type="submit" name="submit" value="Home" onclick="window.location.href ='../phpSQL/home.php'">-->
			<input class="logout" type="submit" name="submit" value="Logout" onclick="window.location.href ='../phpSQL/logout.php'">
		</div>
		
		<!-- Registration -->
		
	<form name="RegistrationProcess" action= "registration.php" method="POST">	
		<div class="centerplsreg">
			<div id="login"> <!-- do we need this id?? -->
				<p>				
					<label class="floatleft" for="fname">First name:</label>
					<input class="floatright" type="text" name="fname">
				</p>
					<br>
				<p>
					<label class="floatleft" for="lname">Last name: </label>
					<input class="floatright" type="text" name="lname">							
				</p>		
					<br>
				<p>				
					<label class="floatleft" for="username">Username:</label>
					<input class="floatright" type="text" name ="username">
				</p>
					<br>
				<p>
					<label class="floatleft" for="password">Password:</label>
					<input class="floatright" type="password" name="password">
				</p>		
			</div>
		</div>
			<br>
			<br>
			<br>
		<div style="text-align: center">
			<input type="submit" name="submit" value="Register">
			<input type="button" name="cancel" value="Click here to return to Login page" onclick="window.location.href ='index.php'">
		</div>				
	</form>	
</body>
</html>
