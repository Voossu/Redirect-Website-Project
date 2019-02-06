<?php

session_start();

/**
 * $_CONFIG array
 */
$_CONFIG = json_decode(file_get_contents(HOME_PATH."/config.json"), true);

include HOME_PATH."/app/libs/base62.php";
include HOME_PATH."/app/libs/database.php";
include HOME_PATH."/app/libs/client.php";
include HOME_PATH."/app/libs/view.php";
include HOME_PATH."/app/libs/routing.php";