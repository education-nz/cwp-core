<?php

namespace Education\Cwp\Helpers;

class ArrayHelper
{
    /**
     * Removes empty elements from arrays. In this case we don't want categories/sectors that have nothing
     * in them.
     *
     * @param $haystack
     *
     * @return mixed
     */
    public static function removeEmptyElements($haystack)
    {
        foreach ($haystack as $key => $value) {
            if (is_array($value)) {
                $haystack[$key] = self::removeEmptyElements($haystack[$key]);
            }

            if (empty($haystack[$key])) {
                unset($haystack[$key]);
            }
        }

        return $haystack;
    }

    /**
     * Sorts an array based on it's keys.
     *
     * @param $array
     * @param $order
     *
     * @return mixed
     */
    public static function sortByKey($array, $order)
    {
        uksort($array, function ($a, $b) use ($order) {
            $pos_a = array_search($a, $order);
            $pos_b = array_search($b, $order);
            return $pos_a - $pos_b;
        });

        return $array;
    }
}
