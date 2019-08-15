<?php

namespace prodcd;
/**
 * PHP助手类
 * @package prodcd
 */
class delper
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
            return str_pad("", 6, $replace);
        }
        return substr($str, 0, $leftRetain) . str_pad("", $strLen - ($leftRetain + $rightRetain), $replace) . substr($str, (0 - $rightRetain), $rightRetain);
    }

    /**
     * 判断字符串是不是IP地址
     * @param $ipstr
     * @return bool
     */
    /*public static function is_ip($ipstr)
    {
        //判断字符串长度
        $ipLen = strlen($ipstr);
        if ($ipLen > 15 || $ipLen < 7) return false;
        //判断字符串规格
        $ip = explode('.', $ipstr);
        $countIp = count($ip);
        if ($countIp != 4) return false;
        //判断数字在0-255之间
        for ($i = 0; $i < $countIp; $i++) {
            if (!is_numeric($ip[$i]) || $ip[$i] > 255 || $ip[$i] < 0) {
                return false;
            }
        }
        return true;
    }*/

    /**
     * IP地址转二进制
     * @param $ipStr
     * @return bool|string
     */
    public static function ip2bin($ipStr)
    {
        $ip = ip2long($ipStr);
        if (!$ip) return false;
        $ipUint = sprintf("%u", $ip);
        return decbin($ipUint);
    }
}