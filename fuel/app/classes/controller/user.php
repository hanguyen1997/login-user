<?php 
use Fuel\Core\Session;

class Controller_User extends Controller
{
	/*list user*/
	public function action_index()
	{
		$email_search = Input::post('email_search');
		$pagination = Pagination::forge('user/index', array(
		    'pagination_url' => Uri::create('user/index'),
		    /*tổng số phần trên url phân trang*/
		    'uri_segment' => 3,

		    /*tổng số hàng */
		    'total_items' => DB::select('id')->from('users')->execute()->count(),

		    /*tổng số hàng hiển thị trên 1 trang*/
		    'per_page' => 4,
		));

		/*load view*/
		$view = View::forge('user/index', null, false);

		
		if($email_search  != "")
		{
			/*query sql*/
			$users = DB::select('*')
		                        ->from('users')
		                        ->where('user_email', 'like', '%'.$email_search.'%')
		                        ->limit($pagination->per_page)
		                        ->offset($pagination->offset)
		                        ->execute()
		                        ->as_array();
		}
		else{ 
			/*query sql*/
			$users = DB::select('*')
		                        ->from('users')
		                        ->limit($pagination->per_page)
		                        ->offset($pagination->offset)
		                        ->execute()
		                        ->as_array();
		}

		// echo DB::last_query();
		// exit;

		/*send data view by content*/
        $view->content = $users;

        /*get user_name by session*/
        $view->user_email = Session::get('user_email');
        
        $view->email_search = $email_search;

        /*load phân trang*/
        $view->pagination = $pagination->render();
        return $view;
	}
	/*end: function action_index()*/

	/*form add and edit user*/
	public function action_form($id_user)
	{	
		/*load view*/		
		$view = View::forge('user/form', null , false);
		$view->content = array();
		$view->title = "Create user";
		$view->button = "Create";

		/*check $id_user is number */
		if(is_numeric($id_user))
		{
			/*query selec by $id_user*/
			$user = DB::select('*')->from('users')->where("id", $id_user)->limit(1)->execute()->as_array();
			if($user != null) 
			{
				$view->content = $user;
				$view->title = "Edit user";
				$view->button = "Edit";
			}
			/*end: if($user != null) */
		}
		/*end: if($id_user != "" && is_int($id_user))*/
		return $view;
	}
	/*end: function action_add()*/

	/*get data form edit or add user*/
	public function action_get_data()
	{	
		$val = Validation::forge();
	  	$val->add('phone')->add_rule('required')->add_rule('numeric_min', 10000000)->add_rule('numeric_max', 999999999999);;
	  	$val->add('user_name')->add_rule('required')->add_rule('min_length', 3)->add_rule('max_length', 20);
	  	$val->add('gender')->add_rule('required');

		if(Input::post('id') != "")
		{
			/*update user*/
			if(Input::post('user_password') != "")
			{
				/*update charget password*/
				$val->add('user_password')->add_rule('required')->add_rule('min_length', 8)->add_rule('max_length', 20);
				if($val->run())
				{
					/*check password vs cofim password*/
					if(Input::post('user_password') != Input::post('check_password')) return Response::redirect('user/form/'.Input::post('id'));
					
					/*query update*/
					DB::update('users')->set(array(
									        'phone'  => Input::post('phone'),
									        'user_name' => Input::post('user_name'),
									        'gender' => Input::post('gender'),
									        'user_password' => md5(Input::post('user_password')),
									    ))
									    ->where('id', '=', Input::post('id'))
									    ->execute();

					return Response::redirect('user/index');
				}
				/*end: if($val->run())*/
			}
			else
			{
				/*update no change password*/
				if($val->run())
				{
					DB::update('users')->set(array(
									        'phone'  => Input::post('phone'),
									        'user_name' => Input::post('user_name'),
									        'gender' => Input::post('gender'),
									    ))
									    ->where('id', '=', Input::post('id'))
									    ->execute();
					return Response::redirect('user/index');
				}
				/*end: if($val->run())*/
			}
			// end: if(Input::post('user_password') != "") 

			return Response::redirect('user/form/'.Input::post('id'));;
		}
		else{
			/*create user*/
			$val->add('user_email')->add_rule('required')->add_rule('valid_email');
			$val->add('user_password')->add_rule('required')->add_rule('min_length', 8)->add_rule('max_length', 20);
			if($val->run())
			{
				/*check password*/
				if(Input::post('user_password') != Input::post('check_password'))  return Response::redirect('user/form/add');
				
				DB::insert('users')->set(array(
									    'user_name' => Input::post('user_name'),
									    'user_email' => Input::post('user_email'),
									    'user_password' => md5(Input::post('user_password')),
									    'phone'  => Input::post('phone'),
									    'gender' => Input::post('gender'),
									))->execute();
				return Response::redirect('user/index');;
			}
			/*end: if($val->run())*/
		}
		/*end: if(Input::post('id') != "")*/

		return Response::redirect('user/form/add');
	}
	/*end: function action_edit($id_user)*/

	/*delete acccount by id*/
	public function action_delete($id_user)
	{
		DB::delete('users')->where('id', $id_user)->execute(); 
		
		/* message sussec and redirect page list user*/
		return Response::redirect('user/index');
	}
	/*end: function action_delete($id_user*/

	public function action_check_email_ajax()
	{
		$check = "false";
		if(Input::post('user_email') != "")
		{
			$val = Validation::forge();
			$val->add('user_email')->add_rule('required')->add_rule('valid_email');
			if($val->run())
			{
				$check_user_email = DB::select('user_email')->from('users')->where('user_email', '=', Input::post('user_email') )->execute()->as_array();
				if($check_user_email == null) $check = "true";
			}
		}
		return $check;
	}
}
/*end: class Controller_Home extends Controller*/