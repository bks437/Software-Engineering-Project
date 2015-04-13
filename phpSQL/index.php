<!DOCTYPE html>
<html>
	<head>
		<?php
			if(!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']){
				header("Location: https://babbage.cs.missouri.edu/~bks437/cs3380/regis/index.php");
			}
			if($_SESSION['login']=false){
				echo "Failed to login";
			}
			session_start();

		//checks to see if the user is logged in
			if(isset($_SESSION['username'])){
					header("Location: home.php");
			}
		?>
		<title>Login</title>
	</head>
<body>
	<div align="center">
		<div id'"login">
			<p>Please Login			
				<form name="Login" action="process.php" method="POST">
					<input type="hidden" name="action" value="do_login">					
					<label for="username">Username:</label>
					<input type="text" name="username" id="username" value="<?php echo $username; ?>">					
					<label for="password" >Password:   </label>
					<input type="password" name="password" id="password">	
						<br>
						<br>
					<input  type="submit" name="submit" value="Submit">
						<br>
						<br>
					<input type="button" name="Registration" value="Click here to Register" onclick="window.location.href='registration.php'">						
				</form>
			</p>
		</div>
	</div>
</body>
</html>
