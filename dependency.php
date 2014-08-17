<?php

date_default_timezone_set('America/New_York');

ob_start();

function load_lib($class) {
    include 'lib/'.$class . '.php';
}

spl_autoload_register('load_lib');

session_start();
session_regenerate_id(true);