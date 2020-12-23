<?php


namespace Rooike;

/**
 * 薪资计算
 * Class Salary
 * @package Rooike
 */
class Salary {

    protected $salary;//薪资
    protected $base;//交社保公积金的基数（一般等于薪资）
    protected $extraPay;//额外加班费用
    protected $percent;//缴纳比率（默认按照12%交社保公积金）

    public function __construct($salary, $base = 0, $extraPayRate = 0, $percent = 0) {
        $this->salary = $salary;
        $this->base = $base ?: $salary;
        $this->extraPay = $salary * $extraPayRate;
        $this->percent = $percent ?: 0.12;
    }

    public function getSalaryDetail()
    {
        $sb = ($this->base * 105) / 1000;//社保 = 基数 * 比率（10.5%）
        $gjj = $this->base * $this->percent;//公积金 = 基数 * 比率
        $get = floor(($this->salary + $this->extraPay) - $sb - $gjj);//单月到手
        //个税累计所得 = 薪资 + 加班费 - 社保 - 公积金
        $monthAmount = ($this->salary + $this->extraPay) - $sb - 2 * $gjj;
        $amount = floor(12 * $monthAmount);//年度个税基数
        return [
            'salary' => $this->salary,
            'extra_pay' => $this->extraPay,
            'sb' => $sb,//社保
            'gjj' => $gjj,//公积金
            'get' => $get,//单月到手
            'amount' => $amount,
            'tax' => $this->getAllTax($amount),
        ];
    }

    /**
     * 根据收入计算总年度所需缴纳个税
     * @param $amount
     * @return float|int
     */
    public function getAllTax($amount) {
        $amount -= 60000;
        if ($amount < 0) {
            return 0;
        }
        //1    不超过36,000元的部分           3 1080
        //2    超过36,000元至144,000元的部分  10 10400
        //3    超过144,000元至300,000元的部分 20 16920
        //4    超过300,000元至420,000元的部分 25 31920
        //5    超过420,000元至660,000元的部分 30 52920
        //6    超过660,000元至960,000元的部分 35 85920
        //7    超过960,000元的部分             45
        $rate = 0;
        $gradsTax = 0;
        $gradsAmount = 0;
        if ($amount < 36000) {
            $gradsTax = 0;
            $gradsAmount = $amount;
        } elseif ($amount < 144000) {
            $gradsTax = $gradsTax + (36000) * 0.03;
            $gradsAmount = $amount - 36000;
            $rate = 0.1;
        } elseif ($amount < 300000) {
            $gradsTax = $gradsTax + (144000 - 36000) * 0.1;
            $gradsAmount = $amount - 144000;
            $rate = 0.2;
        } elseif ($amount < 420000) {
            $gradsTax = $gradsTax + (300000 - 144000) * 0.2;
            $gradsAmount = $amount - 300000;
            $rate = 0.25;
        } elseif ($amount < 660000) {
            $gradsTax = $gradsTax + (420000 - 300000) * 0.25;
            $gradsAmount = $amount - 420000;
            $rate = 0.3;
        } elseif ($amount < 960000) {
            $gradsTax = $gradsTax + (660000 - 420000) * 0.3;
            $gradsAmount = $amount - 660000;
            $rate = 0.35;
        } elseif ($amount > 960000) {
            $gradsTax = $gradsTax + (960000 - 660000) * 0.35;
            $gradsAmount = $amount - 960000;
            $rate = 0.45;
        }
        return floor($gradsTax + $gradsAmount * $rate);
    }

}