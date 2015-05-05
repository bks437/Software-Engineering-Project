<!DOCTYPE html>
<html>
<head>
	<title>CS4320 - Group G</title>
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
	<script src="../../js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="../../js/courses.js"></script>
	<script src="../../js/ajax.js"></script>
</head>
<body>
	<!-- Header/Footer -->

		<div class="header shadowheader">
			<h1>Add a Professor</h1>
		</div>

		<div class="footer shadowfooter">
			<h4>Copyright &copy; Group G - Computer Science Department</h4>
		</div>
<?PHP
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "admin"){
		header("Location: index.php");
	}
	if(!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']){
		header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	}
	if (isset($_POST['submit'])){
		//connect to database
		include("../../connect/database.php");
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
			$result = pg_prepare($dbconn, "faculty", "INSERT INTO DDL.is_a_faculty (username) VALUES ($1)");
			$result = pg_execute($dbconn, "faculty", array($username)) or die (pg_last_error());

			if ($result){
				//inserting data into log table
				$added=true;
				$result = pg_prepare($dbconn, "registration", 'INSERT INTO DDL.log( username, ip_address, action ) VALUES ($1,$2,$3)');
	            $result = pg_execute($dbconn, "registration", array($username, $ip, $action))or die("error");

				if($result){

				}
				else{
					echo "Please try again";
				}
			}
			else{
				echo "Please try again";
			}
		//}
		// else{
		// 	echo"Please try again1";
		// }
	pg_close($dbconn);
	}
?>
	<div class="centerplsaddprof">
		<div id="login">
			<br><br>
		<input type="button" name="cancel" value="Click here to return to Main page" onclick="window.location.href ='index.php'">	
			<br><br>
			<form name="RegistrationProcess" action= "addprofessor.php" method="POST">
				<label class="floatleft" for="fname">First name:</label>
				<input class="floatright" type="text" name="fname" required>
					<br>
				<label class="floatleft" for="lname">Last name: </label>
				<input class="floatright" type="text" name="lname" required>
					<br>
				<label class="floatleft" for="username">Username:</label>
				<input class="floatright" type="text" name ="username" required>
					<br>
				<label class="floatleft" for="password">Password:</label>
				<input class="floatright" type="password" name="password" required>
					<br>
					<br>
				<input type="submit" name="submit" value="Register">
					<br>
					<br>				
				</form>
			<? if($added) echo "Professor added!";?>
		</div>
	</div>
</body>
</html>
