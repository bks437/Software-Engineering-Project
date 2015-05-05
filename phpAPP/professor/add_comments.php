<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "prof"){
		header("Location: ../../index.php");
	}
			//connect to database

	include("../../connect/database.php");
		//if cannot connect return error
	$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());
	$semeterresult=pg_query($dbconn,'SELECT name FROM DDL.Semester WHERE facultystart<current_date AND facultyend>current_date')or die('error4 ' . pg_last_error());
	$semester = pg_fetch_array($semeterresult, null, PGSQL_ASSOC);

	if(!isset($semester[name])){
		header("Location: ../../index.php");
	}
	//get student username
	$username3 = $_GET['username2'];

?>

<html>
<head>	
	<title>CS4320 - Group G</title>
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
	<script src="../../js/jquery-1.11.2.min.js"></script>
</head>
<body>
	<!-- Header/Footer -->

		<div class="header shadowheader">
			<h1>Add Comments</h1>
		</div>

		<div class="footer shadowfooter">
			<h4>Copyright &copy; Group G - Computer Science Department</h4>
		</div>

	<!--form to submit comments-->
	<form method="POST" action="comment_process.php">
		<input name="username3" value="<?php echo $username3;?>" />
		<label for="comments">Add/Update comments here:</label>
		<input type="text" name="comments" id="comments" ></input>
		<input type="submit" name="add_comments" value="submit" ></input>
		</br/></br/>
	    <input type="button" value="Close this window" onclick="self.close()">

	</form>
</body>
</html>

