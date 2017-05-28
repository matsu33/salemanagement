<?php

/**
 * User utility
 * 
 * @author Nguyen Van Tung
 * @since 2014/12/02
 */
class Auth
{
	public static function login ($username, $password)
	{
		if(!$username || !$password){
			return false;
		}
		if($username != 'admin' || $password != 'admin'){
			return false;
		}
		//TODO: save session
		$user = array('username' => $username, 'password' => $password);
		Session::set('user', $user);
		
		return true;
	}
	/**
	 * validate username and password
	 * 
	 * @param unknown $username        	
	 * @param unknown $password        	
	 * @return boolean
	 */
	public static function checkUser ($username, $password)
	{
		if(!$username || !$password){
			return false;
		}
		if($username != 'admin' || $password != 'admin'){
			return false;
		}
		return true;
	}

	/**
	 * logout
	 */
	public static function logout ()
	{
		Session::set('user', null);
		return true;
	}

	/**
	 * check user login or not
	 */
	public static function checkLogin ()
	{
		$user = \Session::get('user');
		
		if($user){
			$username = $user['username'];
			$password = $user['password'];
			if($username == 'admin' && $password == 'admin'){
				return true;
			}
		}
		
		return false;
	}
}	