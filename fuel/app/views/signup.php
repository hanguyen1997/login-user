<!-- title -->
<div>
  <h1 style="text-align: center;">Registration User</h1>
  <!-- form -->
  <?php echo Form::open("/user/signup"); ?>
  <?= Form::csrf(); ?>
  <?php if (!empty($errors)) : ?>
      <div>
          <?php foreach ($errors as $error) : ?>
              <p class='error'> <?= $error ?> </p>
          <?php endforeach; ?>
      </div>
  <?php endif; ?>

  <div class="login">
    <input type="email" placeholder="Email" name="mail_address" id="mail_address"  value='<?= $dataSignup['mail_address'] ?? '' ?>' required>
    <span id="check_email"></span>
    <input type="password" placeholder="password => 8 characters" name="user_password" id="user_password" value='<?= $dataSignup['user_password'] ?? '' ?>' required>
    <input type="password" placeholder="confirm password" name="check_password" id="check_password"  value='<?= $dataSignup['check_password'] ?? '' ?>' required>
    <span id="check_pass"></span>
    <button style="margin: 10px;font-weight: bold;font-size: 25px;" type="submit">Registration</button>
  </div>
  <div class="forget" style="text-align: center;">
    <span class="psw"><a href="<?php echo Uri::create('user/login'); ?>">Login Account</a></span>
  </div>

  <script type="text/javascript">
	//check email
	$(document).ready(function(){
    	$('#mail_address').blur(function(){
    		if(document.getElementById('mail_address').value == "") 
			{
				document.getElementById('check_email').style.display = "none";
				document.getElementById('check_email').innerHTML = "";
				return;
			}
    		$.ajax({  
				method: "POST", 
				url: "<?php echo Uri::create('user/check_email'); ?>",  
				data: {
					mail_address: document.getElementById('mail_address').value
				} 
			}).done(function(msg){
				document.getElementById('check_email').style.display = "block";
				if(msg == "true") document.getElementById('check_email').innerHTML = "<p class='sussec'>Email success</p>";
				if(msg == "false") document.getElementById('check_email').innerHTML = "<p class='error'>Email matches or illegal</p>";
			});
    	});
	});
 </script>
</div>