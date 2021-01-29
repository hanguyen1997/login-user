<!DOCTYPE html>
<html>
<head>
	<title>Registration - user</title>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script> 
	<style type="text/css">
	form {
	     width: 50%;
	    margin: 0 auto;
	    display: flex;
	    flex-direction: column;
	    border: 1px solid;
    	padding: 10px;
    	border-radius: 10px;
    	background-color: #89898933;
	}
	.sussec {
		font-size: 15px;
	    margin: 0;
	    padding: 2px;
	    color: blue;
	}
	.error {
		font-size: 15px;
	    margin: 0;
	    padding: 2px;
	    color: red;
	}
	.login input {
		margin-top: 10px;
	    padding: 8px;
	    height: 20px;
	}
	.checked {
		margin-top: 10px;
	}
	.login {
	    display: flex;
	    flex-direction: column;
    }
	</style>
</head>
<body>
	<!-- title -->
	<h1 style="text-align: center;">Registration User</h1>
	<!-- form -->
	<?php echo Form::open("/home/registration"); ?>
	  <div class="login">
	    <input type="email" placeholder="Email" name="user_email" id="user_email" required>
	    <span id="check_email"></span>
	    <input type="password" placeholder="password => 8 characters" name="user_password" id="user_password" required>
	    <input type="password" placeholder="confirm password" name="check_password" id="check_password" required>
	    <span id="check_pass"></span>
	    <button style="margin: 10px;font-weight: bold;font-size: 25px;" type="submit">Registration</button>
	  </div>
	  <div class="forget" style="text-align: center;">
	    <span class="psw"><a href="<?php echo Uri::create('login'); ?>">Login Account</a></span>
	  </div>
</body>
<script type="text/javascript">
	//check email
	$(document).ready(function(){
    	$('#user_email').blur(function(){
    		if(document.getElementById('user_email').value == "") 
			{
				document.getElementById('check_email').style.display = "none";
				document.getElementById('check_email').innerHTML = "";
				return;
			}
    		$.ajax({  
				method: "POST", 
				url: "<?php echo Uri::create('check_email'); ?>",  
				data: {
					user_email: document.getElementById('user_email').value
				} 
			}).done(function(msg){
				document.getElementById('check_email').style.display = "block";
				if(msg == "true") document.getElementById('check_email').innerHTML = "<p class='sussec'>Email success</p>";
				if(msg == "false") document.getElementById('check_email').innerHTML = "<p class='error'>Email matches or illegal</p>";
			});
    	});
	});
</script>
</html>
