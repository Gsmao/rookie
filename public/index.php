<?php

include_once __DIR__ . '/../vendor/autoload.php';



//rookie first day
define('BASE_PATH', dirname(__DIR__));

$solution = new \Rooike\Solution();
echo $solution->predictPartyVictory('RDRDRDD');