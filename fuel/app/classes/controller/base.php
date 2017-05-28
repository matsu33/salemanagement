<?php

/**
 * Base controller
 * 
 * @author Nguyen Van Tung
 * @since 2014/12/02
 */
abstract class Controller_Base extends Controller_Hybrid
{
	//Dedault REST data type
	protected $format = 'json';

	// //controller is login require?
	protected $require_auth = true;

	//http://peter.sh/experiments/asynchronous-and-deferred-javascript-execution-explained/
	//for asyn loading js
	protected $scriptAttr = array(
				'defer'
			);
	
	//global variable with current user info
	public $current_user = array();
	
	/**
	 * Load the template and create the $this->template object if needed
	 */
	public function before ()
	{
		parent::before();
		
		//check login
		$isLogined  = \Auth::check();
		
		//Load management message file
		$lang = Lang::load('index');
			
		if (! $this->is_restful()) {
			//not login yet
			if(!$isLogined){
				//back to login page
				Response::redirect('auth/index');
			}

			//get user from session
			$this->currentUser = \Session::get('user');
				
			//get user role
			$userRole = $this->currentUser->role;
			
			$controllerMethod = Uri::string();
			
			$hasPermission = $this->checkUserPermission($userRole, $controllerMethod);
			
			if(!$hasPermission){
				//back to login page
				Response::redirect('auth/index');
			}
			
			//var_dump($hasPermission);exit;
			//http://peter.sh/experiments/asynchronous-and-deferred-javascript-execution-explained/
			//for asyn loading js
			// $scriptAttr = array(
				// 'defer'
			// );

			$arrCSS = array('base.css', 'libs/bootstrap.min.css', 'libs/dataTables.bootstrap.css', 'libs/bootstrap-datetimepicker.css','style.css', 'font-awesome-4.2.0/css/font-awesome.min.css');
			$arrJS = array('libs/jquery/jquery.min.js', 'libs/jquery-ui.js', 'libs/underscore-min.js','libs/autoNumeric.js',
							//bootstrap
							'libs/bootstrap/js/bootstrap.min.js',
							
							//dataTables
							'libs/dataTables/jquery.dataTables.js',
							'libs/dataTables/dataTables.bootstrap.js',
							
							//using for validate
							'libs/jquery-validation/jquery.validate.js',
							'libs/jquery-validation/localization/messages_vi.js',
							
							//create template in js
							'libs/doT/doT.min.js',
							'libs/omss/template.js',
							
							//datetime js
							'libs/datetimepicker/js/moment.js',
							'libs/datetimepicker/js/bootstrap-datetimepicker.min.js',
							
							//utility omss
							'libs/omss/omss.js',
							
							//common
							'libs/common.js');
			
			// Load common css
			Asset::css($arrCSS, $this->scriptAttr, 'common_css', false);
			
			//Load js
			Asset::js($arrJS, $this->scriptAttr, 'common_script', false);
			
			
			//set user to global template
			$this->template->set_global('currentUser', $this->currentUser);
			
			//set language data to global variable
			$this->template->set_global('lang', $lang);
		}else{
			//using ajax
			//check auth
			if ($this->require_auth) {
				if (! $isLogined) {
					// If it has not passed validation return a FuelPHP Response object.
					$response = Response::forge(Format::forge(array('Error' => 'Failed to authenticate you'))->to_json())->set_header('Content-Type', 'application.json');
					$response->set_status(401);
					$response->send_headers();
					return $response;
				}
			}
		}
	}
	
	public function checkUserPermission($userRole, $controllerMethod){
		if($userRole == Constant::ROLE_USER){
			//nhan vien
			if($controllerMethod == "banhang/index"){
				return true;
			}
			return false;
		}
		return true;
	}
}	