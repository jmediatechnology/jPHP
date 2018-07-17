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

// ------------------------- ARRAY FUNCTIONS -----------------------------------
    /**
     * in_array() checks if value exists. It checks by string comparison.
     * in_array_substring() checks if substring exists. It checks by stripos().
     *
     * @param string|array $needle  The searched value. If needle is a string, the comparison is done by stripos().
     * @param array $haystack The array.
     * @param boolean $strict
     * @return boolean
     */
    public static function in_array_substring($needle, $haystack, $strict = false) {
        $return = false;

        $isString = false;
        if(is_string($needle)){
            $isString = true;
        }
        $isArray = false;
        if(is_array($needle)){
            $isArray = true;
        }

        if (empty($needle) || ( !$isString && !$isArray ) || !is_array($haystack)) {
            return $return;
        }

        foreach ($haystack as $key => $value) {

            if($isArray) {
                foreach($needle as $needleItem){

                    $occurrenceInt = stripos($value, $needleItem);
                    if ($occurrenceInt !== false && !$strict) {
                        $return = true;
                        continue 2;
                    }
                    if ($occurrenceInt !== false && $strict) {
                        $return = true;
                    }
                    if ($strict && $return) {
                        $needleType = gettype($needleItem);
                        $valueType = gettype($value);
                        $return = ($needleType === $valueType ? true : false);
                        continue 2;
                    }
                }
            }

            if ($isString) {
                $occurrenceInt = stripos($value, $needle);
                if ($occurrenceInt !== false) {
                    $return = true;
                }

                if ($strict) {
                    $needleType = gettype($needle);
                    $valueType = gettype($value);
                    $return = ($needleType === $valueType ? true : false);
                }
            }

            if ($return) {
                return $return;
            }
        }

        return $return;
    }

    /**
     * array_search() searches a value in the the array, and gives the key. It checks by string comparison.
     * array_search_glob_pattern() does the same, but it checks by globbing patterns/standard wildcards.
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
     * Filter an Array recursively.
     *
     * @param array $array The array to be filtered.
     * @param callable|null $callback The function that defines the filter rules. Return false means filter it.
     * @param int $flag Define what to pass to the callback function. Value (default) or key or both.
     *
     * @return array
     */
    public static function array_filter_recursive($array, $callback = null, $flag = 0) {

        foreach ($array as &$item) {
            if (is_array($item)) {
                $item = self::array_filter_recursive($item, $callback, $flag);
            }
        }

        if (isset($callback)) {
            return array_filter($array, $callback, $flag);
        }

        if (!isset($callback)) {
            return array_filter($array);
        }
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

// ------------------------- STRING FUNCTIONS ----------------------------------

    /**
     * Returns part of the string that matches in both strings.
     *
     * substr() will return a substring by offset number.
     * substr_compare() will compare two strings and return the part that matches in both strings.
     * E.g. substr_compare('Australia', 'Austria') will produce: 'Austr'
     *
     * @param string $strA
     * @param string $strB
     * @return string Returns the part that matches. On no match it will return an empty string.
     */
    public static function substr_compare($strA, $strB) {

        $arrayStrA = str_split($strA);
        $arrayStrB = str_split($strB);

        foreach ($arrayStrA as $offset => $value) {

            if ($arrayStrB[$offset] === $value) {
                continue;
            }

            if ($arrayStrB[$offset] !== $value) {
                break;
            }
        }

        $rest = substr($strA, 0, $offset);

        return $rest;
    }

}
