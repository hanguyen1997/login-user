<?php

class Model_User extends \Orm\Model
{
	protected static $_properties = array(
		"id" => array(
			"label" => "Id",
			"data_type" => "int",
		),
		"token" => array(
			"label" => "Token",
			"data_type" => "varchar",
		),
		"mail_address" => array(
			"label" => "Mail adress",
			"data_type" => "varchar",
		),
		"name" => array(
			"label" => "Name",
			"data_type" => "varchar",
		),
		"phone" => array(
			"label" => "phone",
			"data_type" => "int(12)",
		),
		"gender" => array(
			"label" => "gender",
			"data_type" => "tinyint(1)",
		),
		"password" => array(
			"label" => "Password",
			"data_type" => "varchar",
		),
	);

	public static function check_login($data){
		if (empty($data)) {
			return "";
		}
		$pass = md5($data['password']);
		return DB::select("*")
			->from('users')
			->where('users.password', $pass)
			->where('users.mail_address', $data['mail_address'])
			->execute()->current();
	}

	public static function get_current_user($token){
		if(is_null($token)) {
			return "";
		}
		return DB::select("*")
			->from('users')
            ->where('users.token', $token)
            ->execute()
			->current();
	}

	public static function get_user_by_id($id){
		if(is_null($id)) {
			return "";
		}
		return DB::select("*")
			->from('users')
            ->where('users.id', $id)
            ->execute()
			->current();
	}

	public static function search_list_user($search){
		return DB::select('*')
		->from('users')
		->where('mail_address', 'LIKE', '%'.$search.'%')
		->execute()
		->as_array();
	}

	public static function edit_user($data){
		/*check id user*/
		$check_user = DB::select('*')
				->from('users')
				->where('users.id', $data['id'])
				->execute()
				->as_array();

		if($check_user == null) return "";
		else
		{
			if($data['user_password'] != null)
			{
				return DB::update('users')
			    ->value("name", $data['user_name'])
			    ->value("phone", $data['phone'])
			    ->value("gender", $data['gender'])
			    ->value("password", md5($data['user_password']))
			    ->where('id', '=', $data['id'])
			    ->execute();
			}else
			{
			    return DB::update('users')
			    ->value("name", $data['user_name'])
			    ->value("phone", $data['phone'])
			    ->value("gender", $data['gender'])
			    ->where('id', '=', $data['id'])
			    ->execute();
			}
		}
	}

	public static function create_user($data){
		return DB::insert('users')->set(array(
				    'name' => $data['user_name'],
				    'phone' => $data['phone'],
				    'gender' => $data['gender'],
				    'password' => md5($data['user_password']),
				    'mail_address' => $data['mail_address'],
				    'created_at' => date("Y-m-d H:i:s"),
				))->execute();
	}

	public static function get_email_user($user_email){
		return  DB::select('*')
				->from('users')
				->where('mail_address', $user_email)
				->execute()
				->current();
	}

	public static function signup_user($data){
		return  DB::insert('users')->set(array(
				    'password' => md5($data['user_password']),
				    'mail_address' => $data['mail_address'],
				))->execute();
	}
}