<div>
	<a href="<?php echo Uri::create('top/index'); ?>"> Back to list user</a>
	<h1>Detail <?= $user['name'] ?></h1>
	<div style="width: 200px;margin: 0 auto;width: 200px;margin: 0 auto;border: 1px solid;background: #33333333;">
		<img src="<?= Uri::create('barcode/generator?s=code39&d='.$user['name'].'&w=200&h=72&p=1&bc=fff') ?>" alt="" />
		<h2 style="text-align:center;"><?= $user['name'] ?></h2>
		<p>Phone: <?= $user['phone'] ?></p>
		<p>Email: <?= $user['mail_address'] ?></p>
	</div>
</div>