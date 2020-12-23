<?php

use Rooike\Salary;

include_once __DIR__ . '/../vendor/autoload.php';



//rookie first day
define('BASE_PATH', dirname(__DIR__));

//$solution = new \Rooike\Solution();
//echo $solution->predictPartyVictory('RDRDRDD');

function compareSalary() {
    $salary = 18000;
    $aidSalary = 20000;
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

    $allDiff = floor(($allGet - $tax + floor(12 * $gjj)) - ($otherAllGet - $otherTax + floor(12 * $otherGjj)));
    $return = [
        '税前薪资' => $salary,
        '北京薪资' => $aidSalary,
        '个税差' => $otherTax - $tax,
        '实际大概到手' => "单月到手({$get}) * 12 - 年度个税({$tax}) = {$allGet}" ,
        '北京大概到手' => "单月到手({$otherGet}) * 12 - 年度个税({$otherTax}) = {$otherAllGet}",
        '到手差' => $otherAllGet - $allGet,
        '公积金差' => floor(12 * $otherGjj) - floor(12 * $gjj),
        '总比差' => $allDiff,
        '目前年终奖(1.8月 - 2月)' => implode('-', [$salary * 1.8, $salary * 2]),
        '北京年终奖(  2月 - 3月)' => implode('-', [$aidSalary * 2, $aidSalary * 3]),
    ];
    echo "单月到手：{$salary} + {$extraPay} - {$sb} - {$gjj} = {$get} \n北京到手：{$aidSalary} - {$otherGjj} - {$otherSb} = {$otherGet}" . PHP_EOL;
    print_r($return);
}
compareSalary();