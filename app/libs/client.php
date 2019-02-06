<?php

$_CLIENT = null;

use model\Client;

{
    $ip_keys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'REMOTE_ADDR'
    ];
    $ip_list = [];
    foreach ($ip_keys as $ip_key) {
        if (array_key_exists($ip_key, $_SERVER) && !empty($_SERVER[$ip_key])) {
            foreach (explode(', ', $_SERVER[$ip_key]) as $ip) {
                $ip_list[] = $ip;
            }
        }
    }
    $client_ip = implode(', ', array_unique($ip_list));

    function new_client() {
        global $_CLIENT, $client_ip;
        $base62_client_key = base62_encode(rand(0, getrandmax()));
        $base62_client_id = base62_encode(Client::new($base62_client_key, $_SERVER['HTTP_USER_AGENT'], $client_ip));
        setcookie('client', $base62_client_id);
        setcookie('key', $base62_client_key);
        $_COOKIE['client'] = $base62_client_id;
        $_COOKIE['key'] = $base62_client_key;
        $_CLIENT = Client::get_row(base62_decode($_COOKIE['client']));
    }

    if (empty($_COOKIE['client']) || !is_base62($_COOKIE['client']) ||
        empty($_COOKIE['key']) || !is_base62($_COOKIE['key'])) {
        new_client();

    } else {
        $_CLIENT = Client::get_row(base62_decode($_COOKIE['client']));
        if (empty($_CLIENT) || $_COOKIE['key'] !== $_CLIENT->client_key) {
            new_client();
        } else {
            $client_last_ip = $_CLIENT->get_ip_list([
                'order' => 'ip_id DESC',
                'limit' => 1
            ])[0]['client_ip'];
            if ($client_ip != $client_last_ip) {
                $_CLIENT->add_ip($client_ip);
            }
        }
    }
    
}