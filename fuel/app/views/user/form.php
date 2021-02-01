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
	a {
		text-decoration: none;
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
	<a href="<?php echo Uri::create('user/index'); ?>"> Back to list user</a>
	<!-- title -->
	<h1 style="text-align: center;"><?php echo $title; ?></h1>

	<?php 
		/*notify*/
		if(Session::get('message') != "") {
			echo "<p style='text-align: center;'>".Session::get('message')."</p>";
			Session::set('message', "");
		}

		$user_email = "";
		$phone = "";
		$user_name = "";
		$gender = "";
		$id = "";
		if($content != null)
		{
			foreach ($content as $key => $value) {
				$user_email = $value['user_email'];
				$phone = $value['phone'];
				$user_name = $value['user_name'];
				$gender = $value['gender'];
				$id = $value['id'];
			}
		}

	?>
	<!-- form -->
	<?php echo Form::open("user/get_data"); ?>
	  <div class="login">
	    <input type="email" placeholder="Email" name="user_email" id="user_email" value="<?php echo $user_email; ?>" <?php if($content != null) echo 'disabled';?> required>
	    <span id="check_email"></span>
	    <input type="text" placeholder="Phome" name="phone" value="<?php echo $phone; ?>" required>
	    <input type="text" placeholder="Name" name="user_name" value="<?php echo $user_name; ?>" required>
	    <div class="gender">
	    	<label>Gender : </label>
	    	<input type="radio" name="gender" value="0" <?php if($gender == 0) echo "checked"; ?>>
			<label>Boy</label>
			<input type="radio" name="gender" value="1" <?php if($gender == 1) echo "checked"; ?>>
			<label>Girl</label>
		</div>
		<input type='password' placeholder='password => 8 characters' name='user_password' <?php if($content == null) echo 'required';?>>
		<input type='password' placeholder='confirm password ' name='check_password' <?php if($content == null) echo 'required';?>>
		<input type='hidden' name='id' value='<?php echo $id ?>'>
		
	    <button style="margin: 10px;font-weight: bold;font-size: 25px;" type="submit"><?php echo $button; ?></button>
	  </div>
	  
	<?php echo Form::close(); ?>
	<script type="text/javascript">
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
</body>
</html>
