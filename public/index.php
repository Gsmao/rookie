<?php

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/CronRegister.php';


//没时间搭框架，要写测试代码跑命令行
//命令行演示：php public/index.php cron/gsmao/test a/test b/test2
//命令行解析：
//参数1：php public/index.php   这个是调用主文件
//参数2：cron/gsmao/test 这个是我随便规定的路径含义为 调用 apps/controllers/cron/gsmao.controller.php 文件里面的 testAction
//注意 ：只需要写文件前缀就行 .controller.php忽略。 方法后面必须跟上Action 不然找不到
//参数3：a/test b/test2  这个主要是把  _SERVICE['argv'] 后面的这部分参数拼接到 $_REQUEST 里面
$cronRegister = new Cron_Register();
$cronRegister->run();