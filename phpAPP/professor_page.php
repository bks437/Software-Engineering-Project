
<!DOCTYPE html>
<html>
<head>
	<title>Professor Page</title>
</head>
<body>

	<form method="POST" action="professorActions/search_result.php">
		<!--request TA for course
				button in generated table to enter entry into request table-->
		<!--view all TA applicants base on selected parameters
				code below-->
		<div>
				<label for="courseNumb" > Enter the course number you would like to see TA applicants: </label>
				<input type="text" name="courseNumb" id="courseSearch" placeholder = "CS1050"></input><br>
				<button type="submit" name="CSearch" value="search by course">Course Search</button><br><br>
		</div>
		<div>
				<label for="applicantName" > Enter the name of applicant you would like to search: </label>
				<input type="text" name="applicant_fName" id="applicantSearch" placeholder = "first name"></input>
				<input type="text" name="applicant_lName" id="applicantSearch" placeholder = "last name"></input><br>
				<button type="submit" name="ASearch" value="search by applicant">Applicant Search</button><br><br>
		</div>
		<!--comment on applicants of their choosing
					button in generated table to add to comment of person-->

		 <!-- Go to homepage -->
		<div >
				<label for="homepage">Go to home page</label><br>
				<input type="submit" name="homepage" value="Go to home page"><br><br></input>
		</div>	
		
	</body>
</html>