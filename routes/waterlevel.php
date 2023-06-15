<?php

Flight::route('POST /waterlevel', function(){
    $date = date('Y-m-d', strtotime('now'));

    $time = date('H:i:s', strtotime('now'));

    $wlFilename = "waterlevel-$date.json";
    $wlFilepath = "./data/$wlFilename";

    if (!file_exists($wlFilepath)) {
        file_put_contents($wlFilepath, '{}');
    }

    $wlEntries = json_decode(file_get_contents($wlFilepath), true);
    $wlEntry = json_decode(file_get_contents('php://input'), true);
    $wlEntries[$time] = $wlEntry;

    file_put_contents($wlFilepath, json_encode($wlEntries));

    Flight::halt(201);
});

Flight::route('GET /waterlevel(/@date:[0-9]{4}-[0-9]{2}-[0-9]{2})', function($date){
    $date = date('Y-m-d', strtotime(is_null($date) ? 'now' : $date));

    $wlFilename = "waterlevel-$date.json";
    $wlFilepath = "./data/$wlFilename";

    if (!file_exists($wlFilepath)) {
        Flight::halt(200, '{}');
    }

    Flight::json(json_decode(file_get_contents($wlFilepath)));
});