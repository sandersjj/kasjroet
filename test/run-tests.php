#!/usr/bin/env php
<?php

chdir(__DIR__);
$paths = array();
if ($argc > 1) {
    foreach ($argv as $key => $path) {

        if (!$key) continue;
        system('phpunit -c '. __DIR__ . DIRECTORY_SEPARATOR . 'phpunit.xml '. __DIR__ . DIRECTORY_SEPARATOR . $path, $result);
        echo $result;
    }

} else {

    system('phpunit -c '. __DIR__ . DIRECTORY_SEPARATOR . 'phpunit.xml '. __DIR__, $result);
    echo $result;
}