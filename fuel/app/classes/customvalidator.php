<?php 
use Fuel\Core\Validation;

Class CustomValidator {
        public static function validationLoginMenber() 
        {
                $val = Validation::forge();
                $val->add_callable('customvalidator');
                $val->add('mail_address', 'email')->add_rule('required');
                $val->add('password', 'password')->add_rule('required');
                return $val;
        }

        public static function validationSignUpMenber() 
        {
                $val = Validation::forge();
                $val->add('mail_address', 'mail')->add_rule('required')->add_rule('valid_email');
                $val->add('user_password')->add_rule('required')->add_rule('min_length', 3)->add_rule('max_length', 20);
                $val->add('check_password')->add_rule('required')->add_rule('min_length', 3)->add_rule('max_length', 20);
                return $val;
        }

        public static function validationCreateMenber() 
        {
                $val = Validation::forge();
                $val->add('mail_address', 'mail')->add_rule('required')->add_rule('valid_email');
                $val->add('phone', 'phone')->add_rule('required')->add_rule('max_length_cus', 10)->add_rule('valid_string', array('numeric', 'utf8'));;
                $val->add('gender', 'gender')->add_rule('required');
                $val->add('user_name', 'name')->add_rule('required');
                $val->add('user_password')->add_rule('required')->add_rule('min_length', 3)->add_rule('max_length', 20);
                $val->add('check_password')->add_rule('required')->add_rule('min_length', 3)->add_rule('max_length', 20);
                return $val;
        }

        public static function validationEditformMenber() 
        {
                $val = Validation::forge();
                $val->add('phone', 'phone')->add_rule('required')->add_rule('max_length_cus', 10)->add_rule('valid_string', array('numeric', 'utf8'));;
                $val->add('gender', 'gender')->add_rule('required');
                $val->add('user_name', 'name')->add_rule('required');
                $val->add('user_password')->add_rule('required')->add_rule('min_length', 3)->add_rule('max_length', 20);
                $val->add('check_password')->add_rule('required')->add_rule('min_length', 3)->add_rule('max_length', 20);
                return $val;
        }

        public static function validationEditMenberNoPassword() 
        {
                $val = Validation::forge();
                $val->add('phone', 'phone')->add_rule('required')->add_rule('max_length_cus', 10)->add_rule('valid_string', array('numeric', 'utf8'));;
                $val->add('gender', 'gender')->add_rule('required');
                $val->add('user_name', 'name')->add_rule('required');
                return $val;
        }
}
