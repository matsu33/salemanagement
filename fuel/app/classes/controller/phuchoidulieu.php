<?php

class Controller_Phuchoidulieu extends Controller_Base
{
	public function before ()
	{
		parent::before();
	
		if (! $this->is_restful()) {
			$arrJS = array('restore.js');
			//Load js
			Asset::js($arrJS, $this->scriptAttr, 'current_script', false);
		}
	}
	
	public function action_index()
	{
		$data["subnav"] = array('index'=> 'active' );
		$this->template->title = Lang::get('title_restoredata');
		$this->template->content = View::forge('phuchoidulieu/index', $data);
	}

	public function post_restore()
	{
		$config = array(
				'path' => DOCROOT.DS.'DB_Restore',
				'randomize' => true,
				'ext_whitelist' => array('sql'),
		);
			
		Upload::process($config);
			
		if (Upload::is_valid())
		{
			Upload::save();
			$files = Upload::get_files();
			foreach( $files  as $key=>$file ) {
				$filepath = $file['saved_to'].$file['saved_as'];
				$result = Dbhelper::restore($filepath);
				unlink($filepath);
				return $this->response($result);
			}
		}
	}
}
