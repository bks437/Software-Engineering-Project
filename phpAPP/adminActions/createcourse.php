<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "applicant"){
		header("Location: ../../index.php");
	}	
	//connect to database
		include("../../connect/database.php");
	//if cannot connect return error
	$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
			or die('Could not connect: ' . pg_last_error());

	if(isset($_POST[submit])){
		if(strlen($_POST[numb])==6){
			if(strlen($_POST[name])>0 && strlen($_POST[name])<32){
					pg_prepare($dbconn,"addcourse",'INSERT INTO DDL.Course(name,numb,professor) VALUES ($1,$2,$3)');
					$insert=pg_execute($dbconn,"addcourse",array($_POST[name],$_POST[numb],$_POST[professor]));

					if (strpos(pg_last_error(), 'exists') !== FALSE)
						   $error="that course already exists";
					elseif(strpos(pg_last_error(), 'not present in table')!==FALSE){
					    $error="professor does not exist please create professor first";
					}
			}
			else{
				$error="course name should be more than 0 and less than 32 character";
				$insert=false;
			}
		}
		else{
			$error="invalid course number";
			echo
			$insert=false;
		}
	}
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
	<form action="createcourse.php" method="POST">
		<label for="numb">Course Number</label>
		<input type="text" name="numb" placeholder="CS1050" required><br>
		<label for="name">Course Name</label>
		<input type="text" name="name" placeholder="Advance Algorithm and Design 1" required><br>
		<select multiple class="niceinput" id="professor" name="professor" required>
			<option selected>Select</option>
		<? 
			$query = 'SELECT P.username,P.fname,P.lname FROM DDL.Person P JOIN DDL.is_a_faculty iaf USING(username) WHERE iaf.admin<>\'y\';';

					$result = pg_query($query) or die('Query failed: '. pg_last_error());
					//displays the results from the database into the table
					while($line=pg_fetch_array($result,null, PGSQL_ASSOC)){
						echo "<option value=\"".$line[username]."\">".$line[fname]." ".$line[lname]."</option>";
						}
						//free the result
					pg_free_result($result);
					?>
		</select><br>
		<input type="submit" name="submit" value="Create">
	</form>
	<button>Go back to Course selection page</button>
	<? 
	if(isset($insert)){
		if(!$insert){
			echo "Entry failed ".$error;
		}
		else
			echo "Successfully added class";
	}
	?>
</body>
</html>

<?
pg_close($dbconn);
?>