<?php

// This section is for basic_info data collection, form tags are needed in the HTML

	if (isset($_POST['save_basic_info'])) {

		echo "<h3>You have entered the following basic information:</h3>".'<br/>';

		// Collect data into an array: $array_basic_info

		$array_basic_info = array("Your first name"=>$_POST['fname'], "Your last name"=>$_POST['lname'], "Your phone number"=>$_POST['phone'], 
			"Your id"=>$_POST['id'], "Your email"=>$_POST['email'], "Your gpa"=>$_POST['gpa'], "Your agd"=>$_POST['agd'], 
			"GATO"=>$_POST['gato'], "Position you are applying for"=>$_POST['selection']);


		//  Write data into a txt file: data.txt. Eventually data will be inserted into database.

		$data = fopen(".\stu_data.txt", "a+");
		
		foreach ($array_basic_info AS $key=>$info){

			echo $key.' is: '.$info.'<br/>';
			fwrite ($data, $key." : ".$info." \n");

		}

		fwrite ($data, "\n\n");
		fclose ($data);
		header("Location: isinter.php");
	}	



// This section is for is_international data collection

 	if (isset($_POST['save_inter_info'])) {

	 	echo "<h3>You have entered the following status:</h3>".'<br/>';  	
	  
	  	// This part is for international students

	  	if ($_POST['status'] == "international"){
			echo "You are an international student.".'<br/>';
			

			// This part is for international students who have passed speaktest

			if ($_POST['speaktest'] == 'passed') {
				echo "You have passed the speaktest.".'<br/>';

				if ($_POST['test_date'] && $_POST['test_score']){
					echo "Your test date was ".$_POST['test_date'].".".'<br/>';
					echo "Your test score was ".$_POST['test_score'].".".'<br/>';
					
					$array_passed_test = array("Your status"=>$_POST['status'], "Your speak test"=>$_POST['speaktest'], "Your test score"=>$_POST['test_score'],
  						"Your test date"=>$_POST['test_date'], "At least one semester "=> $_POST['not_new'], "ONITA"=>$_POST['onita']);
					

					$data = fopen('.\stu_data.txt', "a+");

					foreach ($array_passed_test AS $key=>$info){
						fwrite ($data, $key." : ".$info." \n");
					}

					fwrite ($data, "\n\n");
					fclose ($data);	
				}
							
				else {

					echo "Please tell us both of your test date and test score!<br/>";
				}
			}		

		
			// This part is for international students who have not passed speaktest but already scheduled for one

			elseif ($_POST['speaktest'] == 'scheduled') {
				
				if ($_POST['schedule_date']){
					echo "You have scheduled the speaktest on ".$_POST['schedule_date'].".".'<br/>';

					$array_scheduled_test = array("Your status"=>$_POST['status'], "Your speak test"=>$_POST['speaktest'],
  						"Your test schedule date"=>$_POST['schedule_date'], "At least one semester "=> $_POST['not_new'], "ONITA"=>$_POST['onita']);
					
					$data = fopen('.\stu_data.txt', "a+");

					foreach ($array_scheduled_test AS $key=>$info){
						fwrite ($data, $key." : ".$info." \n");
					}

					fwrite ($data, "\n\n");
					fclose ($data);	
					header("Location: gradundergrad.php");
				}

				else {
					echo "Please tell us your scheduled test date!<br/>";
				}
			}


			// This part is for international students who have not passed speaktest and not scheduled for one

			elseif ($_POST['speaktest'] == 'notscheduled') {
				echo "You have not yet scheduled a speaktest,".'<br/>';
				echo "Please do so to quality you for a TA position".'<br/>';
			}					
		

			// This part is whether students have met the requirement for at least one semester and the ONITA

			if($_POST['not_new'] == "Yes") {
				echo "You have finished at least one semester at MU.<br/>";
			} 
			elseif ($_POST['not_new'] == "No") {
				echo "You have not finished at least one semester at MU.<br/>";
			}	
	
			
			if($_POST['onita'] == "Yes"){
				echo "You have attended the ONITA.<br/>";
			} 
			elseif ($_POST['onita'] == "No") {
				echo "You have not attended the ONITA.<br/>";
			} 
			elseif ($_POST['onita'] == "Will_attend") {				
				echo "You will attend ONITA in Aug/Jan.<br/>";
			}

		}
	

		// This part is for noninternational students

		elseif ($_POST['status'] == "noninternational") {

			echo 'You are a non-international student.<br/>';

			$data = fopen('.\stu_data.txt', "a+");
			fwrite ($data, "Your status is: ".$_POST['status'].".\n");
			fclose ($data);

		}

		//This part is for courses info 

		if ($_POST['status'] == "save_courses_info"){

			echo '<h3>You have entered the following basic information:</h3>';

			$array_courses_info = array("Course(s) You Are Currently Teaching: "=>$_POST['courseteaching'], 
			"Course(s) You Have Previously Taught: "=>$_POST['prevtaught'], 
			"Course(s) You Would Like to Teach (must have taken previously), include grades received: "=>$_POST['lteach']);


			//  Write data into a txt file: data.txt. Eventually data will be inserted into database.

			$data = fopen(".\stu_data.txt", "a+");
		
			foreach ($array_courses_info AS $key=>$info){
				echo $key.' is: '.$info.'<br/>';
				fwrite ($data, $key." : ".$info." \n");
			}
		}
		//This part is for undergraduate student info 

		if ($_POST['status'] == "save_undergrad_info"){

			echo '<h3>You are undergraduate student: </h3>';

			$array_undergrad_info = array("Your are undergraduate student\n",
			"Your current level: "=>$_POST['year'], 
			"You degree program: "=>$_POST['program']);


			//  Write data into a txt file: data.txt. Eventually data will be inserted into database.

			$data = fopen(".\stu_data.txt", "a+");
		
			foreach ($array_undergrad_info AS $key=>$info){
				echo $key.' is: '.$info.'<br/>';
				fwrite ($data, $key." : ".$info." \n");
			}
		}
		
		//This part is for graduate student info 

		if ($_POST['status'] == "save_grad_info"){

			echo '<h3>You are graduate student: </h3>';

			$array_grad_info = array("Your are graduate student\n", 
			"Your degree program: "=>$_POST['programs'],
			"Your advisor: "=>$_POST['advisors']);


			//  Write data into a txt file: data.txt. Eventually data will be inserted into database.

			$data = fopen(".\stu_data.txt", "a+");
		
			foreach ($array_grad_info AS $key=>$info){
				echo $key.' is: '.$info.'<br/>';
				fwrite ($data, $key." : ".$info." \n");
			}
		}
	};
	
?>
