<!DOCTYPE html>
<html>
	<head>
		<title><?= $title ?? "" ?></title>
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<!-- load css -->
		<?php echo Asset::css('style.min.css') ?>
	</head>
	<body>
		<?= $content ?? '' ?>
	</body>
</html>
