<?php 

use Fuel\Core\Session; 

class Controller_Home extends Controller
{
	/*show login*/
	public function action_show_login()
	{
		/*check cookie*/
		$this->action_check_cookie();

		/*return view*/
		return Response::forge(View::forge('home/login'));
	}
	/*end: function action_index()*/

	/*check cookie*/
	public function action_check_cookie()
	{
		if(isset($_COOKIE["user_email"]) && isset($_COOKIE["user_password"]))  $this->action_auth_login($_COOKIE["user_email"], $_COOKIE["user_password"]);
		/*end: if(isset($_COOKIE["user_email"]) && isset($_COOKIE["user_password"]))*/
	}
	/*end: function action_check_cookie()*/

	/*show registration*/
	public function action_show_registration()
	{
		/*return view*/
		return Response::forge(View::forge('home/registration'));
	}
	/*end: public function action_index()*/

	/*get data form registration*/
	public function action_registration()
	{
		/*validate data*/
	  	$val = Validation::forge();
	  	$val->add('user_email')->add_rule('required')->add_rule('valid_email') ; 
		$val->add('user_password')->add_rule('required')->add_rule('min_length', 3)->add_rule('max_length', 20); 
		$val->add('check_password')->add_rule('required')->add_rule('min_length', 3)->add_rule('max_length', 20);

		if($val->run())
		{
			/*get data*/
			$user_email = Input::post('user_email');
			$user_password = Input::post('user_password');
			$check_password = Input::post('check_password');

			/*query check email already exists and check password*/
			$check_user_email = DB::select('user_email')->from('users')->where('user_email', '=', $user_email)->execute();
			if(($check_user_email->as_array() != null) || ($user_password != $check_password))
			{
				/*error message*/
				return Response::redirect('registration');
			}
			/*end: if(($check_user_email->as_array() != null) || ($user_password != $check_password))*/

			/*query insert account*/
			DB::insert('users')->set(array(
				    'user_email' => $user_email,
				    'user_password' => md5($user_password),
				    ))->execute();
			
			/*sussec*/
			return Response::redirect('login');
		}
		/*end: if($val->run())*/

		/*error message*/
		return Response::redirect('registration');
	}
	/*end: function action_index()*/

	/*check login*/
	public function action_check_login()
	{
	    /*validate data*/
	  	$val = Validation::forge();
	  	$val->add('user_email')->add_rule('required')->add_rule('valid_email') ; 
		$val->add('user_password')->add_rule('required')->add_rule('min_length', 3)->add_rule('max_length', 20); 

	 	if($val->run())
		{
			/*get data*/
			$user_email = Input::post('user_email');
			$user_password = Input::post('user_password');
			$remember_account = Input::post('remember');

			/*set cookie*/
			if($remember_account == "on")
			{
				Cookie::set('user_email', $user_email, 60 * 2);
				Cookie::set('user_password', $user_password, 60 * 2);
			}
			/*end: if($remember_account == "on")*/

			// validation succeeds
			$this->action_auth_login($user_email, $user_password);
		}
		// end: if($val->run())

		//accout failed
		return Response::redirect('login');
	}
	/*end: function action_index()*/

	/*login account*/
	public function action_auth_login($user_email, $user_password)
	{
		$user = DB::select()->from('users')->where('user_email', $user_email)->where('user_password', md5($user_password))->execute()->as_array();
		if($user != null) 
		{

			$user_id = $user[0]['id'];
			$user_email = $user[0]['user_email'];

			// Session::instance()->rotate();
			// Session::set('user_id', $user_id);
			Session::set('user_email', $user_email);
			

			Response::redirect('user/index');
		}
		/*end: if($user->as_array() != null)*/
	}
	/*function action_auth_login($user_email, $user_password)*/ 

	/*check out account*/
	public function action_logout()
	{
		
		/*return view*/
		return Response::forge(View::forge('home/login'));
	}
	/*end: function action_logout()*/
}
/*end: class Controller_Home extends Controller*/