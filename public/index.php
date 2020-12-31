<?php

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/CronRegister.php';


//没时间搭框架，要写测试代码跑命令行
$cronRegister = new Cron_Register();
$cronRegister->run();