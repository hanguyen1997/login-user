<div>
	<a href="<?php echo Uri::create('top/index'); ?>"> Back to list user</a>
	<!-- title -->
	<h1 style="text-align: center;"><?php echo $title; ?></h1>

	<!-- form -->
	<?php echo Form::open("member/send_data"); ?>
		<?= Form::csrf(); ?>
	  	<div class="login">
		<?php
			/*notify*/
			$message =  Session::get('message');
			if($message)
			{
				echo "<p class='error' style='text-align:center'>$message</p>";
				Session::set('message', "");
			}
		?>
	    <input type="email" placeholder="Email" name="mail_address" id="mail_address" value="<?php echo $mail_address; ?>" <?php if($mail_address != "") echo 'disabled';?> required>
	    <span id="check_email"></span>
	    <input type="text" placeholder="Phome" name="phone" value="<?php echo $phone; ?>" required>
	    <input type="text" placeholder="Name" name="user_name" value="<?php echo $name; ?>" required>
	    <div class="gender">
	    	<label>Gender : </label>
	    	<input type="radio" name="gender" value="0" <?php if($gender == 0) echo "checked"; ?>>
			<label>Boy</label>
			<input type="radio" name="gender" value="1" <?php if($gender == 1) echo "checked"; ?>>
			<label>Girl</label>
		</div>
		<input type='password' placeholder='password => 8 characters' name='user_password' <?php if($mail_address == null) echo 'required';?>>
		<input type='password' placeholder='confirm password ' name='check_password' <?php if($mail_address == null) echo 'required';?>>
		<input type='hidden' name='id' value='<?php echo $id ?>'>
	    <button style="margin: 10px;font-weight: bold;font-size: 25px;" type="submit"><?php echo $button; ?></button>
	  </div>
	<?php echo Form::close(); ?>

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