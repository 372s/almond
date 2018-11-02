<?php
//php aes加密类
class AESCrypt
{
    private static $test;

    protected static $instance;
    public $iv = null;
    public $key = 'k1i2n3g4y5e6e';
    public $bit = 128;
    private $cipher;

    public static function init()
    {
        self::$test = 1000;
        echo self::$test;
    }

    public function __construct()
    {
        echo 2;
    }
    public static function getInstance()
    {
        var_dump(self::$instance);
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function encrypt($input)
    {
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $pad = $size - (strlen($input) % $size);
        $input = $input . str_repeat(chr($pad), $pad);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $this->key, $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode(urlencode($data));
        return $data;
    }

    public function decrypt($sStr)
    {
        $decrypted = mcrypt_decrypt(
            MCRYPT_RIJNDAEL_128,
            $this->key,
            urldecode(base64_decode($sStr)),
            MCRYPT_MODE_ECB
        );
        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s - 1]);
        $decrypted = substr($decrypted, 0, -$padding);
        return $decrypted;
    }

    /**
     * 动态加密字符串
     * aes加密
     * @param  $input
     */
    public static function aesEncrypt($input)
    {
        $key = self::random(16, '1234567890abcdefghijklmnopqrstuvwxyz'); //随机生成16位key

        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB); //128位时为16
        $pad = $size - (strlen($input) % $size); //取得补码的长度
        $input = $input . str_repeat(chr($pad), $pad); //用ASCII码为补码长度的字符， 补足最后一段

        $data = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $input, MCRYPT_MODE_ECB);
        $data = base64_encode($data);
        //key拼在字符串前
        $data = $key . $data;
        return $data;
    }

    /**
     * 动态加密字符串
     * aes 解密
     * @param  $sStr
     */
    public static function aesDecrypt($sStr)
    {
        //取出前16位为key
        $sKey = substr($sStr, 0, 16);
        $sStr = substr($sStr, 16);

        $decrypted = mcrypt_decrypt(
            MCRYPT_RIJNDAEL_128,
            $sKey,
            base64_decode($sStr),
            MCRYPT_MODE_ECB
        );
        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s - 1]);
        $decrypted = substr($decrypted, 0, -$padding);
        return $decrypted;
    }

    // 动态加密随机key
    public static function random($length, $chars = '1234567890')
    {
        $hash = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $hash .= $chars[mt_rand(0, $max)];
        }
        return $hash;
    }
}
