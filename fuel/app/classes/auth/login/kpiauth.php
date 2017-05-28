<?php
/**
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
 * kpiauth ORM driven login driver
 *
 * @package     Fuel
 * @subpackage  Auth
 */
class Auth_Login_Kpiauth extends \Auth_Login_Driver
{
	/*
	 * Class init, load and validate the config
	 */
	public static function _init()
	{
		// load the auth config
		\Config::load('kpiauth', true);

		// deal with invalid column selections
		if ($columns = \Config::get('kpiauth.table_columns', array()) == array('*') or ! is_array($columns))
		{
			\Config::set('kpiauth.table_columns', array());
		}
		
		// setup the remember-me session object if needed
		if (\Config::get('kpiauth.remember_me.enabled', false))
		{
			static::$remember_me = \Session::forge(array(
				'driver' => 'cookie',
				'cookie' => array(
					'cookie_name' => \Config::get('kpiauth.remember_me.cookie_name', 'rmcookie'),
				),
				'encrypt_cookie' => true,
				'expire_on_close' => false,
				'expiration_time' => \Config::get('kpiauth.remember_me.expiration', 86400 * 31),
			));
		}
	}

	/**
	 * @var  \Model\Auth_User  user object for the current user
	 */
	protected $user = null;

	/**
	 * @var  array  Simpleauth compatible permissions array for the current logged-in user
	 */
	protected $permissions = array();

	/**
	 * @var  array  kpiauth class config
	 */
	protected $config = array(
		
	);
	
	/**
	 * Check the user exists
	 *
	 * @return  bool
	 */
	public function validate_user($username_or_email = '', $password = '')
	{
		// get the user identification and password
		$username_or_email = trim($username_or_email) ?: trim(\Input::post(\Config::get('kpiauth.username_post_key', 'user_name')));
		$password = trim($password) ?: trim(\Input::post(\Config::get('kpiauth.password_post_key', 'user_password')));

		// and make sure we have both
		if (empty($username_or_email) or empty($password))
		{
			return false;
		}
		
		// hash the password
		//$password = $this->hash_password($password);

		// and do a lookup of this user
		$user = \Model_User::query()
			->select(\Config::get('kpiauth.table_columns', array()))
			->where_open()
				->where('user_name', '=', $username_or_email)
			->where_close()
			->where('user_password', '=', $password)
			->get_one();
		// return the user object, or false if not found
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
			// force a logout
			$this->logout();

			// and signal a failed login
			return false;
		}

		// register so Auth::logout() can find us
		Auth::_register_verified($this);

		// store the logged-in user and it's hash in the session
		\Session::set('user_name', $this->user->user_name);
		\Session::set('user', $this->user);

		// and rotate the session id, we've elevated rights
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
		// bail out if we don't have a user
		if (empty($user_id))
		{
			return false;
		}

		// get the user we need to login
		if ( ! $user_id instanceOf \Model\Auth_User)
		{
			$this->user = \Model__User::query()
				->select(\Config::get('kpiauth.table_columns', array()))
				->where('id', '=', $user_id)
				->get_one();
		}
		else
		{
			$this->user = $user_id;
		}

		// did we find it
		if ($this->user and ! $this->user->is_new())
		{
			// store the logged-in user and it's hash in the session
			\Session::set('user_name', $this->user->username);
			\Session::set('user', $this->user);

			// and rotate the session id, we've elevated rights
			\Session::instance()->rotate();

			return true;
		}

		// force a logout
		$this->logout();

