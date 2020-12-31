<?php


use Rooike\gsmao\Salary;

class Cron_Gsmao_Controller {

    public function testAction() {
        $this->saveMoney();

        $save = 1000000;
        $i = 1;
        while ($i < 3) {
            $tmp = floor($this->moneyManage($save, 2000, 0.0075));
            $save += $tmp;
            echo ("第 $i 年可攒钱：$save 理财收入:{$tmp}") . "\n";
            $i++;
        }
    }

    public function compare() {
        $salary = $_REQUEST['now'] ?: 18000;
        $aidSalary = $_REQUEST['aid'] ?: 24000;
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
     * @param int $deposit -存款
     * @param int $monthPut -每月投入金额
     * @param float $monthRate -每月收益率
     * @return float|int - 总收入
     */
    function moneyManage($deposit, $monthPut = 8000, $monthRate = 0.01) {
        $earning = 0;
        $yearMonth = 12;
        while ($yearMonth > 0) {
            //第一个月的收入是   12 * 0.05 * 8000
            //最后一个月的收入是  1 * 0.05 * 8000
            $earning += ($yearMonth * $monthRate) * $monthPut;

            $yearMonth--;
        }
        //$earning 每月投入理财收入
        //$deposit * $monthRate * 12 = 存款理财收入
        return $earning + $deposit * $monthRate * 12;
    }

    function saveMoney() {
        $saveYear = 1;
        $allDeposit = 0;//无理财总存款
        $saveMoney = 0;//理财总存款
        $firstYearPut = 8000;//第一年每月能攒下来去理财的钱
        $add = 1000;//每年涨薪之后可多攒下来去理财的钱
        while ($saveYear < 5) {
            $monthPut = $firstYearPut + $add * $saveYear;//每月投入理财金额

            $deposit = $saveMoney;//存款
            $manage = $this->moneyManage($deposit, $monthPut, 0.008);//存款理财收入 + 月投理财收入
            $saveMoney += floor($manage + $monthPut * 12 + (20000 + $add) * 2);//存款 = 理财收入 + 投入本金 + 年终奖

            $allDeposit += $monthPut * 12 + 30000;
            $diff = $saveMoney - $allDeposit;
            echo ("第 $saveYear 年可攒钱：$saveMoney({$allDeposit}) 理财收入:{$diff}") . "\n";
            $saveYear++;
        }
    }
}
