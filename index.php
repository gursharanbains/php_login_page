<?php ?><!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="loginpage.css">
	<meta name="google-signin-client_id" content="63082468078-8aanc6meadsa1ursln9mgol3ps0lm1pa.apps.googleusercontent.com">
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	
	<script>
		
		$(document).ready(function(){

			var verified = false;
			$("#myform").submit(function(e){
				
				e.preventDefault();

			});

			$("#submitform").click(function(){ 
						
				var done = true;
				if($("#yourname").val()==''){
					$("#name-error").text("Please enter your name").show();
					done=false;
				}
				else{
					$("#name-error").hide();
				}
				if($("#email").val()==''){
					$("#email-error").text("Please enter your email").show();
					done=false;
				}
				else {
					$("#email-error").hide();
				}
				if($("#mobileno").val()==''){
					$("#mobileno-error").text("Please enter your mobile number").show();
				}
				else {
					$("#mobileno-error").hide();
				}
				if($("#password").val()==''){
					$("#password-error").text("Please enter your password").show();
					done=false;
				}
				else {
					$("#password-error").hide();
				}

				var nameRegex = /^[a-zA-Z]{3,16}$/;
				var passwordRegex = /^[a-z0-9_-]{6,18}$/; 
				var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$/;
				var intRegex = /^[0-9 -()+]+$/; 
				
				if(done==true)
				{
					if(!(nameRegex.test($('#yourname').val()))){ 
						$("#name-error").text("Please enter a valid name").show();
						done=false;
					}

					if(!(emailRegex.test($('#email').val()))){ 
						$("#email-error").text("Please enter a valid email").show();
						done=false;
					}

					//if(!(passwordRegex.test($('#password').val()))){ 
					//	$("#password-error").text("Please enter a valid password").removeClass("hidden");

					//}

					//if(!(intRegex.test($('#mobileno').val()))){
					//	$("#mobile-error").text("Please enter a valid mobile number").removeClass("hidden");
					//}
					
					$.ajax({
						//code for checking if email id already exists
						//done=false
					});

				}
				if(done==true)
				{	
				 	var data = {
			 			mobileno:$("#mobileno").val(),
			 			verification_code:$("#verification_code").val()
				 		};

				 	console.log(data);

				 	//function sendCode(){
				 		console.log("in function")
				 		$.ajax({
				 			url:"sms.php",
				 			dataType:"json",
				 			type:"post",
				 			data:data,
				 			success:function(result){
				 				$("#submitform").slideToggle();
				 				$("#start_verification").slideToggle();
				 			},
				 			error: function(jqXHR, textStatus, errorThrown){
          						alert(errorThrown);
          					}
				 		});
					//}
					//sendCode();
					
					$("#code_received").click(function(){
						console.log('in code received');

						$("#start_verification").slideToggle();
						$("#check_verification").slideToggle();		

						$("#verify_code").click(function(){

							var checkdata = {
			 					mobileno:$("#mobileno").val(),
			 					verification_code:$("#verification_code").val()
				 				};
							
							$.ajax({
								url:"sms.php",
								dataType:"json",
								type:"post",
								data:checkdata,
								success:function(result){
									var twilio_msg = jQuery.parseJSON(result);
									console.log(twilio_msg);
									if(twilio_msg["success"]==true){

										$("#check_verification").slideToggle();
										$("#verifysuccess").text("Your number has been verified!").slideToggle();
										$("#submitform").slideToggle();
													$("#submitform").val("CLICK TO CREATE ACCOUNT");
										verified = true;

									}
									else {
										if(twilio_msg["error_code"]){
											alert(twilio_msg["errors"]["message"])
										}
									}

								},
								error: function(jqXHR, textStatus, errorThrown){
          							alert(errorThrown);
          						}
							});
						});
					});
					$("#code_not_received").click(function(){
						sendCode();
					 });
				}

			});

				$("#submitform").click(function(){ 

				if(verified==true)
				{
					
					var data = {
						request:"signup",
						name:$("#yourname").val(),
						email:$("#email").val(),
						password:$("#password").val(),
						mobileno:$("#mobileno").val()
					};

					console.log(data);
					
					$.ajax({
						url:"authenticate.php",
						dataType:"json",
						//contentType:"application/json",
						data:data,
						type:"post",
						success:function(result)
						{
							if(result['error'] && result['error']['email']['msg']){
								$("#email-error").text("This email is already in use").show();
								$("#submitform").slideToggle();

							}
							if(result['success']){
								$("#success").text("Your account has been created").show();
								window.location.replace("new/loginpage.php");
							}
						},
						error: function(jqXHR, textStatus, errorThrown){
          						alert(errorThrown);
          				}
					});
				}

			});
			$('#mobileno').keydown(function(e){
				var charCode = !e.charcode?e.which:e.charcode;
				console.log(charCode);
				if(!(charCode<=57&&charCode>=48)||charCode==32||charCode==45||charCode==40||charCode==41||charCode==8)
					e.preventDefault();
				
			});
			$("#submitform").attr("title","submit");
		});
		</script>

		<script type="text/javascript">
			function addUser(userProfile){
			var userData = {
				"google_id":userProfile.getId(),
				"name":userProfile.getName(),
				// "img_url":userProfile.getImageUrl(),
				"email":userProfile.getEmail()
			};

			$.ajax({
				url:"addUser.php",
				type:"post",
				data:userData,
				dataType:"text",
				success:function(result){
					alert(result);
					// window.location.replace("homepage.php");
				},
				error:function(jqXHR,textStatus,errorThrown){
					alert(errorThrown);
				}

			});
		}
		function onSignIn(googleUser) {
		  var profile = googleUser.getBasicProfile();
		  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
		  console.log('Name: ' + profile.getName());
		  console.log('Image URL: ' + profile.getImageUrl());
		  console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
		  addUser(profile);
		}

		

	</script>
</head>
<body>
	<div class="background">
		<div class="main-box">
			
			<div class="left-box">
				<div class="signup"><h1>Sign up</h1></div>
				<div class="tagline">Start your next adventure with your trusty partner!</div>
			</div>

			<div class="right-box">
				<div id="success" class="hidden"></div>
				<form action="authenticate.php" method="post" id="myform">
					<div class="form">
						<input type="text" name="name" placeholder="Name" id="yourname"/><span class="emsg hidden" id="name-error"></span>
						<input type="email" name="email" placeholder="Email" id="email" /><span class="emsg hidden" id="email-error"></span>
						<input type="text" name="mobileno" placeholder="Mobile Number" id="mobileno" /><span class="emsg hidden" id="mobileno-error"></span>
						<input type="password" name="password" placeholder="Password" id="password"/><span class="emsg hidden" id="password-error"></span>
						<div id="start_verification" class="verification hidden" >Verification code sent to your phone number. Received code?
							<div id="buttons">
								<button id="code_received">Yes</button>
								<button id="code_not_received">No</button>
							</div>
						</div>
						<div id="check_verification" class="verification hidden">Enter the verification code.
							<input type="text" name="verification_code" id="verification_code"/>
							<button id="verify_code">Verify</button>
						</div>
						<div><span class="hidden" id="verifysuccess"></span></div>
						<div class="submit-button"><input type="submit" value="VERIFY MOBILE NO" id="submitform" /></div>
					</div>
				</form>
				<div id="haveaccount">Already have an account? <a href="signin.php">Sign in</a></div>
				<hr id="line">
				<p id="googlesignin">Or Sign In With Google</p>
				<div class="g-signin2" data-onsuccess="onSignIn"></div>
			</div>

		</div>
	</div>

</body>
</html>