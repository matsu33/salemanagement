<?php
use Fuel\Core\Config;
use Fuel\Core\Lang;

/**
 * Using for backup, restore database
 * 
 * @author Nguyen Van Tung
 * @since 2014/12/01
 */
class Dbhelper
{

	public static function backup ($fileName = NULL)
	{		
		$fileDir = 'DB_Backup/';
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
		
		$message = '';
		$status = 0;
		$result = array(
				'status' => $status,
				'message' => $message
		);
		
		if (count($matches) !== 4) {
			$message = "Config dsn doesn't match." . PHP_EOL;
			$message .= 'check fuel/app/config/development/db.php' . PHP_EOL;
			
			$result = array(
					'status' => $status,
					'message' => $message
			);
			return $result;
		}
		
		$dbtype = $matches[1];
		$dbhost = $matches[2];
		$dbname = $matches[3];
		
		if (strtolower($dbtype) !== 'mysql') {
			$message = 'Config database type is not MySQL.' . PHP_EOL;
			$message .= 'check fuel/app/config/development/db.php' . PHP_EOL;
			
			$result = array(
					'status' => $status,
					'message' => $message
			);
			return $result;
		}
		
		if ($fileName) {
			$fileName = $fileName . '.sql';
		} else {
			$fileName = 'db_backup_' . date('ymd') . '_' . date('His') . '.sql';
		}
		
		if (! file_exists($fileDir)) {
			try {
				if (! @mkdir($fileDir)) {
					$message = 'Cannnot create directory ' . $fileDir . PHP_EOL;
					
					$result = array(
							'status' => $status,
							'message' => $message
					);
					return $result;
				}
			} catch (\Exception $e) {
				$message = "Cannnot create directory " . $fileDir . PHP_EOL;
				
				$result = array(
						'status' => $status,
						'message' => $message
				);
				return $result;
			}
		}
		
		$command = "C:/xampp/mysql/bin/mysqldump --default-character-set=binary " . $dbname .
				 " --host=" . $dbhost . " --user=" . $username . " --password=" .
				 $password . " > " . $fileDir . $fileName;
		
		$return = self::system_ex($command);
		
		if ($return["stderr"] !== "" && strpos($return["stderr"], 'Warning')) {
			$message = 'mysqldump failed for reasion:' . PHP_EOL .
					 $return["stderr"];
			
			$result = array(
					'status' => $status,
					'message' => $message
			);
			return $result;
		}
		
		$status = 1;
		$message = Lang::get('m_backupdb_success') . PHP_EOL;
		
		$result = array(
				'status' => $status,
				'message' => $message,
				'fileName' => $fileDir . $fileName
		);
		return $result;
	}

	public static function restore ($fileDir = NULL)
	{
		if (! $fileDir) {
			//$fileDir = 'D:\test\db_backup_141201_111315.sql';
		}

		//Load management message file
		$lang = Lang::load('index');
		
		$message = '';
		$status = 0;
		$result = array(
				'status' => $status,
				'message' => $message
		);
		
		\Config::load('db', true);
		$name = \Config::get('db.active');
		
		$dsn = \Config::get('db.' . $name . '.connection.dsn');
		$username = \Config::get('db.' . $name . '.connection.username');
		$password = \Config::get('db.' . $name . '.connection.password');
		
		@preg_match('/^(.+):host=(.+);dbname=(.+)$/i', $dsn, $matches);
		
		$message = '';
		
		if (count($matches) !== 4) {
			$message = "Config dsn doesn't match." . PHP_EOL;
			$message .= 'check fuel/app/config/development/db.php' . PHP_EOL;
			
			$result = array(
					'status' => $status,
					'message' => $message
			);
			return $result;
		}
		
		$dbtype = $matches[1];
		$dbhost = $matches[2];
		$dbname = $matches[3];
		
		if (strtolower($dbtype) !== 'mysql') {
			$message = 'Config database type is not MySQL.' . PHP_EOL;
			$message .= 'check fuel/app/config/development/db.php' . PHP_EOL;
			
			$result = array(
					'status' => $status,
					'message' => $message
			);
			return $result;
		}
		
		if (! file_exists($fileDir)) {
			$message = 'File not found';
			
			$result = array(
					'status' => $status,
					'message' => $message
			);
			return $result;
		}
		
		$command = "C:/xampp/mysql/bin/mysql --default-character-set=binary " . $dbname . " --host=" .
				 $dbhost . " --user=" . $username . " --password=" . $password .
				 " < " . $fileDir;
		
		$return = self::system_ex($command);
		
		if ($return["stderr"] !== "" && strpos($return["stderr"], 'Warning')) {
			$message = 'mysqldump failed for reasion:' . PHP_EOL .
					 $return["stderr"];
			
			$result = array(
					'status' => $status,
					'message' => $message
			);
			return $result;
		}
		$status = 1;
		$message = Lang::get('m_restoredb_success') . PHP_EOL;
		
		$result = array(
				'status' => $status,
				'message' => $message
		);
		return $result;
	}

	protected static function system_ex ($cmd, $stdin = "")
	{
		$descriptorspec = array(
				0 => array(
						"pipe",
						"r"
				),
				1 => array(
						"pipe",
						"w"
				),
				2 => array(
						"pipe",
						"w"
				)
		);
		
		$process = proc_open($cmd, $descriptorspec, $pipes);
		$result_message = "";
		$error_message = "";
		$return = null;
		
		if (is_resource($process)) {
			fputs($pipes[0], $stdin);
			fclose($pipes[0]);
			
			while ($error = fgets($pipes[2])) {
				$error_message .= $error;
			}
			
			while ($result = fgets($pipes[1])) {
				$result_message .= $result;
			}
			foreach ($pipes as $k => $_rs) {
				if (is_resource($_rs)) {
					fclose($_rs);
				}
			}
			
			$return = proc_close($process);
		}
		
		return array(
				'return' => $return,
				'stdout' => $result_message,
				'stderr' => $error_message
		);
	}
}