		// and signal a failed login
		return false;
	}

	/**
	 * Logout user
	 *
	 * @return  bool
	 */
	public function logout()
	{
		// reset the current user
		if (\Config::get('kpiauth.guest_login', true))
		{
			$this->user = \Model_User::query()
				->where('id', '=', 0)
				->get_one();
		}
		else
		{
			$this->user = false;
		}
		

		// delete the session data identifying this user
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
		// prep the password
		$password = trim($password);
		$code = trim($profile_fields['code']);
		
		// bail out if we're missing username, password or email address
		if (empty($code))
		{
			throw new \SimpleUserUpdateException('Username, password or code  is not given', 1);
		}
		
		// check if we already have an account with this email address or username
		$duplicate = \Model_User::query()
			->select(\Config::get('kpiauth.table_columns', array()))
			->where('code', '=', $code)
			->or_where_open()
			->where('user_name', '!=', '')
			->where('user_name', '=', $username)
			->or_where_close()
			->get_one();

		// did we find one?
		if ($duplicate)
		{
			// bail out with an exception
			if (strtolower($code) == strtolower($duplicate->code))
			{
				throw new \SimpleUserUpdateException('Code already exists', 2);
			}
			else
			{
				throw new \SimpleUserUpdateException('Username already exists', 3);
			}
		}
		
		// do we have a logged-in user?
		if ($currentuser = \Auth::get_user_id())
		{
			$currentuser = $currentuser[1];
		}
		else
		{
			$currentuser = 0;
		}

		// create the new user record
		$user = \Model_User::forge(array(
			'user_name'      => (string) $username,
			'user_password'  => $password?$this->hash_password((string) $password):''
		));
		
		// load all additional data, passed as profile fields
		$user->from_array($profile_fields);
		
		// save the new user record
		try
		{
			$result = $user->save();
		}
		catch (\Exception $e)
		{
			$result = false;
		}
		
		// and the id of the created user, or false if creation failed
		return $result ? $user->id : false;
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
		// if no username is given, fetch the current user's namd
		$username = $username ?: $this->user->user_id;

		// get the current user record
		$current_values = \Model_User::query()
			->select(\Config::get('kpiauth.table_columns', array()))
			->where('id', '=', $username)
			->get_one();

		// and bail out if it doesn't exist
		if (empty($current_values))
		{
			throw new \SimpleUserUpdateException('user id not found', 4);
		}

		// validate the values passed and assume the update array
		$update = array();
		if (array_key_exists('id', $values))
		{
			throw new \SimpleUserUpdateException('user id cannot be changed.', 5);
		}
	
		// load the updated values into the object
		$current_values->from_array($update);

		$updated = false;

		// any values remaining?
		if ( ! empty($values))
		{
			// set them as EAV values
			foreach ($values as $key => $value)
			{
				if ( ! isset($current_values->{$key}) or $current_values->{$key} != $value)
				{
					if ($value === null)
					{
						unset($current_values->{$key});
					}
					else
					{
						$current_values->{$key} = $value;
					}

					// mark we've updated something
					$updated = true;
				}
			}
		}

		// check if this has changed anything
		if ($updated or $updated = $current_values->is_changed())
		{
			// and only save if it did
			$current_values->save();
		}

		// return the updated status
		return $updated;
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
		// use the update_user method to change the password
		try
		{
			return (bool) $this->update_user(array('old_password' => $old_password, 'password' => $new_password), $username);
		}
		// only catch the wrong password exception
		catch (SimpleUserWrongPassword $e)
		{
			return false;
		}
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
		// get the user object
		$user = \Model\Auth_User::query()
			->select(\Config::get('kpiauth.table_columns', array()))
			->where('username', '=', $username)
			->get_one();

		// and bail out if not found
		if ( ! $user)
		{
			throw new \SimpleUserUpdateException('Failed to reset password, user was invalid.', 8);
		}

		// generate a new random password
		$new_password = \Str::random('alnum', 8);
		$user->password = $this->hash_password($new_password);

		// store the updated password hash
		$user->save();

		// and return the new password
		return $new_password;
	}

	/**
	 * Deletes a given user
	 *
	 * @param   string
	 * @return  bool
	 */
	public function delete_user($username)
	{
		// make sure we have a user to delete
		if (empty($username))
		{
			throw new \SimpleUserUpdateException('Cannot delete user with empty username', 9);
		}

		// get the user object
		$user = \Model_User::query()
			->select('id')
			->where('id', '=', $username)
			->get_one();

		// if it was found, delete it
		if ($user)
		{
			$user->deleted = 1;
			return (bool) $user->save();
		}
		return false;
	}

	/**
	 * Creates a temporary hash that will validate the current login
	 *
	 * @return  string
	 */
	public function create_login_hash()
	{
		// we need a logged-in user to generate a login hash
		if (empty($this->user))
		{
			throw new \SimpleUserUpdateException('User not logged in, can\'t create login hash.', 10);
		}

		// set the previous and current last login
		$this->user->previous_login = $this->user->last_login;
		$this->user->last_login = \Date::forge()->get_timestamp();

		// generate the new hash
		$this->user->login_hash = sha1(\Config::get('kpiauth.login_hash_salt').$this->user->username.$this->user->last_login);

		// store it
		$this->user->save();

		// and return it
		return $this->user->login_hash;
	}

	/**
	 * Get the user object
	 *
	 * @return  mixed  Model\Auth_User object, or false if no user is set
	 */
	public function get_user()
	{
		return empty($this->user) ? false : $this->user;
	}

	/**
	 * Get the user's ID
	 *
	 * @return  Array  containing this driver's ID & the user's ID
	 */
	public function get_user_id()
	{
		// bail out if we don't have a user to return
		if (empty($this->user))
		{
			return false;
		}

		return array($this->user, (int) $this->user->id);
	}

	/**
	 * Get the user's groups
	 *
	 * @return  Array  containing the group driver ID & the user's group ID
	 */
	public function get_groups()
	{
		var_dump('test');die();
		// bail out if we don't have a user group to return
		if (empty($this->user))
		{
			return false;
		}

		return array(array('Ormgroup', $this->user->group));
	}

	/**
	 * Getter for user data.
	 *
	 * @param  string  name of the user field to return
	 * @param  mixed  value to return if the field requested does not exist
	 *
	 * @return  mixed
	 */
	public function get($field, $default = null)
	{
		// if it's an object property, return it, else return the default
		return isset($this->user->{$field}) ? $this->user->{$field} : $default;
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
		return $this->get('username', false);
	}

	/**
	 * for compatibility, will map to the user metadata
	 *
	 * @return  Array
	 */
	public function get_profile_fields($field = null, $default = null)
	{
		// collect all meta data
		$profile_fields = array();

		foreach ($this->user->metadata as $metadata)
		{
			if (empty($field))
			{
				$profile_fields[$metadata->key] = $metadata->value;
			}
			elseif ($field == $metadata->key)
			{
				return $metadata->value;
			}
		}

		// return the connected data
		return empty($profile_fields) ? $default : $profile_fields;
	}

	/**
	 * Extension of base driver method to default to user group instead of user id
	 */
	public function has_access($condition, $driver = null, $user = null)
	{
		if (is_null($user))
		{
			//$groups = $this->get_groups();
			//$user = reset($groups);
		}
		return parent::has_access($condition, $driver, $user);
	}

	/**
	 * Extension of base driver because this supports a guest login when switched on
	 */
	public function guest_login()
	{
		return \Config::get('kpiauth.guest_login', true);
	}

	/**
	 * Check for login
	 *
	 * @return  bool
	 */
	protected function perform_check()
	{
		// get the username and login hash from the session
		$username    = \Session::get('user_name');
		//$login_hash  = \Session::get('login_hash');

		// only worth checking if there's both a username and login-hash
		//if ( ! empty($username) and ! empty($login_hash))
		if ( ! empty($username))
		{
			// if we don't have a user, or we're logging in from guest mode
			if (is_null($this->user) or ($this->user->user_name != $username and $this->user->id == 0))
			{
				// find the user
				$this->user = \Model_User::query()
					->select(\Config::get('kpiauth.table_columns', array()))
					//->related('metadata')
					->where('user_name', '=', $username)
					->get_one();
			}

			// return true when login was verified, and either the hash matches or multiple logins are allowed
			//if ($this->user and (\Config::get('kpiauth.multiple_logins', false) or $this->user['login_hash'] === $login_hash))
			if ($this->user)
			{
				return true;
			}
		}

		// not logged in, do we have remember-me active and a stored user_id?
		elseif (static::$remember_me and $user_id = static::$remember_me->get('id', null))
		{
			return $this->force_login($user_id);
		}

		// force a logout
		$this->logout();

		return false;
	}
}
