<?php
function execPrint($command) {
    $result = array();
    exec($command, $result);
    foreach ($result as $line) {
        print($line . "\n");
    }
}
// Print the exec output inside of a pre element
//print("<pre>" . execPrint("git pull https://user:password@bitbucket.org/user/repo.git master") . "</pre>");
//print("<pre>" . execPrint("git rev-parse HEAD") . "</pre>");
//$version = shell_exec("git rev-parse HEAD");
//echo('current version : '.$version);
//pull --progress -v --no-rebase "origin"
//print("<pre>" . execPrint('git pull --progress -v --no-rebase "origin"') . "</pre>");

function is_connected()
{
  $connected = fopen("http://www.google.com:80/","r");
  if($connected)
  {
     return true;
  } else {
   return false;
  }

} 
/*
$isConnectInternet = is_connected();
if($isConnectInternet) {
	echo 'connect';
}else {
	echo 'not connect';
}
*/
function readFileWithUrl($urlToRead){
	try {
		$content = file_get_contents($urlToRead);

		if ($content === false) {
			// Handle the error
		}
		return $content;
	} catch (Exception $e) {
		// Handle exception
	}
}

$readMeFileUrl = 'https://raw.githubusercontent.com/matsu33/salemanagement/master/README.md';

echo('<pre>'.readFileWithUrl($readMeFileUrl).'</pre>');