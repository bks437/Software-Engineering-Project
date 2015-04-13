<?PHP 		
	//connect to database
		$dbconn = pg_connect("host=dbhost-pgsql.cs.missouri.edu dbname=bks437 user=bks437 password=Cocacola1") or die('Could not connect: ' . pg_last_error());
		session_start();
	
		if(isset($_POST['submit'])){
			$username = $_POST['username'];
			$password = $_POST['password'];

			$result = pg_prepare($dbconn, "auth", 'SELECT * FROM DDL.authentication WHERE username = $1' );
			$result = pg_execute($dbconn, "auth", array($username));
			
			$row = pg_fetch_array($result);
			echo "$row[salt]";
			$pass= ($password.$row[salt]);
			
	//concatenates the salt with the password 
			$passhash = sha1($pass); 
				
	//checks to see if the correct password was entered
			if($passhash == $row[password_hash]){
				$action= "login";
				$ip = $_SERVER['REMOTE_ADDR'];
				
				$result = pg_prepare($dbconn, "ipinsert", 'INSERT INTO DDL.log( username, ip_address, action ) VALUES ( $1, $2, $3 )');
               	$result = pg_execute($dbconn, "ipinsert", array($username, $ip, $action));

	//set session to username		
               	$_SESSION['username'] = $username;
               	header("Location: home.php");
			}
	
	//checks statement
		else{
			echo "<br><div id='invalid'><b>Wrong username or password<b></div>";
		}
	}

	pg_close($dbconn);

?>	
