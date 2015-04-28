<?php
			session_start();
			if(!isset($_SESSION['username'])){
				header("Location: index.php");
			}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Registration</title>
	</head>
<body>	

	<? //Redirect if user is not logged in to login page
			
			//connect to database
		include("../connect/database.php");
		//if cannot connect return error
		$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
				or die('Could not connect: ' . pg_last_error());

			//prepare and execute query
			$user = pg_prepare($dbconn, "name", 'SELECT P.fname, P.lname FROM DDL.Person P WHERE P.username=$1');
			echo "<div align = 'center'>";
			$result = pg_execute($dbconn, "name", array($_SESSION['username'])); 
			while( $name = pg_fetch_array($result, null, PGSQL_ASSOC)){
				foreach( $name as $col_value ){
						echo "\t\t$col_value &nbsp\n";
				}
				echo "\t<br>\n";
			}
			
			$result = pg_prepare($dbconn, "basicinfo", 'SELECT iaa.id, iaa.gpa, iaa.grad_date, iaa.email, iaa.phone FROM DDL.is_an_applicant iaa WHERE iaa.username=$1');
			$result = pg_execute($dbconn, "basicinfo", array($_SESSION['username'])); 
			while( $basicinfo = pg_fetch_array($result, null, PGSQL_ASSOC)){
				foreach( $basicinfo as $col_value ){
						echo "\t\t$col_value &nbsp\n";
				}
				echo "\t<br>\n";
			}

			$result = pg_prepare($dbconn, "isinter",  'SELECT ii.speak, ii.test_date, ii.onita FROM DDL.is_international ii WHERE ii.username=$1');
			$result = pg_execute($dbconn, "isinter", array($_SESSION['username'])); 
			while( $isinter = pg_fetch_array($result, null, PGSQL_ASSOC)){
				foreach( $isinter as $col_value ){
						echo "\t\t$col_value &nbsp\n";
				}
				echo "\t<br>\n";
			}

			$result = pg_prepare($dbconn, "grad", 'SELECT iag.degree, iag.advisor FROM DDL.is_a_grad iag WHERE iag.username=$1');
			$result = pg_execute($dbconn, "grad", array($_SESSION['username'])); 
			while( $grad = pg_fetch_array($result, null, PGSQL_ASSOC)){
				foreach( $grad as $col_value ){
						echo "\t\t$col_value &nbsp\n";
				}
				echo "\t<br>\n";
			}

			$result = pg_prepare($dbconn, "undergrad", 'SELECT iau.degree_program, iau.level FROM DDL.is_an_undergrad iau WHERE iau.username=$1');
			$result = pg_execute($dbconn, "undergrad", array($_SESSION['username'])); 
			while( $undergrad = pg_fetch_array($result, null, PGSQL_ASSOC)){
				foreach( $undergrad as $col_value ){
						echo "\t\t$col_value &nbsp\n";
				}
				echo "\t<br>\n";
			}




			echo '<div align="center">';
			$query1="SELECT wj.log_date, wj.ip_address FROM DDL.log wj WHERE wj.username=$1 GROUP BY log_id ";
			pg_prepare($dbconn, 'ip', $query1);
			$result1 = pg_execute($dbconn, 'ip', array($user)) or die ('wrong: ' . pg_last_error());
			$info=pg_fetch_array($result1, null, PGSQL_ASSOC);
			echo "<p>Ip Address: ".$info['ip_address']."</p>\n";
			echo "<p>Registration date: ".$info['log_date']."</p>\n";
	
			$query = "select action, jw.ip_address, jw.log_date from DDL.log jw WHERE jw.username=$1 GROUP BY log_ig ORDER BY log_date DESC";
			
			
			echo "\nThere were ".pg_num_rows($result)." rows returned";
	
			$result = pg_prepare($dbconn, "log_data", 'SELECT izz.username, izz.ip_address, izz.log_date FROM DDL.log izz WHERE izz.username=$1');
			$result = pg_execute($dbconn, "log_data", array($_SESSION['username'])); 
	
	
			echo"<table border='1'><tr>";
			for($a=0;$a<pg_num_fields($result);$a++){
				echo "<th>" . pg_field_name($result,$a) . "</th>";
			}
			echo"\t</tr>\n";

			while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
				echo "\t<tr>\n";
				foreach($row as $col_value){
					echo "\t\t<td>$col_value</td>\n";
				}
			}
			echo "\t</tr>\n";
	
			echo "</table>\n";
			
/*			//print number of results
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
*/
			pg_close($dbconn);
	?>

	<br>
	<div align="center">
		<p><a href="update.php">Click</a> to update page.</p>
        <p><a href="logout.php">Click here to Logout</a></p>
	</div>

</body>
</html>
