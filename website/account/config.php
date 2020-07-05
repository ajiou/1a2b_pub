<?php
define('DB_SERVER', 'database ip');
define('DB_USERNAME', 'project');
define('DB_PASSWORD', 'database 密碼');
define('DB_NAME', 'abgame');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$salt = "加密鹽值";