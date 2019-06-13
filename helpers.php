<?php

function pd($item) {
    echo "<pre>" . print_r($item,1) . "</pre>";
}

function printException(Exception $e) {
    echo $e->getMessage();
    echo "<br>";
    echo $e->getFile();
    echo "<br>";
    echo $e->getLine();
    echo "<br>";
}

function logException(Exception $e) {
    //todo: create logging function
}