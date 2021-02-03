<div>
	<!-- title -->
	<h1 style="text-align: center;">Login User</h1>
	<!-- form -->
	<?php echo Form::open(['method' => 'POST','action' => 'user/login' , 'id' => 'form-login'])?>
	<?= Form::csrf(); ?>
		<?php if (!empty($errors)) : ?>
	        <div>
	            <?php foreach ($errors as $error) : ?>
	                <p class='error'> <?= $error ?> </p>
	            <?php endforeach; ?>
	        </div>
	    <?php endif; ?>
	  <div class="login">
	    <input type="email" placeholder="Email" name="mail_address" value="<?= $dataLogin['mail_address'] ?? '' ?>" required>
	    <input type="password" placeholder="Mật khẩu" name="password" value="<?= $dataLogin['password'] ?? '' ?>" required>
	    <label class="checked" >
	      <input type="checkbox" checked="checked" name="remember_password">Save information
	    </label>
	    <button style="margin: 10px;font-weight: bold;font-size: 25px;" type="submit">login</button>
	    <a href="<?php echo Uri::create('user/signup'); ?>">create account</a>
	  </div>
	<?= Form::close() ?>
</div>