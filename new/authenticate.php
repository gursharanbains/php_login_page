<?php

	$connection=mysqli_connect("localhost","root","");

	$ret = array();
	$error = 0;

	$selected=mysqli_select_db($connection,"records");
	
	if($_POST["request"]=="signup"){

		$sent_email = $_POST["email"];
		$query = "SELECT *  FROM signup_records WHERE email='".$sent_email."'";
		//echo $query;
		$result = mysqli_query($connection,$query);
		//echo "\nSelected query returned number of rows:".mysqli_num_rows($result);
		if(mysqli_num_rows($result)>0){
			$error = 1;
		 	$ret['error']['email']['msg'] = "This email is already in use";

		}

		if(!$error){
			//echo "new email";
			$Name=$_POST["name"];
			$Email=$_POST["email"];
			$MobileNo=$_POST["mobileno"];
			$Password=$_POST["password"];
			$insert_query = "INSERT INTO signup_records (name,email,mobileno,password) values ('$Name','$Email','$MobileNo','$Password')";
			mysqli_query($connection,$insert_query);
			$ret['success']['msg'] = "row inserted succesfully";
		}
				
		echo json_encode($ret);
	}

	if($_POST["request"]=="login"){

		$sent_email = $_POST["email"];
		$sent_password = $_POST["password"];
		$query = "SELECT *  FROM signup_records WHERE email='".$sent_email."' AND password='".$sent_password"'";
		$result = mysqli_query($connection,$query);

		if(mysqli_num_rows($result)==0){
			$error = 1;
		 	$ret['error']['email']['msg'] = "This account does not exist.";
		}

		if(!$error)
		{
			$ret['success']['msg'] = "Logged In";
		}

		echo json_encode($ret);

	}


?>