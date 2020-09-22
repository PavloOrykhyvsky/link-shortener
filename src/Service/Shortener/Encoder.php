<?php

namespace App\Service\Shortener;

class Encoder
{
    public function encode(int $num): string
    {
        return strtr(rtrim(base64_encode(pack('i', $num)), '='), '+/', '-_');
    }

    public function decode($base64): int
    {
        $number = unpack('i', base64_decode(str_pad(strtr($base64, '-_', '+/'), strlen($base64) % 4, '=')));

        return $number[1];
    }
}
