<?php

return array(
	'routes' => array(
		'//' => 'index',
		'/user/' => 'user',
		'/auth/' => 'user/auth',
		'/user/\d+/' => 'user/update',
	),

	'db' => array(
		'host' => 'localhost',
		'user' => 'root',
		'password' => '',
		'database' => 'urw_dev',
	)
);
