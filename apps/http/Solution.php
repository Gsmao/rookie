<?php


namespace Rooike;


class Solution
{
    /**
     * 第一天打开就这么强
     * 空间超越：100%
     * 时间超过：100%
     * 题名：Dota2 参议院
     * link https://leetcode-cn.com/problems/dota2-senate/
     * @param $senate
     * @return string
     */
    function predictPartyVictory($senate)
    {
        $powerR = 0;//可支配权限
        $powerD = 0;
        do {
            if (strpos($senate, 'R') === false) {
                return 'Dire';
            }
            if (strpos($senate, 'D') === false) {
                return 'Radiant';
            }
            $tmp = $senate;//临时变量
            $length = strlen($senate);
            for ($i = 0; $i < $length; $i++) {
                if ($senate[$i] === 'R') {
                    echo "当前 $i = R powerR = $powerR powerD = $powerD ";
                    if ($powerD > 0) {
                        echo '被干掉了';
                        //当前是R，前面有可行使权力的D 这位被干掉了
                        $powerD--;
                        $tmp = substr($tmp, 0, $i) . 'X' . substr($tmp, $i + 1, $length);
                    } else {
                        $powerR++;
                    }
                } elseif($senate[$i] === 'D') {
                    echo "当前 $i = D powerR = $powerR powerD = $powerD ";
                    if ($powerR > 0) {
                        echo '被干掉了';
                        //当前是D，前面有可行使权力的R 这位被干掉了
                        $powerR--;
                        $tmp = substr($tmp, 0, $i) . 'X' . substr($tmp, $i + 1, $length);
                    } else {
                        $powerD++;
                    }
                }
                echo $tmp . PHP_EOL;
            }
            $senate = $tmp;
        } while (!empty($senate));
        return 'error';
    }
}