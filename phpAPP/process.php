<!DOCTYPE html>
<html>
<head>
	<title>CS4320 - Group G</title>
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
	<script src="../../js/jquery-1.11.2.min.js"></script>
</head>
<body>
	<!-- Header/Footer -->

		<div class="header shadowheader">
			<h1>Please Try Again</h1>
		</div>

		<div class="footer shadowfooter">
			<h4>Copyright &copy; Group G - Computer Science Department</h4>
		</div>
		
	<!-- Home/Logout -->

		<div class="centerlogout">
			<br>
			<input class="home" type="submit" name="submit" value="Home" onclick="window.location.href ='../index.php'">
			<!--<button class="logout" name="submit" value="Logout" onclick="window.location.href ='../../phpSQL/logout.php'">Logout</button>-->
			<br><br>
		</div>	
<?PHP
		session_start();

		if(isset($_POST['submit'])){
	//connect to database
		include("../connect/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
				or die('Could not connect: ' . pg_last_error());
			$username = $_POST['username'];
			$password = $_POST['password'];

			$result = pg_prepare($dbconn, "auth", 'SELECT * FROM DDL.Login WHERE username = $1' );
			$result = pg_execute($dbconn, "auth", array($username));

			$row = pg_fetch_array($result);
			//echo "$row[salt]";
			$pass= ($password.$row[salt]);

	//concatenates the salt with the password
			$passhash = sha1($pass);

	//checks to see if the correct password was entered
			if($passhash == $row[password_hash]){
				$action= "login";
				$ip = $_SERVER['REMOTE_ADDR'];

				$result = pg_prepare($dbconn, "ipinsert", 'INSERT INTO DDL.log( username, ip_address, action ) VALUES ( $1, $2, $3 )');
               	$result = pg_execute($dbconn, "ipinsert", array($username, $ip, $action)) or die('Query failed: '. pg_last_error());

	//set session to username
               	$_SESSION['username'] = $username;
               	//check if user is not a faculty
               	pg_prepare($dbconn,"applicant",'SELECT iaf.username, iaf.admin FROM DDL.is_a_faculty iaf WHERE iaf.username = $1')or die('Query failed: '. pg_last_error());
               	$result = pg_execute($dbconn,"applicant",array($username));
               	$line=pg_fetch_assoc($result);
               	// echo $line['iaf.sso'];
               	//user was found in faculty table
       			pg_close($dbconn);

               	if(isset($line["username"])){
               		//if faculty is the admin
               		if($line["admin"]=='y'){
               			$_SESSION["authority"] = "admin";
               			header("Location: admin");
               		}
               		else{
               			$_SESSION["authority"] = "prof";
               			header("Location: professor");
               		}
               	}
               	//if logined in user is not a faculty
               	else{
               		$_SESSION["authority"] = "applicant";
               		header("Location: ../phpSQL/home.php");
               	}
			}
	//checks statement
		else{
			echo "<br><div align=\"center\"><div id='invalid'><b>Wrong username or password<b></div></div>";
			header("../index.php");
		}
		pg_close($dbconn);
	}
?>
</body>
</html>