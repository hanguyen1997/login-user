<?php 
class Controller_Member extends Controller_App
{
	/*show form add and edit*/
  public function action_form($id)
 	{
   	// check login
    if (!$this->checkLogin() || !$this->checkLoginByToken()) Response::redirect('/');

    /*set data*/
    $data = [];
  	$data['mail_address'] = "";
  	$data['phone'] = "";
  	$data['gender'] = "";
  	$data['name'] = "";
  	$data['id'] = "";
  	$data['title'] = "Add user";
  	$data['button'] = "Create";
  	
    /*check $data is number id user render form edit*/
  	if(is_numeric($id))
  	{
      /*check id user*/    
  		$user = DB::select('*')
  				->from('users')
  				->where("id", $id)
  				->limit(1)
  				->execute()
  				->as_array();
  		if($user != null) 
  		{
        /*id user sussec*/
  			$data['mail_address'] = $user['0']['mail_address'];
  			$data['gender'] = $user['0']['gender'];
  			$data['phone'] = $user['0']['phone'];
  			$data['name'] = $user['0']['name'];
  			$data['id'] = $id;
  			$data['title'] = "Edit user";
  			$data['button'] = "Edit";
  		}
  	}
  	$this->template->content =  View::forge('member/form', $data);
	}

  /*xư lí data từ form gửi lên*/
	public function action_send_data()
	{
    // check login
    if (!$this->checkLogin() || !$this->checkLoginByToken()) Response::redirect('/');

    /*get data*/
		$data = Input::Post();
		if($data['id'] != "")
		{
			//edit user
			$this->action_edit($data);
			/*false*/
			return Response::redirect('member/form/'.$data['id']);
		}else 
    {
			/*create*/
      $this->action_add($data);
      /*create false*/
      return Response::redirect('member/form/add');
		}
	}

  /*add new member*/
  public function action_add($data)
  {
    // check login
    if (!$this->checkLogin() || !$this->checkLoginByToken()) Response::redirect('/');

    if($data['user_password'] != $data['check_password']) return Response::redirect('member/form/add');
    /*validate create user*/
    $validate = CustomValidator::validationCreateMenber();
    if($validate->run()){
      /*CHECK EMAIL*/
      $check_email = Model_User::get_email_user($data['mail_address']);
      if(!$check_email)
      {
        $create_user = Model_User::create_user($data);
        /*notyfy to form*/
        Session::set('message', "Add success");
        return Response::redirect('top/index');
      }else
      {
        /*notyfy to form*/
        Session::set('message', "email sã tồn tại");
      }
    }
      /*notyfy error validate*/
      Session::set('message', "Thông tin không hợp lệ");
  }

  /*edit member*/
  public function action_edit($data)
  {
    // check login
    if (!$this->checkLogin() || !$this->checkLoginByToken()) Response::redirect('/');

    if($data['user_password'] != "" )
    { 
      if($data['user_password'] != $data['check_password']) return Response::redirect('member/form/'.$data['id']);
      
      /*validate data edit include password*/
      $validate = CustomValidator::validationEditformMenber();
      if($validate->run())
      {
        $eidt_user = Model_User::edit_user($data);
        /*notyfy return view*/
        Session::set('message', "Edit success");
        return Response::redirect('top/index');
      }
    }else 
    {
      /*validate data edit no password*/
      $validate = CustomValidator::validationEditMenberNoPassword();
      if($validate->run())
      {
        $eidt_user = Model_User::edit_user($data);

        /*notyfy return view*/
        Session::set('message', "Edit success");
        return Response::redirect('top/index');
      }
    }
    /*notyfy error validate*/
    Session::set('message', "Thông tin không hợp lệ");
  }

  /*del user*/
  public function action_del($id_user)
 	{
 	  // check login
    if (!$this->checkLogin() || !$this->checkLoginByToken()) Response::redirect('/');

    if(isset($id_user) ?? "") DB::delete('users')->where('id', $id_user)->execute(); 
  
    /* message sussec and redirect page list user*/
    Session::set('message', "Delete member success");
    return Response::redirect('top/index');
	}

  public function action_detail($id)
  {
    // check login
    if (!$this->checkLogin() || !$this->checkLoginByToken()) Response::redirect('/');

    /*set data*/
    $data = [];

    $user = DB::select("*")
                  ->from('users')
                        ->where('users.id', $id)
                        ->execute()
                  ->current();
    if(!$user) return Response::redirect('top/index');
    else{
      $data['user'] = $user;
    }

    $this->template->content =  View::forge('member/detail',$data, false);
    $this->template->title = 'detail  |  user';
  }
}