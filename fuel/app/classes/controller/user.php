<?php 
use Auth\Auth;

class Controller_User extends Controller_app
{
  public function action_login()
 	{
 		/*set data send view*/
 		$data = [];
 		$token = null;
    if(Session::get("token") != "") $token = Session::get("token");
    if(Cookie::get("token") != "" && Session::get("token") == "") $token = Cookie::get("token");

    $member = Model_User::get_current_user($token);
   	if ($token != null && $member)  Response::redirect('top/index'); 

    /*check data form*/
    if (Input::method() == 'POST') 
    { 
    	$dataLogin = Input::post();
      $data['dataLogin'] = $dataLogin;
    	$validate = CustomValidator::validationLoginMenber();
    	if($validate->run())
    	{
    		/*check login*/
    		$getUser = Model_User::check_login($dataLogin);
    		if(empty($getUser)) 
    		{
    			$data['errors'] = ["Xác thực thất bại"];
    		} else
    		{
    			/*set token*/
    			$token = Security::generate_token();
    			$result = DB::update('users')->value("token", $token)->value("updated_at", date("Y-m-d H:i:s"))->where('id', '=', $getUser['id'])->execute();
          /*set session user*/
          Session::set("token", $token);
          Session::set("mail_address", $getUser['mail_address']);
          if(isset($dataLogin['remember_password'])) 
          {
            Cookie::set('token', $token, 60 * 60 * 24 * 30);
    			}
          /*notyfy return view*/
          Session::set('message', "Login success");
          return Response::redirect('top/index'); 
    		} 
    	}
    	else {
    		// send error view
    		$errors = $validate->error();
        $data['errors'] = $errors;
    	}
    }   	
		$this->template->content =  View::forge('login',$data, false);
		$this->template->title = 'login  |  user';
  }

  public function action_logout()
	{
		// check login
		if (!$this->checkLogin() || !$this->checkLoginByToken()) Response::redirect('/');

    $token = Session::get("token");
    $member = Model_User::get_current_user($token);
    if ($token != null && $member)
    {
      DB::update('users')->set(['token' => null, 'updated_at' => date('Y-m-d H:i:s')])->where('id', $member['id'])->execute();
      Session::destroy();
      Cookie::delete('token');
      Response::redirect('/');
    }
  }

  public function action_signup()
  {
    /*set data*/
    $data = [];

    /*check data form*/
    if (Input::method() == 'POST') 
    { 
      $dataSignup = Input::post();
      $data['dataSignup'] = $dataSignup;
      $validate = CustomValidator::validationSignUpMenber();
      if($validate->run())
      {
        /*signup sussec*/
        if($dataSignup['user_password'] == $dataSignup['check_password']) 
        {
          /*CHECK EMAIL*/
          $check_email = Model_User::get_email_user($dataSignup['mail_address']);
          if(!$check_email)
          {
            Model_User::signup_user($dataSignup);
            return Response::redirect('user/login');
          }
          $data['errors']['email'] = 'email error';
        }
        $data['errors']['password'] = 'check password';
      }
      else{
        $errors = $validate->error();
        $data['errors'] = $errors;
      }
    }
    $this->template->content =  View::forge('signup',$data, false);
    $this->template->title = 'signup | user';
  }

  public function action_check_email()
  {
    $check = "false";
    if(Input::post('mail_address') != "")
    {
      $val = Validation::forge();
      $val->add('mail_address')->add_rule('required')->add_rule('valid_email');
      if($val->run())
      {
        $check_user_email = Model_User::get_email_user(Input::post('mail_address'));
        if(!$check_user_email) $check = "true";
      }
    }
    return $check;
  }
}