<?php

return array(
	'routes' => array(
		'//' => 'index',
		'/user/' => 'user',
		'/user/auth/' => 'user/login',
		'/user/\d+/' => 'user/update',
	),
);
