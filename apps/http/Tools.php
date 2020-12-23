<?php

namespace Rooike;

use Rooike\gsmao\Solution;

class Tools
{
    public function debug($users)
    {
        switch ($users) {
            case 1:
                $this->gsmao();
                break;
            case 2:
                $this->mxu();
            default:
                echo '请输入正确用户id';
                break;
        }
    }

    public function fuc()
    {
        printf("%s\n", __METHOD__ . ': hello world!');
    }

    public function gsmao()
    {
        //这里面我自己写调试代码
        $solution = new Solution();
        $solution->test();
    }

    public function mxu()
    {
        //徐明专用
    }
}