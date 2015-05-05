
<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "admin"){
		header("Location: ../../index.php");
	}
	//connect to database
	include("../../connect/database.php");
	//if cannot connect return error
	$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
			or die('Could not connect: ' . pg_last_error());
	pg_prepare($dbconn,"user",'SELECT fname,lname FROM DDL.Person WHERE username=$1');
	$result=pg_execute($dbconn,"user",array($_GET[username]));
	$name=pg_fetch_array($result, null, PGSQL_ASSOC);

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
			<h1>Add Ranking</h1>
		</div>

		<div class="footer shadowfooter">
			<h4>Copyright &copy; Group G - Computer Science Department</h4>
		</div>
		
		<div align="center">
			<br>
			<br>
			<br>
			<h3><? echo $name[fname]." ".$name[lname]?></h3>
			<form name="add_rank" action= "rank_process.php" method="POST">
				<input type='hidden' name="username3" value="<?php echo $_GET[username];?>" />
				<label for="rankscore" value="ranking score">Ranking Score</label>
				<input type="text" name ="rankscore" placeholder="100">
					</br>
					</br>
				<input type="submit" name="submit" value="Add/Update score">
					</br>
					</br>
					</br>
					</br>
					</br>
					<input type="button" value="Close this window" onclick="self.close()">
			</form>
		</div>
	</body>
</html>
