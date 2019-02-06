<?php

View::render("page", [
    'title' => 'ReURL',
    'logo' => true,
    'menu' => [[
        'title' => 'Home',
        'href' => HOME_URL
    ], [
        'title' => 'About',
        'href' => HOME_URL . "/\$about",
        'is_active' => true
    ]],
    'content' => View::render("about.content")
])->display();