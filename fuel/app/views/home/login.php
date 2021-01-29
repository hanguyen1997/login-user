<!DOCTYPE html>
<html>
<head>
	<title>login - user</title>
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
	<h1 style="text-align: center;">Login User</h1>

	<!-- form -->
	<?php echo Form::open("/home/check_login"); ?>
	  <div class="login">
	    <input type="email" placeholder="Email" name="user_email" required>
	    <input type="password" placeholder="Mật khẩu" name="user_password" required>
	    <label class="checked" >
	      <input type="checkbox" checked="checked" name="remember">Save information
	    </label>
	    <button style="margin: 10px;font-weight: bold;font-size: 25px;" type="submit">login</button>
	  </div>
	  <div class="forget" style="text-align: center;">
	    <span class="psw"><a href="<?php echo Uri::create('registration'); ?>">Create Account</a></span>
	  </div>
	<?php echo Form::close(); ?>
</body>
</html>