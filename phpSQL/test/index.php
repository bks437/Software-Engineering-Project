<?php
	include("database.php");
	$conn=pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD)or die('Could not connect: ' . pg_last_error());
	$result=pg_query('SELECT * FROM ddl.Person;')or die('Query failed: '. pg_last_error());
	$maxfield=pg_num_fields($result);
	//gets number of rows returned by the result
	$rows=pg_num_rows($result);
	echo "There were <em>$rows</em> rows returned<br><br>";
	echo "<table border=\"1\">\n";
	echo "<tr>";
	//displays the header for the table
	for($field=0;$field<$maxfield;$field++) {
		$header=pg_field_name($result, $field);
		echo "\t\t<th>$header</th>\n";
		}
	echo "</tr>";
	//displays the results from the database into the table
	while($line=pg_fetch_array($result,null, PGSQL_ASSOC)){
		echo "\t<tr>\n";
		foreach ($line as $col_value){
				echo "\t\t<td>$col_value</td>\n";			
			}
			echo "\t</tr>\n";
		}
		echo "</table>\n";
		//free the result
	pg_free_result($result);
	//close the database connection
	pg_close($conn);
	
?>