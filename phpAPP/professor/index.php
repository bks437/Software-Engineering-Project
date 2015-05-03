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
			<h1>Professor Page</h1>
		</div>

		<div class="footer shadowfooter">
			<h4>Copyright &copy; Group G - Computer Science Department</h4>
		</div>

	<!-- Home/Logout -->

		<div class="centerlogout">
			<br>
			<!--<input class="home" type="submit" name="submit" value="Home" onclick="window.location.href ='../phpSQL/index.php'">-->
			<button class="logout" name="submit" value="Logout" onclick="window.location.href ='../../phpSQL/logout.php'">Logout</button>
			<br><br>
		</div>

		<!--request TA for course
				button in generated table to enter entry into request table-->
		<!--view all TA applicants base on selected parameters
				code below-->
	<form method="POST" action="search_result.php">

		<div class="centerplsprof">
			<label class="floatleft" for="courseNumb">View TA/PLA applicants by course number:</label>
			<div class="floatright">
				<select type="text" name="courseNumb" id="courseSearch" size="15">
					<option value="courseNumb">Select</option>
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
				</select>
				<button type="submit" name="CSearch" value="search by course">Search</button>
					<br><br>
			</div>
				<br><br>
			<label class="floatleft" for="applicantName">View applicant by name: </label>
			<div class="floatright">
				<input type="text" name="applicant_fName" id="applicantSearch" size="15" placeholder="First Name"></input>
				<input type="text" name="applicant_lName" id="applicantSearch" size="15" placeholder="Last Name"></input>
				<button type="submit" name="ASearch" value="search by applicant">Search</button>
					<br><br>
			</div>
		</div>
	</form>
</body>
</html>
