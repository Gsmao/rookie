<?php


class Cron_Register
{
    public function __construct() {
//        $this->run();
    }

    public function run()
    {
        try {
            if ($_SERVER['argv'] && count($_SERVER['argv']) > 1) {
                //判断路径
                list($basePath, $controller, $action) = explode('/', $_SERVER['argv'][1]);
                $actionName = $action . 'Action';
                $className = str_replace(' ', '_', ucwords(str_replace("/", " ", $basePath . '/' . $controller . '/Controller')));
                $controllerFile = __DIR__ . '/../apps/controllers/' . $basePath . '/' . $controller . '.controller.php';
                if (!file_exists($controllerFile)) {
                    $this->halt(__CLASS__ . " 1: controller file <<i>$controllerFile</i>> is not exists ");
                }

                //加载判断类
                require_once $controllerFile;
                $controllerObj = new $className;
                if (!method_exists($controllerObj, $actionName)) {
                    $this->halt(__CLASS__ . ": method <<i>$actionName</i>> is not in  $className ");
                }

                //拼接参数到$_REQUEST
                foreach ($_SERVER['argv'] as $key => $value) {
                    if ($key < 2) continue;
                    list($k, $v) = explode('/', $value, 2);
                    $_REQUEST[$k] = $v;
                }
                //调用Action
                $controllerObj->$actionName();
            }
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }

    public function halt($msg, $die = true) {
        echo $msg;
        if ($die) {
            die();
        }
    }
}
