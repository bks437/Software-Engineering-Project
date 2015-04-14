<!DOCTYPE html>
<html>
	<head>
		<title>Registration</title>
	</head>
<body>	
	<?php
			session_start();

			//Redirect if user is not logged in to login page
			if(!isset($_SESSION['username'])){
				header("Location: index.php");
			}
			
			//connect to database
			include("test/database.php");
			//if cannot connect return error
			$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
					or die('Could not connect: ' . pg_last_error());
			//prepare and execute query
			$result = pg_prepare($dbconn, "display", 'SELECT DDL.user_info.username, DDL.user_info.registration_date, DDL.log.ip_address, DDL.user_info.description 
								 FROM DDL.user_info INNER JOIN DDL.log USING (username) WHERE action = $1 AND username = $2');
			$result = pg_execute($dbconn, "display", array( "register", $_SESSION['username'])); 

			echo '<div align="center">';
			echo '<p>History for registered user</p>';
			
			//print number of results
				echo "<em>There were " . pg_num_rows($result) . " results returned</em>\n";
				echo '<br>';
				echo '<br>';
				
			//print results from query in table
			echo '<table border=1>';
								echo "<tr><th>Username</th><th>Registration Date</th><th>ip Address</th><th>Description</th></tr>";
								while( $line = pg_fetch_array($result, null, PGSQL_ASSOC)){
									echo "\t<tr>\n";
									foreach( $line as $col_value ){
											echo "\t\t<td>$col_value &nbsp</td>\n";
									}
									echo "\t</tr>\n";
								}
								echo "</table>";
					echo '<br>';
			echo '</div>';

			//Link to update description	
			echo"<div align=\"center\">";
				echo'<a href="update.php">Click here to Update Description</a>';
				echo"</div><br>";

			//prepare and execute query
				$result = pg_prepare($dbconn, "display", 'SELECT DDL.log.username, DDL.log.log_date, DDL.log.ip_address FROM DDL.log WHERE action = $1 AND username = $2');
				$result = pg_execute($dbconn, "display", array( "login", $_SESSION['username']));

			echo '<div align="center">';
			echo '<p>History</p>';
			
			//print number of results
				echo "<em>There were " . pg_num_rows($result) . " results returned</em>\n";
				echo '<br>';
				echo '<br>';
			
			//Print result from query into table
				echo '<table border=1>';
					echo "<tr><th>Username</th><th>Login Date</th><th>IP Address</th><th>Description</th></tr>";
					while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
						echo "\t<tr>\n";
						foreach( $line as $col_value ){
							echo "\t\t<td>$col_value</td>\n";
						}
						echo "\t</tr>\n";
					}
					
			echo "</table>";
			echo '</div>';

			pg_close($dbconn);
	?>

	<br>
	<div align="center">
        <a href="logout.php">Click here to Logout</a><br>
	</div>

</body>
</html>
