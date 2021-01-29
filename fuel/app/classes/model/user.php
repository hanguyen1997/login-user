<?php 
class Model_User extends Orm\Model{
	protected static $_primary_key = array('id');
	protected static $_protected = array(
		"id",
		"user_name",
		"user_password",
		"usser_name",
		"phone",
		"gender"
	)
}