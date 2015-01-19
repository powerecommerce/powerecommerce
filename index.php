<?php

include 'vendor/autoload.php';

use PowerEcommerce\Application\Application;
use PowerEcommerce\System\Data\String;

$app = new Application();
$app->run();

var_dump(
    $app->routeCollection()
);