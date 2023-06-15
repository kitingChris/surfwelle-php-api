<?php

require 'vendor/autoload.php';

foreach (glob(dirname(__FILE__)."/routes/*.php") as $route) {
    if (is_file($route)) {
        require $route;
    }
}

Flight::map('error', function(\Throwable $ex){
    Flight::json(
        array(
            "error" => array(
                "message" => $ex->getMessage(),
                "code" => $ex->getCode(),
                "file" => $ex->getFile(),
                "line" => $ex->getLine(),
                "trace" => $ex->getTrace()
            )
        ), 500);
});
Flight::set('flight.log_errors', true);

Flight::start();