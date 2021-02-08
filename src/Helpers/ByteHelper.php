<?php

namespace Education\Cwp\Helpers;

class ByteHelper
{
    /**
     * Indesign is awkward. This function is awkward.
     *
     * @param $input
     *
     * @return number|string
     */
    public static function changeByteOrder($input)
    {
        $number = iconv('UTF-8', 'UTF-16LE', $input);

        $data = dechex($number);

        if (strlen($data) <= 2) {
            return $number;
        }

        $unpack = unpack('H*', strrev(pack('H*', $data)));
        $hexdec = hexdec($unpack[1]);

        return $hexdec;
    }
}
