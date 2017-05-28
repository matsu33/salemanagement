<?php
/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2014 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Auth;

/**
 * SimpleAuth basic login driver
 *
 * @package     Fuel
 * @subpackage  Auth
 */
class Auth_Login_OmssAuth extends \Auth_Login_Driver
{
	/**
	 * Load the config and setup the remember-me session if needed
	 */
	public static function _init()
	{
		\Config::load('omss_auth', true);

		// setup the remember-me session object if needed
		if (\Config::get('brsauth.remember_me.enabled', false))
		{
			static::$remember_me = \Session::forge(array(
				'driver' => 'cookie',
				'cookie' => array(
					'cookie_name' => \Config::get('brsauth.remember_me.cookie_name', 'rmcookie'),
				),
				'encrypt_cookie' => true,
				'expire_on_close' => false,
				'expiration_time' => \Config::get('brsauth.remember_me.expiration', 86400 * 31),
			));
		}
	}

	/**
	 * @var  Database_Result  when login succeeded
	 */
	protected $user = null;

	/**
	 * @var  array  value for guest login
	 */
	protected static $guest_login = array(
		'user_id' => 0,
		'user_name' => 'guest',
		'user_nickname' => 'guest',
		'user_type' => '0',
	);

	/**
	 * @var  array  SimpleAuth class config
	 */
	protected $config = array(
		//'drivers' => array('group' => array('Simplegroup')),
		//'additional_fields' => array('profile_fields'),
	);

	/**
	 * Check for login
	 *
	 * @return  bool
	 */
	protected function perform_check()
	{
		// fetch the username and login hash from the session
		$username = \Session::get('user_name');

		// only worth checking if there's both a username and login-hash
		if ( ! empty($username))
		{
			if (is_null($this->user) or ($this->user['user_name'] != $username and $this->user != static::$guest_login))
			{
				$this->user = \DB::select_array(\Config::get('brsauth.table_columns', array('*')))
					->where('user_name', '=', $username)
					->from(\Config::get('brsauth.table_name'))
					->execute(\Config::get('brsauth.db_connection'))->current();
			}

			// return true when login was verified, and either the hash matches or multiple logins are allowed
			//if ($this->user and (\Config::get('brsauth.multiple_logins', false) or $this->user['login_hash'] === $login_hash))
			if ($this->user and (\Config::get('brsauth.multiple_logins', false)))
			{
				return true;
			}
		}

		// not logged in, do we have remember-me active and a stored user_id?
		elseif (static::$remember_me and $user_id = static::$remember_me->get('user_id', null))
		{
			return $this->force_login($user_id);
		}

		// no valid login when still here, ensure empty session and optionally set guest_login
		$this->user = \Config::get('brsauth.guest_login', true) ? static::$guest_login : false;
		\Session::delete('user_name');
		\Session::delete('user');

		return false;
	}

	/**
	 * Check the user exists
	 *
	 * @return  bool
	 */
	public function validate_user($username_or_email = '', $password = '')
	{
		$username_or_email = trim($username_or_email) ?: trim(\Input::post(\Config::get('brsauth.username_post_key', 'user_name')));
		$password = trim($password) ?: trim(\Input::post(\Config::get('brsauth.password_post_key', 'password')));
		if (empty($username_or_email) or empty($password))
		{
			return false;
		}

		$password = $this->hash_password($password);
		$user = \DB::select_array(\Config::get('brsauth.table_columns', array('*')))
			->where_open()
			->where('user_name', '=', $username_or_email)
			->where('user_password', '=', $password)
			->where_close()
			->where_open()
			->where('user_delate_status', 'is', NULL)
			->or_where('user_delate_status', '<>', \Controller_Base::IS_DELETE)
			->where_close()
			->from(\Config::get('brsauth.table_name'))
			->execute(\Config::get('brsauth.db_connection'))->current();

		return $user ?: false;
	}

	/**
	 * Login user
	 *
	 * @param   string
	 * @param   string
	 * @return  bool
	 */
	public function login($username_or_email = '', $password = '')
	{
		if ( ! ($this->user = $this->validate_user($username_or_email, $password)))
		{
			$this->user = \Config::get('brsauth.guest_login', true) ? static::$guest_login : false;
			\Session::delete('user_name');
			\Session::delete('user');
			return false;
		}

		// register so Auth::logout() can find us
		Auth::_register_verified($this);

		\Session::set('user_name', $this->user['user_name']);
		\Session::set('user', $this->user);

		\Session::instance()->rotate();
		return true;
	}

	/**
	 * Force login user
	 *
	 * @param   string
	 * @return  bool
	 */
	public function force_login($user_id = '')
	{
		if (empty($user_id))
		{
			return false;
		}

		$this->user = \DB::select_array(\Config::get('brsauth.table_columns', array('*')))
			->where_open()
			->where('user_id', '=', $user_id)
			->where_close()
			->from(\Config::get('brsauth.table_name'))
			->execute(\Config::get('brsauth.db_connection'))
			->current();

		if ($this->user == false)
		{
			$this->user = \Config::get('brsauth.guest_login', true) ? static::$guest_login : false;
			\Session::delete('user_name');	
			\Session::delete('user');	

			return false;
		}

		\Session::set('user_name', $this->user['user_name']);
		\Session::set('user', $this->user);
		return true;
	}

