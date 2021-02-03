<body>
	<p style="text-align: right;">Hi <?php echo $mail_address ?> <a href="<?php echo Uri::create('member/form/add'); ?>">Add new user</a> <button><a href="<?php echo Uri::create('user/logout'); ?>">Logout</a></button></p>
	<h1>List user</h1>
	<?php
		/*notify*/
		$message =  Session::get('message');
		if($message)
		{
			echo "<p class='sussec' style='text-align:center'>$message</p>";
			Session::set('message', "");
		}
	?>
	<div class="box-seach">
		<?php echo Form::open(['method' => 'GET','action' => 'top/index' , 'class' => 'form-search', 'style'=>'all: unset;'])?>
		<input type="text" placeholder="Email" name="email_search" value="<?= $email_search ?? ""?>">
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
	  if($users == null) echo "<tr><td colspan='5'>no data</td></tr>";
	  foreach ($users as $key => $value) {
	 ?>
	  <tr>
	    <td><?= $value['name']; ?></td>
	    <td><?= $value['mail_address']; ?></td>
	    <td><?= $value['phone']; ?></td>
	    <td>
	    	<?php 
		    	if($value['gender'] != 0 && $value['gender'] != 1) $value['gender'] = 0; 
		    		echo $array_gender[$value['gender']];
	    	?>
	    </td>
	    <td>
	    	<button><?php echo Html::anchor('member/detail/'.$value['id'] , 'detail') ?></button>
	    	<button><?php echo Html::anchor('member/form/'.$value['id'] , 'Edit') ?></button>
	    	<button><a href="<?php echo Uri::create('member/del/'.$value['id']); ?>" onclick="return confirm('Are you sure?');" >delete</a></button>
	    </td>
	  </tr>
	  <?php } ?>
	</table>
	<div style="display: flex;align-items: center;justify-content: center;"><?= $pagination ?></div>
</body>