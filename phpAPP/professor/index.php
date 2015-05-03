
<!DOCTYPE html>
<html>
<head>
	<title>CS4320 - Group G</title>
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
	<script src="../../js/jquery-1.11.2.min.js"></script>
</head>
<body>
	<form method="POST" action="professorActions/search_result.php">
	
	<!-- Header/Footer -->

		<div class="header shadowheader">
			<h1>Professor Page</h1>
		</div>

		<div class="footer shadowfooter">
			<h4>Copyright &copy; Group G - Computer Science Department</h4>
		</div>
	
	<!-- Home/Logout -->
	
		<div class="centerlogout">
			<br>
			<!--<input class="home" type="submit" name="submit" value="Home" onclick="window.location.href ='../phpSQL/index.php'">-->
			<input class="logout" type="submit" name="submit" value="Logout" onclick="window.location.href ='../../phpSQL/logout.php'">
			<br><br>
		</div>
	
		<!--request TA for course
				button in generated table to enter entry into request table-->
		<!--view all TA applicants base on selected parameters
				code below-->
				
		<div class="centerplsprof">
			<label class="floatleft" for="courseNumb">View TA/PLA applicants by course number:</label>
			<div class="floatright">
				<input type="text" name="courseNumb" id="courseSearch" placeholder="CS1050"></input>
				<button type="submit" name="CSearch" value="search by course">Search</button>
					<br><br>
			</div>
				<br><br>
			<label class="floatleft" for="applicantName">View applicant by name: </label>
			<div class="floatright">
				<input type="text" name="applicant_fName" id="applicantSearch" placeholder="First Name"></input>
				<input type="text" name="applicant_lName" id="applicantSearch" placeholder="Last Name"></input>
				<button type="submit" name="ASearch" value="search by applicant">Search</button>
					<br><br>
			</div>
		</div>		
	</form>
</body>
</html>