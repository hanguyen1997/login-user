<?php 
use Fuel\Core\Session;

class Controller_User extends Controller
{
	/*check session user*/
	public function action_auth($user_id){
		if($user_id == "") 
		{
			Session::set('message', "please login");
			return Response::redirect('login');
		}
		/*end: if($user_id == "")*/
	}
	/*end: function action_auth()*/

	/*list user*/
	public function action_index()
	{
		$this->action_auth(Session::get('user_id'));

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
			$users = DB::select('*')->from('users')->where('user_email', 'like', '%'.$email_search.'%')->limit($pagination->per_page)->offset($pagination->offset)->execute()->as_array();
		}
		else{ 
			/*query sql*/
			$users = DB::select('*')->from('users')->limit($pagination->per_page)->offset($pagination->offset)->execute()->as_array();
		}
		// echo if($email_search  != "");
		
		/*send data view */
        $view->content = $users;
        $view->user_email = Session::get('user_email');
        $view->email_search = $email_search;
        $view->pagination = $pagination->render();
        return $view;
	}
	/*end: function action_index()*/

	/*form add and edit user*/
	public function action_form($id_user)
	{	
		/*check login*/
		$this->action_auth(Session::get('user_id'));

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
		/*check login*/
		$this->action_auth(Session::get('user_id'));

		$phone = Input::post('phone');
		$user_name = Input::post('user_name');
		$gender = Input::post('gender');
		$user_password = Input::post('user_password');
		$id = Input::post('id');
		$user_email = Input::post('user_email');

		/*validate data*/
		$val = Validation::forge();
	  	$val->add('phone')->add_rule('required')->add_rule('numeric_min', 10000000)->add_rule('numeric_max', 999999999999);;
	  	$val->add('user_name')->add_rule('required')->add_rule('min_length', 3)->add_rule('max_length', 20);
	  	$val->add('gender')->add_rule('required');

		if($id != "")
		{
			/*update user*/
			if($user_password != "")
			{
				/*update charget password*/
				$val->add('user_password')->add_rule('required')->add_rule('min_length', 8)->add_rule('max_length', 20);
				if($val->run())
				{
					/*check password vs cofim password*/
					if($user_password != Input::post('check_password')) return Response::redirect('user/form/'.$id);
					$this->action_edit_charge_password($phone , $user_name, $gender, $user_password, $id);
				}
				/*end: if($val->run())*/
			}
			else
			{
				/*update no change password*/
				if($val->run())
				{
					DB::update('users')->set(array('phone'  => $phone ,'user_name' => $user_name,'gender' => $gender))->where('id', '=', $id)->execute();
					
					/*notify success*/
					Session::set('message', "edit user success");
					return Response::redirect('user/index');
				}
				/*end: if($val->run())*/
			}
			// end: if($user_password != "") 
			
			/*notify error*/
			Session::set('message', "create user error");
			return Response::redirect('user/form/'.$id);;
		}
		else{
			/*create user*/
			$val->add('user_email')->add_rule('required')->add_rule('valid_email');
			$val->add('user_password')->add_rule('required')->add_rule('min_length', 8)->add_rule('max_length', 20);
			if($val->run())
			{
				/*check password*/
				if($user_password != Input::post('check_password'))  return Response::redirect('user/form/add');
				
				$this->action_add($user_name, $user_email, $user_password, $phone , $gender);
			}
			/*end: if($val->run())*/
		}
		/*end: if($id != "")*/

		/*notify error*/
		Session::set('message', "create user error");
		return Response::redirect('user/form/add');
	}
	/*end: function action_edit($id_user)*/

	public function action_add($user_name, $user_email, $user_password, $phone, $gender)
	{
		DB::insert('users')->set(array(
									    'user_name' => $user_name,
									    'user_email' => $user_email,
									    'user_password' => md5($user_password),
									    'phone'  => $phone,
									    'gender' => $gender,
									))->execute();
				/*notify success*/
				Session::set('message', "create user success");
				return Response::redirect('user/index');;
	}
	/*end: action_add($user_name, $user_email, $user_password, $phone, $gender)*/

	public function action_edit_charge_password($phone, $user_name, $gender, $user_password, $id)
	{
		/*query update*/
		DB::update('users')->set(array( 'phone'  => $phone, 'user_name' => $user_name, 'gender' => $gender, 'user_password' => md5($user_password), )) ->where('id', '=', $id)->execute();
		/*notify success*/
		Session::set('message', "edit user success");
		return Response::redirect('user/index');
	}


	/*delete acccount by id*/
	public function action_delete($id_user)
	{
		/*check login*/
		$this->action_auth(Session::get('user_id'));

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