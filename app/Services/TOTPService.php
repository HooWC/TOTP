<?php

namespace App\Services;

use OTPHP\TOTP;
use ParagonIE\ConstantTime\Base32;

class TOTPService
{
    public static function generateSecret()
    {
        // 生成一个随机的密钥
        $randomBytes = random_bytes(20);

        // 将密钥进行 Base32 编码
        $secret = strtoupper(Base32::encode($randomBytes));

        return $secret;
    }

    public static function generateTOTP($secret)
    {
        // 创建 TOTP 实例
        $totp = TOTP::create($secret);

        // 直接生成 TOTP，并确保格式为6位数字
        return str_pad($totp->now(), 6, '0', STR_PAD_LEFT);
    }

    public static function validateTOTP($secret, $token)
    {
        // 创建 TOTP 实例
        $totp = TOTP::create($secret);

        // 验证 TOTP
        return $totp->verify($token);
    }
}
