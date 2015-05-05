<?php
			session_start();
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "applicant"){
		header("Location: ../index.php");
	}
	include("../connect/database.php");
	//if cannot connect return error
	$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
			or die('Could not connect: ' . pg_last_error());
	$semeterresult=pg_query($dbconn,'SELECT name FROM DDL.Semester WHERE studentstart<current_date AND studentend>current_date')or die('error4 ' . pg_last_error());
	$semester = pg_fetch_array($semeterresult, null, PGSQL_ASSOC);
	echo "<div align=\"center\">";
	if(isset($semester[name])){
		$_SESSION[Semester]=$semester[name];
		if(isset($_POST[submit])){
			pg_prepare($dbconn,"apply",'INSERT INTO DDL.applicant_applies_for_semester(username,semester) VALUES ($1,$2)')or die('error4 ' . pg_last_error());
			$apply=pg_execute($dbconn,"apply",array($_SESSION[username],$_SESSION[Semester]))or die('error4 ' . pg_last_error());
			if($apply==false){
				echo "You failed to apply.";
			}
		}
	}	
	pg_prepare($dbconn,"applied",'SELECT username FROM DDL.applicant_applies_for_semester WHERE username=$1');
 	$result=pg_execute($dbconn,"applied",array($_SESSION[username]));
 	$applied=pg_fetch_array($result, null, PGSQL_ASSOC);	
	?>

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
			<h1>Applicant Information</h1>
		</div>

		<div class="footer shadowfooter">
			<h4>Copyright &copy; Group G - Computer Science Department</h4>
		</div>
		
	<!-- Home/Logout -->

		<div class="centerlogout">
			<br>
			<!--<input class="home" type="submit" name="submit" value="Home" onclick="window.location.href ='../index.php'">-->
			<button class="logout" name="submit" value="Logout" onclick="window.location.href ='../../phpSQL/logout.php'">Logout</button>
			<br><br>
		</div>	
	<?	//TWO SEPERATE PHP TAGS CAUSE I CAN!!!!!!!!!!
		//Redirect if user is not logged in to login page
				pg_prepare($dbconn,"assign",'SELECT * FROM DDL.assigned_to where ta_username=$1')or die('error4 ' . pg_last_error());
				$assign=pg_execute($dbconn,"assign",array($_SESSION[username]))or die('error4 ' . pg_last_error());
				$line=pg_fetch_array($assign, null, PGSQL_ASSOC);
				if(isset($line[ta_username])){
					echo "You have been selected!";
				}
				else{
					echo "selection in process come back soon";
				}
				echo "</div><br>";
			//prepare and execute query
			$user = pg_prepare($dbconn, "name", 'SELECT P.fname, P.lname FROM DDL.Person P WHERE P.username=$1');
			echo "<div align = 'center'>";
			echo "<table  border='0px' width='400px'><tr>";
			$result = pg_execute($dbconn, "name", array($_SESSION['username'])); 
			while( $name = pg_fetch_array($result, null, PGSQL_ASSOC)){
				echo "<td>Name: </td><td>";
				foreach( $name as $col_value ){
						echo "\t\t$col_value &nbsp\n";
				}
				echo "\t</td>\n";
			}
			echo "</tr>";
			$result = pg_prepare($dbconn, "basicinfo", 'SELECT iaa.id, iaa.gpa, iaa.grad_date, iaa.email, iaa.phone FROM DDL.is_an_applicant iaa WHERE iaa.username=$1');
			$result = pg_execute($dbconn, "basicinfo", array($_SESSION['username'])); 
			while( $basicinfo = pg_fetch_array($result, null, PGSQL_ASSOC)){
				foreach( $basicinfo as $i=>$col_value ){
						echo "\t\t<tr> <td>$i: </td><td>$col_value &nbsp\n</td>";
					//echo "\t<br>\n";
					echo "</tr>";
				}
			}

			$result = pg_prepare($dbconn, "isinter",  'SELECT ii.speak, ii.test_date, ii.onita FROM DDL.is_international ii WHERE ii.username=$1');
			$result = pg_execute($dbconn, "isinter", array($_SESSION['username'])); 
			while( $isinter = pg_fetch_array($result, null, PGSQL_ASSOC)){
				foreach( $isinter as $i=>$col_value ){
							echo "\t\t<tr> <td>$i: </td><td>$col_value &nbsp\n</td>";
					//echo "\t<br>\n";
					echo "</tr>";
				}
			}

			$result = pg_prepare($dbconn, "grad", 'SELECT iag.degree, iag.advisor FROM DDL.is_a_grad iag WHERE iag.username=$1');
			$result = pg_execute($dbconn, "grad", array($_SESSION['username'])); 
			while( $grad = pg_fetch_array($result, null, PGSQL_ASSOC)){
				foreach( $grad as $i=>$col_value ){
						echo "\t\t<tr> <td>$i: </td><td>$col_value &nbsp\n</td>";
					//echo "\t<br>\n";
					echo "</tr>";
				}
			}

			$result = pg_prepare($dbconn, "undergrad", 'SELECT iau.degree_program, iau.level FROM DDL.is_an_undergrad iau WHERE iau.username=$1');
			$result = pg_execute($dbconn, "undergrad", array($_SESSION['username'])); 
			while( $undergrad = pg_fetch_array($result, null, PGSQL_ASSOC)){
				foreach( $undergrad as $i=>$col_value ){
						echo "\t\t<tr> <td>$i: </td><td>$col_value &nbsp\n</td>";
					//echo "\t<br>\n";
					echo "</tr>";
				}
			}
			echo "</table>";
			echo"<br>";
			
			pg_prepare($dbconn, "wtt", 'SELECT * FROM DDL.wants_to_teach where ta_username=$1')or die(pg_last_error($dbconn));
			pg_prepare($dbconn,"courses",'SELECT numb, name FROM DDL.Course where c_id=$1')or die('error4 ' . pg_last_error());
			$result =pg_execute($dbconn, "wtt", array($_SESSION[username]));
			echo "<table  border='0px' width='400px'>";
			echo "<tr><th colspan=\"3\"><i><h3>Courses you want to teach</h3></i></th></tr>";
			echo "<tr><th colspan=\"2\"><u>Course</u></th><th><u>Grade</u></th>";
			while ($wtt = pg_fetch_array($result)) {
				$courses = pg_execute($dbconn,"courses",array($wtt[c_id])) or die('error4 ' . pg_last_error());	
				 $course = pg_fetch_array($courses, null, PGSQL_ASSOC);
						echo "\t\t<tr> <td>$course[numb] </td><td>$course[name]</td><td>$wtt[grade]</td>";
					echo "</tr>";
				}
			echo "</table>";
			echo"<br>";
			
			pg_prepare($dbconn, "at", 'SELECT C.numb, C.name FROM DDL.are_teaching at JOIN DDL.Course C USING(c_id) where ta_username=$1')or die(pg_last_error($dbconn));
			
			$result =pg_execute($dbconn, "at", array($_SESSION[username]));

			echo "<table  border='0px' width='400px'>";
			echo "<tr><th colspan=\"2\"><i><h3>Courses you are teaching</h3></i></th></tr>";
			echo "<tr><th colspan=\"2\"><u>Course</u></th>";
			while ($at = pg_fetch_array($result)) {
					echo "\t\t<tr> <td>$at[numb] </td><td>$at[name]</td>";
					echo "</tr>";
				}
				echo "</table>";
				echo "<br><br><br>";
				if(!isset($applied[username])){
					echo "<form action=\"home.php\" method=\"POST\">";
 					echo "<input type=\"submit\" name=\"submit\" value=\"Click here to apply\">";
 					echo "</form>";
 				}
/*
			//$query = "select action, jw.ip_address, jw.log_date from DDL.log jw WHERE jw.username=$1 GROUP BY log_ig ORDER BY log_date DESC";
	
			// $result = pg_prepare($dbconn, "log_data", 'SELECT izz.username, izz.ip_address, izz.log_date FROM DDL.log izz WHERE izz.username=$1');
			// $result = pg_execute($dbconn, "log_data", array($_SESSION['username'])); 
	
			// echo "\nThere were ".pg_num_rows($result)." rows returned";
	
			// echo"<table border='1'><tr>";
			// for($a=0;$a<pg_num_fields($result);$a++){
			// 	echo "<th>" . pg_field_name($result,$a) . "</th>";
			// }
			// echo"\t</tr>\n";

			// while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
			// 	echo "\t<tr>\n";
			// 	foreach($row as $col_value){
			// 		echo "\t\t<td>$col_value</td>\n";
			// 	}
			// }
			// echo "\t</tr>\n";
	
			// echo "</table>\n";
			
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
*/
			pg_close($dbconn);
	?>
</body>
</html>