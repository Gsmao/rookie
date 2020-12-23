<?php

use Rooike\Tools;

include_once __DIR__ . '/../vendor/autoload.php';


//rookie first day


function run()
{
    //暂时没研究参数怎么传 直接这里改users 后面我研究一下 传参
    $users = $_GET['users'] ?: 1;
    $toolsModel = new Tools();
    $toolsModel->debug($users);
}
run();