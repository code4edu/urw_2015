<?php

session_start();

require("core/autoloader.php");

$config = new \core\Config(require("config/main.php"));

$app = \core\App::getInstance();

$app->init($config);
$app->start();