	/**
	 * Logout user
	 *
	 * @return  bool
	 */
	public function logout()
	{
		$this->user = \Config::get('brsauth.guest_login', true) ? static::$guest_login : false;
		\Session::delete('user_name');
		\Session::delete('user');
		return true;
	}

	/**
	 * Create new user
	 *
	 * @param   string
	 * @param   string
	 * @param   string  must contain valid email address
	 * @param   int     group id
	 * @param   Array
	 * @return  bool
	 */
	public function create_user($username, $password, $email, $group = 1, Array $profile_fields = array())
	{
		$insertResult = \DB::insert('user_tbl')->set($profile_fields)->execute();
		if ($insertResult) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Update a user's properties
	 * Note: Username cannot be updated, to update password the old password must be passed as old_password
	 *
	 * @param   Array  properties to be updated including profile fields
	 * @param   string
	 * @return  bool
	 */
	public function update_user($values, $username = null)
	{
		$updateResult = \DB::update('user_tbl')
						->set($values)
						->where('user_name', '=', $username)
				    	->execute();
		if ($updateResult) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Change a user's password
	 *
	 * @param   string
	 * @param   string
	 * @param   string  username or null for current user
	 * @return  bool
	 */
	public function change_password($old_password, $new_password, $username = null)
	{

	}

	/**
	 * Generates new random password, sets it for the given username and returns the new password.
	 * To be used for resetting a user's forgotten password, should be emailed afterwards.
	 *
	 * @param   string  $username
	 * @return  string
	 */
	public function reset_password($username)
	{

	}

	/**
	 * Deletes a given user
	 *
	 * @param   string
	 * @return  bool
	 */
	public function delete_user($username)
	{
		$time = date('Y-m-d h:i:s');
		$currentUser = \Session::get('user');
		$result = \DB::update('user_tbl')
			    ->set(array(
			        'user_delate_date' => $time,
			        'user_delate_status' => '1',
			        'user_update_user' => $currentUser['user_id'],
			    ))
			    ->where('user_name', '=', $username)
			    ->execute();
		if (count($result)) {
			return true;

		} else {
			return false;
		}
	}

	/**
	 * Creates a temporary hash that will validate the current login
	 *
	 * @return  string
	 */
	public function create_login_hash()
	{

	}

	/**
	 * Get the user's ID
	 *
	 * @return  Array  containing this driver's ID & the user's ID
	 */
	public function get_user_id()
	{
		if (empty($this->user))
		{
			return false;
		}

		return array($this->id, (int) $this->user['user_id']);
	}

	/**
	 * Get the user's groups
	 *
	 * @return  Array  containing the group driver ID & the user's group ID
	 */
	public function get_groups()
	{
		if (empty($this->user))
		{
			return false;
		}

		return array(array('Simplegroup', $this->user['group']));
	}

	/**
	 * Getter for user data
	 *
	 * @param  string  name of the user field to return
	 * @param  mixed  value to return if the field requested does not exist
	 *
	 * @return  mixed
	 */
	public function get($field, $default = null)
	{
		if (isset($this->user[$field]))
		{
			return $this->user[$field];
		}
		elseif (isset($this->user['profile_fields']))
		{
			return $this->get_profile_fields($field, $default);
		}

		return $default;
	}

	/**
	 * Get the user's emailaddress
	 *
	 * @return  string
	 */
	public function get_email()
	{
		return $this->get('email', false);
	}

	/**
	 * Get the user's screen name
	 *
	 * @return  string
	 */
	public function get_screen_name()
	{
		if (empty($this->user))
		{
			return false;
		}

		return $this->user['user_name'];
	}

	/**
	 * Get the user's profile fields
	 *
	 * @return  Array
	 */
	public function get_profile_fields($field = null, $default = null)
	{
		if (empty($this->user))
		{
			return false;
		}

		if (isset($this->user['profile_fields']))
		{
			is_array($this->user['profile_fields']) or $this->user['profile_fields'] = (@unserialize($this->user['profile_fields']) ?: array());
		}
		else
		{
			$this->user['profile_fields'] = array();
		}

		return is_null($field) ? $this->user['profile_fields'] : \Arr::get($this->user['profile_fields'], $field, $default);
	}

	/**
	 * Extension of base driver method to default to user group instead of user id
	 */
	public function has_access($condition, $driver = null, $user = null)
	{
		if (is_null($user))
		{
			$groups = $this->get_groups();
			$user = reset($groups);
		}
		return parent::has_access($condition, $driver, $user);
	}

	/**
	 * Extension of base driver because this supports a guest login when switched on
	 */
	public function guest_login()
	{
		return \Config::get('brsauth.guest_login', true);
	}
}

// end of file simpleauth.php
