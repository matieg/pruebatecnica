<?php
$env = "../.env";
$contentEnv = parse_ini_file($env, false);
define('DB_HOST', $contentEnv['DB_HOST'] .':'. $contentEnv['DB_PORT'] );
define('DB_USER', $contentEnv['DB_USERNAME'] );
define('DB_PASS', $contentEnv['DB_PASSWORD'] );
define('DB_NAME', $contentEnv['DB_DATABASE'] );
define('APP_URL', 'localhost/pruebatecnica' );