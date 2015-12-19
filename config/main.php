<?php

return array(
	'routes' => array(
		'//' => 'index',
		'/user/' => 'user',
		'/user/auth/' => 'user/login',
		'/user/\d+/' => 'user/update',
	),

	'db' => array(
		'host' => 'http://db4free.net/',
		'user' => 'urw_dev',
		'password' => 'urw_dev',
		'database' => 'urw_dev',
	)
);
