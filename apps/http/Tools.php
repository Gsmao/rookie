<?php

namespace Rooike;

class Tools
{
    public static function debug()
    {
        printf("%s\n", 'hello world!');
    }

    public function fuc()
    {
        printf("%s\n", __METHOD__ . ': hello world!');
    }
}