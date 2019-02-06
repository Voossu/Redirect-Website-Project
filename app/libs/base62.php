<?php

const BASE62 = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

/** Base62
 * The encoding schema to be used by this shortening algorithm will be Base 62 encoding,
 * as we are going to use 62 letters: [a-zA-Z0-9]. As always, the indexing begins at 0.
 */

/***
 * @param integer|string $number
 * @return string
 */
function base62_encode($number)
{
    $result = '';
    while ($number > 0) {
        $result = BASE62[$number % 62] . $result;
        $number = intval($number / 62);
    }
    return $result;
}


/***
 * @param string $base62
 * @return string number
 */
function base62_decode($base62)
{
    $limit = strlen($base62);
    $result = strpos(BASE62, $base62[0]);
    for($i = 1; $i < $limit; $i++) {
        $result = 62 * $result + strpos(BASE62, $base62[$i]);
    }
    return $result;
}


/**
 * @param string $base62
 * @return bool
 */
function is_base62($base62) {
    return preg_match('/^[0-9a-zA-Z]+$/', $base62);
}