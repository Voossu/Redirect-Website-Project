<?php

$compress_form = [
    'action' => HOME_URL,
    'method' => "post",
    'fields' => [
        'url' => [
            'name' => "url"
        ]
    ],
    'last_compress' => $_SESSION['last_compress']
];

use model\Redirect;

if (!empty($_POST) && !empty($_POST[$compress_form['fields']['url']['name']])) {

    $redirect_id = Redirect::new($_POST[$compress_form['fields']['url']['name']], $_CLIENT->client_id);
    $_SESSION['last_compress'] = HOME_URL.'/'.base62_encode($redirect_id);
    header("Location: ".HOME_URL);

} else {

    View::render("page", [
        'title' => 'ReURL',
        'logo' => false,
        'menu' => [[
            'title' => 'Home',
            'href' => HOME_URL,
            'is_active' => true
        ], [
            'title' => 'About',
            'href' => HOME_URL . "/\$about"
        ] ],
        'content' => View::render("compress.form", $compress_form)
    ])->display();

}