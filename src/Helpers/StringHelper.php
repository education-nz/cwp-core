<?php

namespace Education\Cwp\Helpers;

class StringHelper
{
    /**
     * Small helper method that removes tabs/blanks/html and combines content with a new line tag.
     *
     * @param $tag
     * @param $content
     *
     * @return string
     */
    public static function addLine($tag, $content)
    {
        return $tag.$content."\n";
    }

    /**
     * Removes tabs without removing spaces and line breaks.
     *
     * @param $string
     *
     * @return string
     */
    public static function removeTabs($string)
    {
        $string = preg_replace("/\r|\n/", '', $string);
        return trim(preg_replace('/\t+/', '', $string));
    }

    /**
     * Converts a string to upper camel case.
     *
     * For instance, 'the quick brown fox' will be converted to
     * 'TheQuickBrownFox'.
     *
     * @param string The string to convert
     *
     * @return string The given string in upper camel case.
     */
    public static function convertToUpperCamelCase($str)
    {
        // Non-alpha and non-numeric characters become spaces
        $noStrip = [];
        $str = preg_replace('/[^a-z0-9'.implode('', $noStrip).']+/i', ' ', $str);
        $str = trim($str);

        // Uppercase the first character of each word
        $str = ucwords($str);
        $str = str_replace(' ', '', $str);

        return $str;
    }


    /**
     * Determines if a string starts with a specific value.
     *
     * @param string $haystack The string being searched
     * @param string $needle Value being search for
     *
     * @return bool True, if the starts with the value. Otherwise, false.
     */
    public static function startsWith($haystack, $needle)
    {
        return $needle === ''
                || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }

}
