<?php

	session_start();

	$loginemail = $_POST['email'];

	if(isset($_SESSION[$loginemail])) {
		echo "welcome ".$loginemail;
	}
	else {
		header("Location:loginpage.html");
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Homepage</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript">
		function myAjax(){
			$.ajax({
				type:"post",
				data:"",
				url: "logout.php",
				success:function(result){
					window.location.href = "loginpage.html"
				}

			});
		}
	</script>
</head>
<body>
	<button id = "logout" onclick = "myAjax()">Log Out</button>
</body>
</html>