<?php
$loader = require __DIR__ . "/../vendor/autoload.php";
$loader->addPsr4('Math\\', __DIR__.'/Math');

date_default_timezone_set('UTC');
