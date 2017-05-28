<?php
/**
 * The development database settings. These get merged with the global settings.
 */

// return array(
// 	'default' => array(
// 		'connection'  => array(
// 			'dsn'        => 'mysql:host=localhost;dbname=pt001',
// 			'username'   => 'root',
// 			'password'   => '',
// 		),
// 	),
// );

return array(
		'default' => array(
				'type'   => 'mysqli',
				'connection' => array(
						'dsn'        => 'mysql:host=127.0.0.1;dbname=pt',
						'hostname'   => 'localhost',
						'database'   => 'pt',
						'username'   => 'root',
						'password'   => '',
						'persistent' => FALSE,
				),
				'table_prefix' => '',
				'charset'      => 'utf8',
				'caching'      => true,
				'profiling'    => true,
		),
);