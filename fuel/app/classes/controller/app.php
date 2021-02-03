<?php 

class Controller_App extends Controller_Template
{
    public function checkLogin() {
        $token = Session::get("token");
        if (!$token) {
            Session::delete('token');
            Session::delete('auto_login');
            Cookie::delete('token');
            return false;
        }
        return true;
    }

    public function checkLoginByToken() {
        $token = Session::get("token");
        $member = Model_User::get_current_user($token);
        if (!$token || !$member) {
            Session::delete('token');
            Session::delete('auto_login');
            Cookie::delete('token');
            return false;
        }
        return true;
    }
}