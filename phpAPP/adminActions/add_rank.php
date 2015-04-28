

<html>
	<head>		
		<title>Add Ranking</title>
	</head>
	<body>
		<div align="center">
				</br>

				<p><h3><b>Add/update ranking score for an applicant</b></h3>
					</br>
					</br>
					<form name="add_rank" action= "rank_process.php" method="POST" target=\"_blank\">
						<label for="firstname" name="student" value="Student name">Student Name</label>
						<input type="text" name ="firstname" placeholder="First Name">
						<input type="text" name ="lastname" placeholder="Last Name">
							</br>
							</br>
						<label for="rankscore" value="ranking score">Ranking Score</label>
						<input type="text" name ="rankscore" placeholder="100">
							</br>						
							</br>
						<input type="submit" name="submit" value="Add/Update score">
							</br>
							</br>
							</br>
						<input type="button" value="Return to Admin page" onclick="window.location.href ='../../phpAPP/admin_page.php'">
					</form>
				</p>
		</div>	
	</body>
</html>