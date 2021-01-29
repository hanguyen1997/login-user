<!DOCTYPE html>
<html>
<head>
	<title>list user</title>
	<style type="text/css">
		h1 {
			text-align: center;
		}
		table {
			margin: 0 auto;
		}
		td {
			border: 1px solid;
			padding: 10px;
			text-align: center;
		}
		th {
			border: 1px solid;
		}
		a {
			text-decoration: none;
		}
		.box-seach {
			display: flex;
    		justify-content: center;
		}
	</style>
</head>
<body>
	<p style="text-align: right;">Hi <?php echo $user_email ?> <a href="<?php echo Uri::create('user/form/add'); ?>">Add new user</a> <button><a href="<?php echo Uri::create('home/logout/'); ?>">Logout</a></button></p>
	<h1>List user</h1>
	<div class="box-seach">
		<?php echo Form::open("user/index"); ?>
		<input type="text" placeholder="Email" name="email_search" value="<?php echo $email_search;?>">
		<button style="margin: 10px;" type="submit">search</button>
		<?php echo Form::close();?>
	</div>
	<table>
	  <tr>
	    <th>User Name</th>
	    <th>Email</th>
	    <th>Phone</th>
	    <th>Gender</th>
	    <th>Option</th> 
	  </tr>
	  <?php 
	  $array_gender = array("0"=>"Nam", "1"=>"Nữ");
	  if($content == null) echo "<tr><td colspan='5'>no data</td></tr>";
	  foreach($content as $key => $value){ ?>
	  <tr>
	    <td><?php echo $value['user_name'] ?></td>
	    <td><?php echo $value['user_email'] ?></td>
	    <td><?php echo $value['phone'] ?></td>
	    <td>
	    	<?php 
		    	if($value['gender'] != 0 && $value['gender'] != 1) $value['gender'] = 0; 
		    		echo $array_gender[$value['gender']];
	    	?>
	    </td>
	    <td>
	    	<button><?php echo Html::anchor('user/form/'.$value['id'] , 'Edit') ?></button>
	    	<button><a href="<?php echo Uri::create('user/delete/'.$value['id']); ?>" onclick="return confirm('Are you sure?');" >delete</a></button>
	    </td>
	  </tr>
	 <?php } ?>
	</table>
	<div style="display: flex;align-items: center;justify-content: center;"><?php echo $pagination; ?></div>
</body>
</html>