
<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "prof"){
		header("Location: ../../index.php");
	}

	//get student username
	$username3 = $_GET['username2'];

?>


<html>
	<head>		
		<title>Add Ranking</title>
	</head>
	<body>
		<div align="center">
			</br>
			</br>
			</br>
			<form name="add_rank" action= "rank_process.php" method="POST">
				<input type='hidden' name="username3" value="<?php echo $username3;?>" />
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