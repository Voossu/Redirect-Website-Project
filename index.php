<?php

define('SITE_ROOT', str_replace("\\", "/", substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']) + 1, strlen(__DIR__))));
define('HOME_URL' , "http".(isset($_SERVER["HTTPS"])?"s":"")."://{$_SERVER['SERVER_NAME']}".(empty(SITE_ROOT)?"":"/".SITE_ROOT));
define('HOME_PATH', "{$_SERVER['DOCUMENT_ROOT']}".(empty(SITE_ROOT)?"":"/".SITE_ROOT));

include HOME_PATH."/app/init.php";