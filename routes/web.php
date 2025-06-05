<?php

use LaChaudiere\webui\actions\HomePageAction;
use Slim\App;

return function (App $app) {
    $app->get('/', HomePageAction::class)->setName('home');
};
