<!DOCTYPE html>
<html>
	<head>
		<?php
			if(!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']){
				header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			}
			if($_SESSION['login']=false){
				echo "Failed to login";
			}
			session_start();

		//checks to see if the user is logged in
			if(isset($_SESSION['username'])){
				if($_SESSION["authority"] == "admin"){
					header("Location: phpAPP/admin_page.php");
				}
				elseif($_SESSION["authority"] == "prof"){
					header("Location: phpAPP/professor_page.php");
				}
				elseif($_SESSION["authority"] == "applicant"){
					header("Location: phpSQL/home.php");			
				}
			}
		?>
		<title>CS4320 - Group G</title>
		<link rel="stylesheet" type="text/css" href="/css/style.css">	
		<script src="/js/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="/js/courses.js"></script>
		<script src="/js/ajax.js"></script>
	</head>
<body>
	<!-- Header/Footer -->
		
		<div class="header shadowheader">			
			<h1>Please Login</h1>		
		</div>			
		
		<div class="footer shadowfooter">			
			<h4>Copyright &copy; Group G - Computer Science Department</h4>		
		</div>	
			<br>
			
		<form name="Login" action="phpAPP/process.php" method="POST">	
			<div class="centerplsindex">
				<p>				
					<input type="hidden" name="action" value="do_login">					
					<label class="floatleft" for="username">Username:</label>
					<input class="floatright" type="text" name="username" id="username" value="<?php echo $username; ?>">		
				</p>
					<br>
				<p>
					<label class="floatleft" for="password" >Password:   </label>
					<input class="floatright" type="password" name="password" id="password">							
				</p>		
					<br>
			</div>
				<br>
			<div class="centerbuttonsindex">
					<input type="submit" name="submit" value="Submit">
					<input type="button" name="Registration" value="Click here to Register" onclick="window.location.href='Application/registration.php'">			
			</div>
		</form>
</body>
</html>
