<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "applicant"){
		header("Location: ../index.php");
	}	
	//connect to database
	include("../connect/database.php");
			//include("test/database.php");

	//if cannot connect return error
	$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
			or die('Could not connect: ' . pg_last_error());

	//if data has been submitted
	/*
	 if(isset($_POST['submit'])){
	 	if(strcmp($_SESSION['grad'],"ta")==0){
	 		pg_prepare($dbconn, 'grad', 'INSERT INTO DDL.is_a_grad values($1,$2,$3)');
	 		$result = pg_execute($dbconn, 'grad', array($_SESSION['username'],$_POST[gradpro],$_POST[advisor])); 
	 	}
	 	elseif(strcmp($_SESSION['grad'],"pla")==0){
	 		pg_prepare($dbconn, 'ungrad', 'INSERT INTO DDL.is_an_undergrad values($1,$2,$3)') or die('Could not connect: ' . pg_last_error());;
	 		$result = pg_execute($dbconn, 'ungrad', array($_SESSION['username'],$_POST[program],$_POST[year]))or die('Could not connect: ' . pg_last_error());; 
	 	}
	 	if($result==false){
	 		$_SESSION[insert]=false;
	 	}
	 	else
	 		header("Location: courses.php");
	
	}*/
?>

<!DOCTYPE html>
<html>
	<!--ADD ANY USEFUL TIPS, otherwise ... DO NOT FUCK WITH THE COMMENTS. please and thank you.-->
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
			<h1>Step 4: Courses</h1>		
		</div>			
		
		<div class="footer shadowfooter">			
			<h4>Copyright &copy; Group G - Computer Science Department</h4>		
		</div>		
		
	<!-- Home/Logout -->
	
		<div class="centerlogout">
			<br>
			<!--<input class="home" type="submit" name="submit" value="Home" onclick="window.location.href ='../phpSQL/home.php'">-->
			<input class="logout" type="submit" name="submit" value="Logout" onclick="window.location.href ='../phpSQL/logout.php'">
		</div>
	
	<!-- Courses -->
		
		<div class="centerplscourses">
			<p>
				<label class="floatleft" for="courseteaching" >Course(s) You Are Currently Teaching: </label>
				<!-- 	<select multiple class="niceinput" id="cteach" name="cteach">
						<option value="cteach" selected>Select</option>
						<option value="cs1050">CS1050</option>
						<option value="cs2050">CS2050</option>
						<option value="cs2830">CS2830</option>
						<option value="cs3050">CS3050</option>
						<option value="cs3330">CS3330</option>
						<option value="cs3380">CS3380</option>
						<option value="cs3530">CS3530</option>
						<option value="cs4320">CS4320</option>
						<option value="cs4380">CS4380</option>
						<option value="cs4610">CS4610</option>
						<option value="cs4830">CS4830</option>
					</select> -->		
					<? $query = 'SELECT c_id,name,numb FROM DDL.Course;';

					$result = pg_query($query) or die('Query failed: '. pg_last_error());
					$maxfield=pg_num_fields($result);
					//gets number of rows returned by the result
					$rows=pg_num_rows($result);
					//displays the header for the table
					echo "<br>";
					//for($field=0;$field<$maxfield;$field++) {
						$header=pg_field_name($result, 0);
						echo "\t\t<div class=\"name\"><b> Course Name</b></div>\n";
						//}
						$header=pg_field_name($result, 1);
						echo "\t\t<div class=\"numb\"><b>Number</b></div>\n";
					//echo "<br>";
					echo "<br>";
					//displays the results from the database into the table
					while($line=pg_fetch_array($result,null, PGSQL_ASSOC)){
						//foreach ($line as $col_value){
								echo "<div class=\"coursewidth1\" id=\"Teaching".$line[c_id]."\">";
								echo "\t\t<div class=\"name\">$line[name]</div>\n";	
								echo "\t\t<div class=\"numb\">$line[numb]</div>\n";		
							//}
								echo "<button class=\"button courseml\" onclick=\"addcourse('$line[c_id]','Teaching')\">Add</button>";
								echo "<button class=\"button courseml\" onclick=\"removecourse('$line[c_id]','Teaching')\">Remove</button></div>";
							echo "\t<br>\n";
						}
						//free the result
					pg_free_result($result);
					?>		
					<br>
			</p>
			<p>
				<label class="floatleft" for="prevtaught">Course(s) You Have Previously Taught: </label>
					<!-- <select multiple class="niceinput" id="prevtaught" name="prevtaught">
						<option value="prevtaught" selected>Select</option>
						<option value="cs1050">CS1050</option>
						<option value="cs2050">CS2050</option>
						<option value="cs2830">CS2830</option>
						<option value="cs3050">CS3050</option>
						<option value="cs3330">CS3330</option>
						<option value="cs3380">CS3380</option>
						<option value="cs3530">CS3530</option>
						<option value="cs4320">CS4320</option>
						<option value="cs4380">CS4380</option>
						<option value="cs4610">CS4610</option>
						<option value="cs4830">CS4830</option>
					</select>	 -->
					<? $query = 'SELECT c_id,name,numb FROM DDL.Course;';

					$result = pg_query($query) or die('Query failed: '. pg_last_error());
					$maxfield=pg_num_fields($result);
					//gets number of rows returned by the result
					$rows=pg_num_rows($result);
					//displays the header for the table
					echo "<br>";
					//for($field=0;$field<$maxfield;$field++) {
						$header=pg_field_name($result, 0);
						echo "\t\t<div class=\"name\"><b> Course Name</b></div>\n";
						//}
						$header=pg_field_name($result, 1);
						echo "\t\t<div class=\"numb\"><b>Number</b></div>\n";
					//echo "<br>";
					echo "<br>";
					//displays the results from the database into the table
					while($line=pg_fetch_array($result,null, PGSQL_ASSOC)){
						//foreach ($line as $col_value){
								echo "<div class=\"coursewidth2\" id=\"Taught".$line[c_id]."\">";
								echo "\t\t<div class=\"name\">$line[name]</div>\n";	
								echo "\t\t<div class=\"numb\">$line[numb]</div>\n";		
							//}
								echo "<button class=\"button courseml\" onclick=\"addcourse('$line[c_id]','Taught')\">Add</button>";
								echo "<button class=\"button courseml\" onclick=\"removecourse('$line[c_id]','Taught')\">Remove</button></div>";
							echo "\t<br>\n";
						}
						//free the result
					pg_free_result($result);
					?>
					<div id="selected"></div>
				<br>
			</p>
			<p>
				<label class="floatleft" for="lteach">Course(s) You Would Like to Teach; include grades received: </label>
				<label class="floatleft smallcourse" for="lteach">(Must have taken course previously)</label>
					<br>
					<!-- <select multiple class="niceinput" id="lteach" name="lteach">
						<option value="lteach" selected>Select</option>
						<option value="cs1050">CS1050</option>
						<option value="cs2050">CS2050</option>
						<option value="cs2830">CS2830</option>
						<option value="cs3050">CS3050</option>
						<option value="cs3330">CS3330</option>
						<option value="cs3380">CS3380</option>
						<option value="cs3530">CS3530</option>
						<option value="cs4320">CS4320</option>
						<option value="cs4380">CS4380</option>
						<option value="cs4610">CS4610</option>
						<option value="cs4830">CS4830</option>
					</select> -->

					<? $query = 'SELECT c_id,name,numb FROM DDL.Course;';

					$result = pg_query($query) or die('Query failed: '. pg_last_error());
					$maxfield=pg_num_fields($result);
					//gets number of rows returned by the result
					$rows=pg_num_rows($result);
					//displays the header for the table
					echo "</p><br>";
					//for($field=0;$field<$maxfield;$field++) {
						$header=pg_field_name($result, 0);
						echo "\t\t<div class=\"name\"><b> Course Name</b></div>\n";
						//}
						$header=pg_field_name($result, 1);
						echo "\t\t<div class=\"numb\"><b>Number</b></div>\n";
					//echo "<br>";
					echo "<br>";
					//displays the results from the database into the table
					while($line=pg_fetch_array($result,null, PGSQL_ASSOC)){
						//foreach ($line as $col_value){
								echo "<div class=\"coursewidth3\" id=\"Wants".$line[c_id]."\">";
								echo "\t\t<div class=\"name\">$line[name]</div>\n";	
								echo "\t\t<div class=\"numb\">$line[numb]</div>\n";		
							//}
								echo "<select class=\"courseml\" multiple id=$line[c_id] name=\"lgrade\">
									<option value=\"A\" selected>A</option>
									<option value=\"B\">B</option>
									<option value=\"C\">C</option>
									<option value=\"D\">D</option>
									<option value=\"F\">F</option>
								</select>";
							echo "<button class=\"button courseml\" onclick=\"addcourse('$line[c_id]','Wants')\">Add</button>";
							echo "<button class=\"button courseml\" onclick=\"removecourse('$line[c_id]','Wants')\">Remove</button></div>";
							echo "\t<br>\n";
						}
						//free the result
					pg_free_result($result);
					?>
		</div>	
	
	<!-- Next Page -->

		<div class="centerpls">
			<br>
			<p class="floatright" id="click">
				<input type="submit" name="submit" value="Finish Application" onclick="window.location.href ='../phpSQL/home.php'">
				<br>
				<br>
			</p>			
		</div>
			<br>
			<br>
			<br>
			<br>
	</body>
</html>
<? pg_close($dbconn);?>