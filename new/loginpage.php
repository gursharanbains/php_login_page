<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="loginpagestyles.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			$("#myform").submit(function(e){
				e.preventDefault();
			
				var done = true;
				if($("#email").val()==''){
					$("#email-error").text("Please enter your email").removeClass("hidden");
					done = false;
				}
				if($("#password").val()==''){
					$("#password-error").text("Please enter your password").removeClass("hidden");
					done = false;
				}

				var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$/;

				if(!(emailRegex.test($("#email").val()))){
					$("#email-error").text("Please enter a valid email").removeClass("hidden");
					done = false;
				}

				if(done==true)
				{
					var data = {
						request:"login",
						email:$("#email").val(),
						password:$("#password").val()
					};

					console.log(data);

					$.ajax({
						url:"../authenticate.php",
						type:"post",
						dataType:"json",
						data:data,
						success:function(result){
							if(result['error']['email']&&result['error']['email']['msg']){
								$("#msg").text(result['error']['email']['msg']).show();
								result['error']['password'] = "";
							}
							if(result['error']['password']&&result['error']['password']['msg']){
								$("#msg").text(result['error']['password']['msg']).show();
							}
							if(result['success']&&result['success']['msg']){
								$("#myform").unbind('submit').submit();
							}
						},
						error:function(jqXHR,textStatus,errorThrown){
							alert(errorThrown);
						}

					});

				}

			});

		});
	</script>
</head>
<body>
	<div class="formbox">
		<div class="heading"><h2>Login Page</h2></div>
		<div id="msg"></div>
		<form class="loginform" id="myform" action="homepage.php" method="post">
			<input type="text" name="email" placeholder="email" id="email">
			<div id="email-error" class="error hidden"></div>
			<input type="password" name="password" placeholder="password" id="password">
			<div id="password-error" class="error hidden"></div>
			<input type="submit" name="submitform" value="submit">
		</form>
	</div>
</body>
</html>