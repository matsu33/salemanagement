<?php

class Controller_Luudulieu extends Controller_Base
{
	/**
	 * Load the template and create the $this->template object if needed
	 */
	public function before ()
	{
		parent::before();
	
		if (! $this->is_restful()) {
			$arrJS = array('backup.js');
			//Load js
			Asset::js($arrJS, $this->scriptAttr, 'current_script', false);
		}
	}
	
	public function action_index()
	{
		$data["subnav"] = array('index'=> 'active' );
		$this->template->title = Lang::get('title_backupdata');
		$this->template->content = View::forge('luudulieu/index', $data);
	}

	public function action_backup_data(){
		$result = Dbhelper::backup();
		return $this->response($result);
	}
	
	public function action_backup(){
		/*$fileDir = 'DB_Backup/';
		if (!is_dir($fileDir)){
			mkdir($fileDir, 0777, true);
		}
		chmod($fileDir, 0777);
		
		//Load management message file
		$lang = Lang::load('index');
		
		\Config::load('db', true);
		$name = \Config::get('db.active');
		
		$dsn = \Config::get('db.' . $name . '.connection.dsn');
		$username = \Config::get('db.' . $name . '.connection.username');
		$password = \Config::get('db.' . $name . '.connection.password');
		
		@preg_match('/^(.+):host=(.+);dbname=(.+)$/i', $dsn, $matches);
		
		$dbtype = $matches[1];
		$dbhost = $matches[2];
		$dbname = $matches[3];
		
		$fileName = 'db_backup_' . date('ymd') . '_' . date('His') . '.sql';
		
		
		$command = "C:/xampp/mysql/bin/mysqldump --default-character-set=binary " . $dbname .
		" --host=" . $dbhost . " --user=" . $username . " --password=" .
		$password . " > " . $fileDir . $fileName;
		
		$return = Dbhelper::system_ex($command);
		$dumpfname = $fileDir . $fileName;
		
		// read zip file and send it to standard output
		if (file_exists($dumpfname)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($dumpfname));
			flush();
			readfile($dumpfname);
			exit;
		}*/
	}
}
