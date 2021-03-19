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
     * @param int $leftRetain 左边显示的字符串个数，大于等于0
     * @param int $rightRetain 右边显示的字符串个数，大于等于0
     * @param int $min 当mb_strlen($str) < $min时，返回"******"，大于等于0
     * @param string $replace 默认填充星号
     * @param int $maxRetain "*"最大显示个数，默认不限制，大于等于0或null
     * @return string
     */
    public static function showPassword($str, $leftRetain = 2, $rightRetain = 2, $min = 4, $replace = "*", $maxRetain = null)
    {
        if(!is_int($leftRetain) || $leftRetain < 0) throw new \Exception('$leftRetain 必须大于等于0');
        if(!is_int($rightRetain) || $rightRetain < 0) throw new \Exception('$rightRetain 必须大于等于0');
        if(!is_int($min) || $min < 0) throw new \Exception('$min 必须大于等于0');
        if(!is_null($maxRetain) && (!is_int($min) || $maxRetain < 0)) throw new \Exception('$maxRetain 必须是正整数或null');
        //如果字符串数量长度小于$min，则返回"******"
        $strLen = mb_strlen($str);
        if ($strLen <= $min) {
            return str_pad("", 6, $replace);
        }
        //如果左右保留数量，大于字符串长度，则返回str
        if ($leftRetain + $rightRetain > $strLen)
        {
            return $str;
        }
        //中间保留*数量，隐藏的数字与$maxRetain取最小值
        $padLength = $strLen - ($leftRetain + $rightRetain);
        $padLength = (!is_null($maxRetain) && $padLength > $maxRetain) ? $maxRetain : $padLength;
        $pad = str_pad("", $padLength, $replace);
        
        return mb_substr($str, 0, $leftRetain) . $pad . mb_substr($str, (0 - $rightRetain), $rightRetain);
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
    /**
     * bigint转字符串，不支持-9223372036854775808
     * 超过范围的整数在PHP中会被转换成float，不支持
     * $codes 的顺序可以任意更改，但需要两个函数使用同样的$codes
     * @param $num bigint 范围-9223372036854775807 ~ 9223372036854775807
     * @param $ipc string 例如："192.168.10.125/24"
     * @return string 返回字符串可以安全在URL中传输
     */
    public static function bigintToCode($num)
    {
        $out  = "";
        $codes = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ,_";
        for ($i=0;$i<11;$i++)
        {
            if ($num == 0) break;
            $key = $num & 0b00111111;
            $num = $num >> 6;
            $out = $codes[$key].$out;
        }
        return $out;
    }
    /**
     * 字符串转bigint
     * @param $code string 从bigintToCode()返回的字符串
     * @return bigint
     */
    public static function codeToBigint($code)
    {
        $codes = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ,_";
        $num = 0;
        $codelen = strlen($code);
        for($i=0; $i < $codelen; $i++)
        {
            $char = $code[$i];
            $pos  = strpos($codes, $char);
            $num  = $num << 6;
            $num  +=$pos;
        }
        return $num;
    }
    /**
     * 生成随机字符串
     * @param $length int 返回的字符串长度
     * @param $strTpl string 字符串模板
     * @return string
     */
    public static function randStr($length, $strTpl='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')
    {
        //字符组合
        $len = strlen($strTpl) - 1;
        $randstr = '';
        for ($i = 0; $i < $length; $i++)
        {
            $num = mt_rand(0,$len);
            $randstr .= $strTpl[$num];
        }
        return $randstr;
    }
}