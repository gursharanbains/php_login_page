<?php

	$connection=mysqli_connect("localhost","root","");

	$ret = array();
	$ret['error']['email'] = "";
	$ret['error']['password'] = "";
	$ret['success'] = "";
	$error = 0;

	$selected=mysqli_select_db($connection,"records");

	if($_POST["request"]=="checkemail"){

		$sent_email = $_POST["email"];
		$query = "SELECT *  FROM signup_records WHERE email='".$sent_email."'";
		
		$result = mysqli_query($connection,$query);
		
		if(mysqli_num_rows($result)>0){
			$error = 1;
		 	$ret['error']['email']['msg'] = "This email is already in use";

		}
	}
	
	if($_POST["request"]=="signup"){

		
		if(!$error){
			
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
		$query1 = "SELECT *  FROM signup_records WHERE email='".$sent_email."'";
		$query2 = "SELECT *  FROM signup_records WHERE email='".$sent_email."' AND password='".$sent_password."'";
		
		$account_exists = mysqli_query($connection,$query1);
		$login = mysqli_query($connection,$query2);

		if(mysqli_num_rows($account_exists)==0){
			$error = 1;
		 	$ret['error']['email']['msg'] = "This account does not exist.";
		}

		if(mysqli_num_rows($login)==0)
		{
			$error = 1;
			$ret['error']['password']['msg'] = "This password is invalid";
		}

		if(!$error)
		{
			$ret['success']['msg'] = "Logged In";
			session_start();
			$_SESSION[$sent_email] = $sent_email;
		}

		echo json_encode($ret);

	}


?>