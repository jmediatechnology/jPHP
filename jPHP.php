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
     * in_array() checks if value exists. It checks by string comparison (case sensitive), thus 'A' not equal to 'a'.
     * in_array_substring() checks if substring exists. It checks by stripos(), thus case insensitive, thus 'A' equal to 'a'.
     * in_array_substring() loops over the haystack and checks if at least 1 haystack-item exitst in any part of the needle.
     *
     *
     * @param string|array $inArrayNeedle  The searched value.
     * @param array $inArrayHaystack The array.
     * @param boolean $strict
     * @return boolean
     */
    public static function in_array_substring($inArrayNeedle, $inArrayHaystack, $strict = false) {
        $return = false;

        $isString = false;
        if (is_string($inArrayNeedle)) {
            $isString = true;
        }
        $isArray = false;
        if (is_array($inArrayNeedle)) {
            $isArray = true;
        }

        if (empty($inArrayNeedle) || (!$isString && !$isArray ) || !is_array($inArrayHaystack)) {
            return $return;
        }

        foreach ($inArrayHaystack as $key => $findme) {

            if ($isArray) {
                foreach ($inArrayNeedle as $inArrayNeedleItem) {

                    $occurrenceInt = stripos($inArrayNeedleItem, $findme);
                    if ($occurrenceInt !== false && !$strict) {
                        $return = true;
                        continue 2;
                    }
                    if ($occurrenceInt !== false && $strict) {
                        $return = true;
                    }
                    if ($strict && $return) {
                        $needleType = gettype($inArrayNeedleItem);
                        $valueType = gettype($findme);
                        $return = ($needleType === $valueType ? true : false);
                        continue 2;
                    }
                }
            }

            if ($isString) {
                $occurrenceInt = stripos($inArrayNeedle, $findme);
                if ($occurrenceInt !== false) {
                    $return = true;
                }

                if ($strict) {
                    $needleType = gettype($inArrayNeedle);
                    $valueType = gettype($findme);
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
     * in_array() checks if value exists. It checks only one value.
     * in_array_any() checks if any of the given needle exists.
     *
     * @link https://stackoverflow.com/questions/7542694/in-array-multiple-values
     *
     * @param array $needle
     * @param array $haystack
     * @return boolean
     */
    public static function in_array_any(array $needle, array $haystack) {
        return (boolean)array_intersect($needle, $haystack);
    }

    /**
     * in_array() checks if value exists. It checks only one value.
     * in_array_any() checks if all of the given needle exists.
     *
     * @param array $needle
     * @param array $haystack
     * @return boolean
     */
    public static function in_array_all(array $needle, array $haystack) {
        $intersect = array_intersect($needle, $haystack);

        if(!$intersect){
            return false;
        }

        $needleCount = count($needle);
        $intersectCount = count($intersect);

        if($needleCount === $intersectCount){
            return true;
        }

        return false;
    }

    /**
     * array_search() searches a value in the the array, and gives the key. It checks by string comparison (case sensitive).
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
     * array_search() compares case-sensitive.
     * array_search_case_insensitive() compares case-insentivie
     *
     * @param string $needle
     * @param array $haystack
     * @return boolean
     */
    public static function array_search_case_insensitive($needle, $haystack) {
        $key = array_search(strtolower($needle), array_map('strtolower', $haystack));
        return $key;
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
     * iterable, but in fact an stdClass is iterable in foreach().
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

    /**
     * Get the highest tree depth from array.
     *
     * @link URL https://stackoverflow.com/questions/262891/is-there-a-way-to-find-out-how-deep-a-php-array-is
     * @param array $array
     * @return int
     */
    public static function array_depth(array $array) {
        $max_depth = 1;

        foreach ($array as $value) {

            if (is_array($value)) {
                $depth = self::array_depth($value) + 1;

                if ($depth > $max_depth) {
                    $max_depth = $depth;
                }
            }
        }

        return $max_depth;
    }

    /**
     * Adding new elements to an array can be done through the string access operator.
     * For example like this:
     * $arr['x'] = 42;
     *
     * Note that the string access operator can overwrite elements if the key is used twice or more.
     * For example key 'x' will be overwritten in this scenario:
     * $arr['x'] = 50;
     * $arr['x'] = 60;
     *
     * smart_push() doesn't overwrite.
     * smart_push() will keep the old value.
     * jPHP::smart_push($arr, 'x', 70); // $arr['x'] = [0 => 60, 1 => 70];
     * jPHP::smart_push($arr, 'x', 80); // $arr['x'] = [0 => 60, 1 => 70, 2 => 80];
     *
     *
     * @param mixed $array By reference
     * @param string|int $key The array key
     * @param mixed $value The new value that will be added
     */
    public static function smartPush(&$array, $key, $value) {

        if(!isset($array[$key])){
            $array[$key] = $value;
        } else if (is_scalar($array[$key])) {
            $buff = $array[$key];
            unset($array[$key]);

            $array[$key][] = $buff;
            $array[$key][] = $value;
        } else if (is_array($array[$key])) {
            $array[$key][] = $value;
        }
    }

// ------------------------- STRING FUNCTIONS ----------------------------------

    /**
     * Returns part of the string that matches in both strings.
     *
     * substr() will return a substring by offset number.
     * E.g. substr('Australia', 0, 5) will produce: 'Austr'
     *
     * substr_compare() will compare two strings and return the part that matches in both strings.
     * E.g. substrstr('Australia', 'Austria') will produce: 'Austr'
     *
     * @param string $strA
     * @param string $strB
     * @return string Returns the part that matches. On no match it will return an empty string.
     */
    public static function substrstr($strA, $strB) {

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
