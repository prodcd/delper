<?php
namespace prodcd;
/**
 * PHP助手类
 * @package prodcd
 */
class Delper
{

    /**
     * 符串中一部分内容用*代替
     * @param $str 需要隐藏的密码字符串
     * @param int $leftRetain 左边显示的字符串个数
     * @param int $rightRetain 右边显示的字符串个数
     * @param int $min 小于等于此长度的字符串默认返回6个星号 ******
     * @param string $replace 默认填充星号
     * @return string
     */
    public static function showPassword($str, $leftRetain = 2, $rightRetain = 2, $min = 4, $replace = "*")
    {
        $strLen = strlen($str);
        if ($strLen <= $min) {
            return str_pad("",6, $replace);
        }
        return substr($str, 0, $leftRetain) . str_pad("", $strLen - ($leftRetain + $rightRetain), $replace) . substr($str, (0 - $rightRetain), $rightRetain);
    }
}