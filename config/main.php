<?php

return array(
	'routes' => array(
		'//' => 'index',
		'/user/' => 'user',
		'/user/auth/' => 'user/login',
		'/user/\d+/' => 'user/update',
	),

	'db' => array(
		'host' => 'sql4.freemysqlhosting.net',
		'user' => 'sql4100371',
		'password' => 'eeAiUuEwAv',
		'database' => 'sql4100371',
	)
);
