<?php

Flight::route('/health', function(){
    Flight::json(array("status" => "ok"), );
});