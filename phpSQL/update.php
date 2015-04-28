<!DOCTYPE html>
<html>
	<head>
		<title>Update</title>
	</head>
	<body>
		<div>
			<?php
					session_start();

				//checks if user is signed in or not
					if(!isset($_SESSION['username'])){
						header("Location: index.php");
					}
					
				//connect to database
				include("test/database.php");
				//if cannot connect return error
				$dbconn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)
						or die('Could not connect: ' . pg_last_error());

						
				$user=$_SESSION['user'];
				$query="SELECT * FROM DDL.login WHERE (username=$1)";
				pg_prepare($dbconn,'select',$query);
				$result=pg_execute($dbconn,'select',array($user)) or die ('Wrong typing: '. pg_last_error());
				$row = pg_fetch_array($result,null,PGSQL_ASSOC);
				echo "<table border='1'>";
				for($a=0;$a<pg_num_fields($result)-1;$a++){
					echo "<tr>\n";
					echo "<td>" . pg_field_name($result,$a) . "</td>\n";
					echo "<td>" . $row[pg_field_name($result,$a)] . "</td>\n";
					echo "</tr>\n"; 
				}

				if(isset($_POST['update_info'])){
					$new_des=$_POST['des'];
					$query1="UPDATE DDL.login SET description=$1 WHERE (username=$2)";
					pg_prepare($dbconn,'update',$query1);
					$result_new=pg_execute($dbconn,'update',array($new_des,$user)) or die ('Wrong typing: '. pg_last_error());
					$psw=$_SESSION['password'];
					$ip = $_SERVER['REMOTE_ADDR'];
					$query="INSERT INTO DDL.log VALUES(default,$1,$2,$3,default)";
					pg_prepare($dbconn,'log',$query);
					$result=pg_execute($dbconn,'log',array($user,$ip,'Update')) or die ('Wrong typing: '. pg_last_error());;

					header("Location:home.php");
						
/*				//prepare and execute query
					$result = pg_prepare($dbconn, "display", 'SELECT ui.username, ui.description FROM DDL.user_info ui WHERE username = $1');
					$result = pg_execute($dbconn, "display", array($_SESSION['username']));
					
				echo '<div align="center">';
				//prints result
					echo '<table border = "1">';
						echo "<tr><th>Username</th><th>Description</th></tr>";
							while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
								echo "\t<tr>\n";
									foreach($line as $col_value){
										echo "\t\t<td>$col_value</td>\n";
									}
								echo "\t</tr>\n";
							}
					echo "</table>";
				echo '</div>';

			?>
			<div align="center">
			<form method="POST" action="update.php">
				<br>
					<textarea name="description" cols="50" rows="4" placeholder="Enter your description" ></textarea>
				<br>
					<input type="submit" name="submit" value="Submit"><br><br>
			</form>		
				<br>		
					<a href="home.php">Return to Home page</a><br>
			</div>
		</div>
	<?php
		//checks to see if the submit button was pressed
		if(isset($_POST['submit'])){
					$description = $_POST['description'];

			//prepare and execute query to update
			$result = pg_prepare($dbconn, "insertdescription", 'UPDATE DDL.user_info SET description = $1 WHERE username = $2');
					$result = pg_execute($dbconn, "insertdescription", array($description, $_SESSION['username'] ));

			//checks to see if the query was successful, redirects user to main page
				if($result){
					header("Location: home.php");
				}
				else{
					echo"failed to update description";
				}
			}
*/
		pg_close($dbconn);
	?>
	<form method="POST" action="update.php">
<input type="submit" name="update_info" value="Submit" />
<textarea name="description" rows="10" cols="20">Enter description here.</textarea><br>


</form>
Click <a href="home.php">here</a> to return home page.
	</body>
</html>
