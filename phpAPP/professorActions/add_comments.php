<?php
	session_start();
	//Redirect if user is not logged in to login page
	if(!isset($_SESSION['username']) || $_SESSION["authority"] != "prof"){
		header("Location: ..\..\index.php");
	}

	//get student username
	$username3 = $_GET['username2'];

?>

<html>
<body>

	<!--form to submit comments-->
	<form method="POST" action="comment_process.php">
		<input name="username3" value="<?php echo $username3;?>" />
		<label for="comments">Add/Update comments here:</label>
		<input type="text" name="comments" id="comments" ></input>
		<input type="submit" name="add_comments" value="submit" ></input>
		
	</form>
</body>
</html>

