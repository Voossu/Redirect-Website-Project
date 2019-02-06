<?php

use model\Redirect;

function include_controller($controller) {
    include HOME_PATH."/pages/controllers/{$controller}.php";
}

function exist_controller($controller) {
    return is_readable(HOME_PATH."/pages/controllers/{$controller}.php");
}

{

    $request = preg_replace('/(^\/+)|(\/+$)/', '', $_SERVER['REDIRECT_URL']);

    if (!empty($request) && is_base62($request)) {

        $redirect = Redirect::get_row(base62_decode($request));

        if (empty($redirect)) {
            echo "Address not found a forwarding!";
        } elseif ($redirect->disable) {
            echo "Location is not enabled for redirection!";
        } else {
            
            $redirect->shift_redirect($_CLIENT->client_id);
            header("Location: {$redirect->redirect_url}");
        }

    } else {

        if (empty($request)) {
            include_controller('home');
        } else {
            $controller = substr($request, 1);
            if (exist_controller($controller)) {
                include_controller($controller);
            } else {
                echo 404;
            }
        }

    }

}