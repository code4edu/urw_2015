<?php

return array(
	'routes' => array(
		'/' => 'main',
		'/teacher/' => 'user/teacher',
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
