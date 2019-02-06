<?php

/**
 *  $_DATABASE PDO object
 */
try {
    $_DATABASE = new PDO(

        "mysql:host={$_CONFIG['db']['host']};dbname={$_CONFIG['db']['name']}",
        $_CONFIG['db']['user'], $_CONFIG['db']['pass'], [

        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION/* PDO::ERRMODE_SILENT*/,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC

    ]);
    $_DATABASE->exec("SET CHARACTER SET utf8");
} catch (PDOException $e) {
    die("Something went wrong ... Error connecting to the database... Try again later...");
}

/* ------------------------------- databases traits ------------------------------- */

trait DBRowR {

    private $fields = [];

    function __construct($row) {
        $this->fields = $row;
    }

    function __isset($field) {
        return isset($this->fields[$field]);
    }

    function __get($field) {
        return $this->fields[$field];
    }
}

trait DBRowW {
    use DBRowR;

    private $updates = [];

    function __set($name, $value) {
        if (in_array($name, $this->allow_update)) {
            $this->fields[$name] = $value;
            $this->update = $name;
        }
    }

    function __destruct() {
        if (!empty($this->updates)) {
            $this->save();
        }
    }
    
}

/* -------------------------------- autoload_model -------------------------------- */

spl_autoload_register('autoload_model_class');

function autoload_model_class($model_name) {
    $model_params = preg_split('/[\\\\]+/', strtolower($model_name));
    if (count($model_params) === 2 && $model_params[0] === "model") {
        $address = HOME_PATH."/models/".$model_params[1].".php";
        if (is_readable($address)) {
            include_once $address;
        }
    }
}