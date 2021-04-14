<?php


use Rooike\gsmao\Salary;

class Cron_Gsmao_Controller {

    /**
     * 命令行 php public/index.php cron/gsmao/test
     */
    public function testAction() {
//        $this->compare();
        $a = ["a","a","b","b","c","c","c"];
        $b = $this->compress($a);
        var_dump($a);
        var_dump($b);
    }

    /**
     * 薪资对比
     */
    public function compare() {
        $salary = $_REQUEST['now'] ?: 19000;
        $aidSalary = $_REQUEST['aid'] ?: 25000;
        $nowSalary = new Salary($salary, 14000 * 0.7, 0.18, 0.07);
        $otherSalary = new Salary($aidSalary);
        $nowDetail = $nowSalary->getSalaryDetail();
        $otherDetail = $otherSalary->getSalaryDetail();

        $sb = $nowDetail['sb'];
        $gjj = $nowDetail['gjj'];
        $get = $nowDetail['get'];
        $tax = $nowDetail['tax'];//累计总年个税
        $allGet = floor($nowDetail['get'] * 12 - $tax);
        $extraPay = $nowDetail['extra_pay'];

        $otherSb = $otherDetail['sb'];
        $otherGjj = $otherDetail['gjj'];
        $otherGet = $otherDetail['get'];
        $otherTax = $otherDetail['tax'];//北京总年个税
        $otherAllGet = floor($otherDetail['get'] * 12 - $otherTax);

        $allDiff = floor($otherAllGet + floor(12 * $otherGjj)) - floor($allGet + floor(12 * $gjj));
        $return = [
            '税前薪资'             => $salary,
            '北京薪资'             => $aidSalary,
            '实际大概到手'           => "单月到手({$get})($gjj) * 12 - 年度个税({$tax}) = {$allGet}",
            '北京大概到手'           => "单月到手({$otherGet})($otherGjj) * 12 - 年度个税({$otherTax}) = {$otherAllGet}",
            '到手差'              => $otherAllGet - $allGet,
            '公积金差'             => floor(12 * $otherGjj) - floor(12 * $gjj),
            '总比差(减个税)'         => $allDiff,
            '目前年终奖(1.8月 - 2月)' => implode('-', [$salary * 1.8, $salary * 2]),
            '北京年终奖(  2月 - 3月)' => implode('-', [$aidSalary * 2, $aidSalary * 3]),
        ];
        echo "单月到手：{$salary} + {$extraPay} - {$sb} - {$gjj} = {$get} \n北京到手：{$aidSalary} - {$otherGjj} - {$otherSb} = {$otherGet}" . PHP_EOL;
        print_r($return);
    }

    /**
     * @param int $monthPut -每月投入金额
     * @param float $monthRate -每月收益率
     * @return float|int - 总收入
     */
    public function moneyManage($monthPut = 8000, $monthRate = 0.01) {
        $earning = 0;
        $yearMonth = 12;
        while ($yearMonth > 0) {
            //第一个月的收入是   12 * $monthRate * 8000
            //最后一个月的收入是  1 * $monthRate * 8000
            $earning += ($yearMonth * $monthRate) * $monthPut;
            $yearMonth--;
        }
        return $earning;
    }

    /**
     * 财富密码
     */
    public function saveMoney() {
        $saveYear = 1;
        $allDeposit = 0;//无理财总存款
        $saveMoney = 0;//理财总存款
        $firstYearPut = 8000;//第一年每月能攒下来去理财的钱
        $add = 1000;//每年涨薪之后可多攒下来去理财的钱

        while ($saveYear < 5) {
            $monthPut = $firstYearPut + $add * $saveYear;//每月投入理财金额

            $manage = $this->moneyManage($monthPut, 0.01);//存款理财收入 + 月投理财收入

            $saveMoney += floor(
                $manage + //理财收入
                $monthPut * 12 + //今年投入本金
                $allDeposit * 0.1 + //历史投入收入
                (16000 + $add) * 2)//年终奖
            ;

            $allDeposit += $monthPut * 12 + (16000 + $add) * 2;

            $diff = $saveMoney - $allDeposit;
            echo ("第 $saveYear 年可攒钱：$saveMoney({$allDeposit}) 理财收入:{$diff}") . "\n";
            $saveYear++;
        }
    }

    public function compress(&$chars) {
        $len = count($chars);

        $replace = false;
        $replaceCount = 1;
        $last_char = $chars[0];

        $tmp = [];
        for ($i = 1; $i < $len; $i++) {
            //判断重复将重复值++
            if ($chars[$i] === $last_char) {
                $replace = true;
                $replaceCount++;
            } else {
                $replace = false;
            }

            if (!$replace && $replaceCount > 1) {
                $tmp[] = $last_char;
                $this->reverse($tmp, $replaceCount);

                $replaceCount = 1;
            }
            $last_char = $chars[$i];
        }

        if ($replace && $replaceCount > 1) {
            $tmp[] = $last_char;
            $this->reverse($tmp, $replaceCount);
        }
        var_dump($tmp);

        $chars = $tmp;
        return count($chars);
    }

    public function reverse(&$tmp, $replaceCount)
    {
        $tmpArr = [];
        while ($replaceCount) {
            $tmpArr[] = $replaceCount % 10;
            $replaceCount = (int)($replaceCount / 10);
        }
        //逆向拼接count
        $j = count($tmpArr) - 1;
        while ($j >= 0) {
            $tmp[] = $tmpArr[$j];
            $j--;
        }
    }
}
