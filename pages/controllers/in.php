


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Info</title>
</head>
<body>

<? if (count($_GET) == 1) { ?>

    <? if ($_GET['client']) { ?>
        <?
            $client = \model\Client::get_row($_GET['client']);
            if (!empty($client)) {
        ?>
        <div class="content">

            <div class="id">ID: <?=$client->client_id?></div>
            <div class="agent">Agent: <?=$client->client_agent?></div>

            <div class="ip history">
                <? foreach ($client->get_ip_list() as $ip) {?>
                    <div>
                    <?=$ip['client_ip']?> // <?=$ip['client_date']?>
                    </div>
                <? } ?>
            </div>

        </div>

        <? } else { ?>
            Client not found!
        <? } ?>
    <? } elseif (!empty($_GET['url'])) { ?>

        <?
            $redirect = \model\Redirect::get_row(base62_decode($_GET['url']));
            if (!empty($redirect)) {
        ?>
                <div class="content">

                    <div class="id">ID: <?=$redirect->redirect_id?></div>
                    <div class="agent">Agent: <?=$redirect->redirect_url?></div>
                    <div class="agent">Used: <?=$redirect->redirect_usecount?></div>
                    <div class="agent">Create: <?=$redirect->redirect_create?></div>

                    <div class="ip history">
                        <? foreach ($redirect->get_redirects() as $info) {?>
                            <div>
                            Client ID: <?=$info['redirect_client']?> // <?=$info['redirect_date']?>
                            </div>
                        <? } ?>
                    </div>

                </div>
        <? } else { ?>
             URL not found!
        <? } ?>

    <? } ?>

<? } ?>

</body>
</html>

<?php

/*
use model\Client;

if (!empty($_GET['client'])) {
    $client = Client::get_row($_GET['client']);
    if (!empty($client)) {
        $client_info = [];
        $client_info['agent'] = $client->client_agent;
        $client_info['ip_history'] = $client->get_ip_list();
        echo json_encode($client_info);
    }
}

use model\Redirect;

if (!empty($_GET['url']) && is_base62($_GET['url'])) {
    $redirect = Redirect::get_row(base62_decode($_GET['url']));
    if (!empty($redirect)) {
        $redirect_info = [];
        $redirect_info['url'] = $redirect->redirect_url;
        $redirect_info['create'] = $redirect->redirect_create;
        $redirect_info['history'] = $redirect->get_redirects();
        echo json_encode($redirect_info);
    }
}*/
