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
     * 判断ip是否在规定子网中
     * @param $ip string 例如："192.168.10.125"
     * @param $ipc string 例如："192.168.10.125/24"
     * @return bool
     */
    public static function in_IP($ip, $ipc)
    {
        $ip1 = ip2long($ip);
        if (!$ip1) return false;//判断IP格式
        $ips = explode('/',$ipc);
        if (count($ips)!=2) return false;
        $ip2 = ip2long($ips[0]);
        if (!$ip2) return false;//判断IP格式
        if (!is_numeric($ips[1]) || $ips[1]>32 || $ips[1]<0) return false;//判断掩码格式
        $diff = decbin($ip1 ^ $ip2);
        if ($diff==0) return true;
        if (strlen($diff) > (32 - $ips[1])) return false;//判断掩码
        return true;
    }
}