<?php

/**
 * jPHP
 *
 * PHP has many built-in functions. Unfortunately, those functions do not offer
 * the necessary functionality in some situations. The library jPHP offers a
 * collection of functions that are based on existing php functions but
 * with extended functionality.
 *
 * @author Julian Sawicki
 *
 */
class jPHP {

    /**
     * in_array() checks if value exists. It checks by string comparison.
     * in_array_substring() checks if substring exists. It checks by stripos().
     *
     * @param string $needle
     * @param array $haystack
     * @param boolean $strict
     * @return boolean
     */
    public static function in_array_substring($needle, $haystack, $strict = false) {
        $return = false;

        if (empty($needle) || !is_string($needle) || !is_array($haystack)) {
            return $return;
        }

        foreach ($haystack as $key => $value) {

            // Attention: The haystack of stripos() is using the needle of in_array_substring()
            $occurrenceInt = stripos($needle, $value);
            if ($occurrenceInt !== false) {
                $return = true;
            }

            if ($strict) {
                $needleType = gettype($needle);
                $valueType = gettype($value);
                $return = ($needleType === $valueType ? true : false);
            }

            if ($return) {
                return $return;
            }
        }

        return $return;
    }

    /**
     * array_search() searches a value in the the array, and gives the key. It checks by string comparison.
     * array_search_glob_pattern() does the same, but it checks by globbing wildcard.
     *
     * @param string $pattern
     * @param array $haystack
     * @return boolean
     */
    public static function array_search_glob_pattern($pattern, $haystack) {
        $return = false;

        if (empty($pattern) || !is_string($pattern) || !is_array($haystack)) {
            return $return;
        }

        $key = null;
        foreach ($haystack as $key => $value) {
            if (fnmatch($pattern, $value)) {
                $return = $key;
                break;
            }
        }

        return $return;
    }

    /**
     * array_search() searches a value in the the array, and gives the key. It checks by string comparison.
     * array_search_regex_pattern() does the same, but it checks by regular expression.
     *
     * @param string $pattern
     * @param array $haystack
     * @return boolean
     */
    public static function array_search_regex_pattern($pattern, $haystack) {
        $return = false;

        if (empty($pattern) || !is_string($pattern) || !is_array($haystack)) {
            return $return;
        }

        $key = null;
        foreach ($haystack as $key => $value) {
            if (preg_match($pattern, $value)) {
                $return = $key;
                break;
            }
        }

        return $return;
    }

    /**
     * PHP 7 has a built-in is_iterable() function. But PHP 5 doens't have that
     * by default. So, this is the is_iterable() function for PHP 5.
     * Besides that the is_iterable() of PHP 7 says that stdClass is not
     * iterable, but in fact an stdClass is iterable.
     *
     * @param mixed $iterateable
     *
     * @return boolean
     */
    public static function is_iterable($iterateable) {
        return (is_array($iterateable) || is_object($iterateable) || $iterateable instanceof Traversable);
    }

    /**
     * Check if array is multidimensional
     *
     * @param array $multidimensional
     * @return boolean
     */
    public static function is_multidimensional($multidimensional, $maxDepth = 2) {

        if (empty($multidimensional) || !is_array($multidimensional)) {
            return false;
        }

        $iterations = $maxDepth - 1;
        for ($i = 1; $i <= $iterations; $i++) {
            if ($i === 1) {
                $firstItem = reset($multidimensional);
            } else {
                $firstItem = reset($firstItem);
            }

            $iterable = self::is_iterable($firstItem);
            if (!$iterable) {
                return false;
            }
        }

        return true;
    }

}
