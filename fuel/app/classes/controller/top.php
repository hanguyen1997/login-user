<?php 
class Controller_Top extends Controller_App
{
    public function action_index()
   	{
   		// check login
   		if (!$this->checkLogin() || !$this->checkLoginByToken()) {
            Response::redirect('/');
        }
   		/*set data*/
   		$data = [];
      $data['mail_address'] = Session::get("mail_address");
        
      /*phân trang*/
      $pagination = Pagination::forge('top/index', array(
        'pagination_url' => Uri::create('top/index'),
        /*tổng số phần trên url phân trang*/
        'uri_segment' => 3,

        /*tổng số hàng */
        'total_items' => DB::select('id')->from('users')->execute()->count(),

        /*tổng số hàng hiển thị trên 1 trang*/
        'per_page' => 4,
      ));
      $data['users'] = DB::select('*')
                        ->from('users')
                        ->limit($pagination->per_page)
                        ->offset($pagination->offset)
                        ->execute()
                        ->as_array();
      $data['pagination'] = $pagination->render();

     
      if(Input::get('email_search') != "") 
      {
        $data['email_search'] =  Input::get('email_search');

        $data['users'] = Model_User::search_list_user(Input::get('email_search'));
        var_dump($data['users']);
        exit;
      }

   		$this->template->content =  View::forge('member/index',$data , false);
   		$this->template->title = 'list user';
  	}
}