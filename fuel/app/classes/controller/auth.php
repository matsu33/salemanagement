<?php
use Fuel\Core\Lang;
use Fuel\Core\View;
class Controller_Auth extends Controller_Hybrid
{
	//set template
	public $template = 'template_login';
	protected $require_auth;
	
	public function before ()
	{
		parent::before();

		if (! $this->is_restful()) {
			$isLogined  = \Auth::check();
			if($isLogined){
				$currentUser = \Session::get('user');
				
				//get user role
				$userRole = $currentUser->role;
				
				//var_dump($currentUser);exit;
				if($userRole == Constant::ROLE_ADMIN){
					Response::redirect('home/index');
				}else if($userRole == Constant::ROLE_USER){
					Response::redirect('banhang/index');
				}
				
			}
			
			//http://peter.sh/experiments/asynchronous-and-deferred-javascript-execution-explained/
			//for asyn loading js
			$scriptAttr = array(
				'defer'
			);
			
			$arrCSS = array('libs/bootstrap.min.css', 'style.css');
			$arrJS = array('libs/jquery.min.js', 
							'libs/bootstrap/js/bootstrap.min.js',
							//using for validate
							'libs/jquery-validation/jquery.validate.js',
							'libs/jquery-validation/localization/messages_vi.js',
							
							//create template in js
							'libs/doT/doT.min.js',
							'libs/omss/template.js',
							
							//utility omss
							'libs/omss/omss.js',
							
							//current page
							'login.js');
			
			// Load common css
			Asset::css($arrCSS, $scriptAttr, 'login_css', false);
			
			//Load js
			Asset::js($arrJS, $scriptAttr, 'login_script', false);
		}
	}
	
	/*
	 * Index action
	 */
	public function action_index()
	{
// 		Dbhelper::backup();
		// TODO default api
		// echo APPPATH . 'classes/auth/login/kpiauth.php';
		// return null;
		$data["subnav"] = array('index'=> 'active' );
		$this->template->title = Lang::get('title_login');
		$this->template->content = View::forge('auth/index', $data);
	}
	
	/*
	 * Login action
	 */
	public function action_login()
	{
		// was the login form posted?
		if(\Input::method() == 'POST')
		{
			// check the credentials.
			if(\Auth::instance()->login(\Input::param('login_user'), \Input::param('login_password')))
			{
				// did the user want to be remembered?
				if(\Input::param('remember', false))
				{
					// create the remember-me cookie
					\Auth::remember_me();
				} else
				{
					// delete the remember-me cookie if present
					\Auth::dont_remember_me();
				}
				
				$currentUser = \Session::get('user');
				
				//get user role
				$userRole = $currentUser->role;
				
				return $this->response(array(
					'status' => 1,
					'role' => $userRole
				));
			} else
			{
				// login failed, show an error message
				return $this->response(array(
					'status' => 'error',
					'message' => 'Tên đăng nhập hoặc mật khẩu không đúng.'
				));
			}
		}
	}
	
	/*
	 * logout
	 */
	public function action_logout()
	{
		// remove the remember-me cookie, we logged-out on purpose
		\Auth::dont_remember_me();
		// logout
		\Auth::logout();
		return $this->response(array(
			'status' => 1
		));
	}
	
	/*
	 * Api check user login
	 */
	public function action_check()
	{
		// remove the remember-me cookie, we logged-out on purpose
		$result  = \Auth::check();
		return $this->response(array(
			'status' => $result
		));
	}
}