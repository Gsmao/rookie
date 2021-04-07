<?php


namespace Rooike\gsmao;


class Review {

    /**
     * 快排
     * @param $array
     * @param $left
     * @param $right
     */
    public function quickSort(&$array, $left, $right) {
        /**
         * 1：选择基准数
         * 2：采取分治思想，将数据分类，其中一边都小于基准数，其中一遍都大于基准数
         * 3：循环对基准数左右两个区间做第二步操作，直到区间只剩下一个数字
         */
        if ($left >= $right) {
            return;
        }
        $i = $left;
        $j = $right;
        $tmp = $array[$left];
        while ($left < $right) {
            //从右向左找第一个小于x的数
            while ($left < $right && $array[$right] >= $tmp) {
                $right--;
            }
            if ($left < $right) {
                //填坑并将左标++
                $array[$left++] = $array[$right];
            }

            //从左向右找第一个大于x的数
            while ($left < $right && $array[$left] <= $tmp) {
                $left++;
            }
            if ($left < $right) {
                //填坑并将右标--
                $array[$right--] = $array[$left];
            }
        }

        //最后将$tmp填充到
        $array[$left] = $tmp;

        $this->quickSort($array, $i, $left - 1); // 递归调用
        $this->quickSort($array, $left + 1, $j);
    }

    public function mergeSort($arr)
    {
        $len = count($arr);
        if ($len < 2) {
            return $arr;
        }
        $middle = floor($len / 2);
        $left = array_slice($arr, 0, $middle);
        $right = array_slice($arr, $middle);
        return $this->merge($this->mergeSort($left), $this->mergeSort($right));
    }

    /**
     * 合并两个有序数组为有序
     * @param $left
     * @param $right
     * @return array
     */
    public function merge($left, $right)
    {
        $result = [];

        //先
        while (count($left) > 0 && count($right) > 0) {
            if ($left[0] <= $right[0]) {
                $result[] = array_shift($left);
            } else {
                $result[] = array_shift($right);
            }
        }

        while (count($left)) {
            $result[] = array_shift($left);
        }

        while (count($right)) {
            $result[] = array_shift($right);
        }

        return $result;
    }

}