<?php

// This section is for basic_info data collection, form tags are needed in the HTML

	if (isset($_POST['save_basic_info'])) {


// Collect data into an array: $array_basic_info

		$array_basic_info = array("first name"=>$_POST['fname'], "last name"=>$_POST['lname'], "phone number"=>$_POST['phone'], 
			"id"=>$_POST['id'], "email"=>$_POST['email'], "gpa"=>$_POST['gpa'], "agd"=>$_POST['agd'], 
			"GATO"=>$_POST['gato'], "selection for TA/PLA"=>$_POST['selection']);


//  Write data into a txt file: data.txt. Eventually data will be inserted into database.

		$data = fopen(".\stu_data.txt", "a+");
		
		foreach ($array_basic_info AS $key=>$info){
			echo "Your ".$key.' is: '.$info.'<br/>';
			fwrite ($data, $key." : ".$info." \n");

		}

		fwrite ($data, "\n\n");
		fclose ($data);
	}	

?>