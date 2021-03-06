<?php

namespace jPHP;

/**
 * jPHP
 *
 * PHP has many built-in functions. 
 * However, my opinion is that PHP doesn't have some built-in functions 
 * that should be part of PHP. So I added them in jPHP. 
 * What's next is that some built-in functions don't offer the necessary 
 * functionality in some situations. So, I added the necessary functionality 
 * in jPHP.
 * 
 * The library jPHP offers a collection of functions that are based on 
 * existing php functions but with extended functionality.
 *
 * @author Julian Sawicki
 *
 */
class jPHP {

// ------------------------- ARRAY FUNCTIONS -----------------------------------
    /**
     * in_array() checks if value exists. It checks by string comparison (case sensitive), thus 'A' not equal to 'a'.
     * in_array_substring() just checks if the given substring exists in the haystack.
     *
     * How it works:
     * in_array_substring() loops over the mainHaystack and,
     * checks if the mainNeedle exists in the mainHaystack as a substring.
     *
     * The string comparison function used here is stripos(),
     * thus case insensitive, thus 'A' equal to 'a'.
     *
     * Example with in_array():
     *     $os = array("Mac", "NT", "Irix", "Linux");
     *     if (in_array("Irix", $os)) {
     *         echo "Got Irix";
     *     }
     *
     * Example with in_array_substring():
     *     if (in_array_substring("ir", $os)) {
     *         echo "Got Irix";
     *     }
     *
     * @param string|array $mainNeedle  The substring that will be searched.
     * @param array $mainHaystack The array.
     * @param boolean $strict
     * @return boolean
     */
    public static function in_array_substring($mainNeedle, $mainHaystack, $strict = false) {
        $return = false;

        $mainNeedleIsString = false;
        if (is_string($mainNeedle)) {
            $mainNeedleIsString = true;
        }
        $mainNeedleIsArray = false;
        if (is_array($mainNeedle)) {
            $mainNeedleIsArray = true;
        }

        if (empty($mainHaystack) || (!$mainNeedleIsString && !$mainNeedleIsArray ) || !is_array($mainHaystack)) {
            return $return;
        }

        foreach ($mainHaystack as $key => $haystack) {

            if ($mainNeedleIsArray) {
                foreach ($mainNeedle as $mainNeedleItem) {

                    $occurrenceInt = stripos($haystack, $mainNeedle);
                    if ($occurrenceInt !== false && !$strict) {
                        $return = true;
                        continue 2;
                    }
                    if ($occurrenceInt !== false && $strict) {
                        $return = true;
                    }
                    if ($strict && $return) {
                        $needleType = gettype($mainNeedleItem);
                        $valueType = gettype($haystack);
                        $return = ($needleType === $valueType ? true : false);
                        continue 2;
                    }
                }
            }

            if ($mainNeedleIsString) {
                $occurrenceInt = stripos($haystack, $mainNeedle);
                if ($occurrenceInt !== false) {
                    $return = true;
                }

                if ($strict) {
                    $needleType = gettype($mainNeedle);
                    $valueType = gettype($haystack);
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
     * in_array_substringArray() is a syntactic sugar for multiple stripos().
     *
     * Checks if the haystack has at least one substring which reside in
     * the given substringArray.
     *
     * Example:
     * $mainHaystack = 'Australia';
     * $substringList = array('ab','au');
     * jPHP::in_array_substringArray($mainHaystack, $substringList); // boolean true
     *
     * How it works:
     * The $substringList will be traversed. In this case ['ab', 'au'].
     * Each iteration will search try to match a substring in the mainHaystack.
     * Thus, the first iteration does this:
     *     stripos('Australia', 'ab'); // false
     * Substring 'ab' doesn't exists in mainHaystack string 'Australia'.
     * So it goes to the next iteration.
     * The second iteration does tis:
     *      stripos('Australia', 'au'); // integer 0
     * Substring 'au' exists in mainHaystack string 'Australia',
     * so a boolean true gets returned.
     *
     * Instead of doing something like this:
     *     foreach ($array as $key => $value) {
     *         if (stripos($value, 'ab') !== false || stripos($value, 'au') !== false) {
     *             // something
     *         }
     *     }
     * You can do this:
     *     foreach ($array as $key => $value) {
     *         if (jPHP::in_array_substringArray($value, array('ab','au'))) {
     *             // something
     *         }
     *     }
     *
     * @param string|array $mainHaystack  The searched value.
     * @param array $substringList The array containing the substrings.
     * @param boolean $strict
     * @return boolean
     */
    public static function in_array_substringArray($mainHaystack, $substringList, $strict = false) {
        $return = false;

        $mainHaystackIsString = false;
        if (is_string($mainHaystack)) {
            $mainHaystackIsString = true;
        }
        $mainHaystackIsArray = false;
        if (is_array($mainHaystack)) {
            $mainHaystackIsArray = true;
        }

        if (empty($mainHaystack) || (!$mainHaystackIsString && !$mainHaystackIsArray ) || !is_array($substringList)) {
            return $return;
        }

        foreach ($substringList as $key => $findme) {

            if ($mainHaystackIsArray) {
                foreach ($mainHaystack as $haystack) {

                    $occurrenceInt = stripos($haystack, $findme);
                    if ($occurrenceInt !== false && !$strict) {
                        $return = true;
                        continue 2;
                    }
                    if ($occurrenceInt !== false && $strict) {
                        $return = true;
                    }
                    if ($strict && $return) {
                        $needleType = gettype($haystack);
                        $valueType = gettype($findme);
                        $return = ($needleType === $valueType ? true : false);
                        continue 2;
                    }
                }
            }

            if ($mainHaystackIsString) {
                $occurrenceInt = stripos($mainHaystack, $findme);
                if ($occurrenceInt !== false) {
                    $return = true;
                }

                if ($strict) {
                    $needleType = gettype($mainHaystack);
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
     * in_array() checks if a value exists in an array. It checks only one level deep.
     * in_array_recursive() checks recursively.
     *
     * @link http://php.net/manual/en/function.in-array.php#58560 Similar solution
     *
     * @param string|int $needle
     * @param array $haystack
     * @return boolean
     */
    public static function in_array_recursive($needle, array $haystack) {

        if(in_array($needle, $haystack)){
            return true;
        }

        $found = false;
        foreach($haystack as $k => $v) {

            if(is_array($v)){
                $found = self::in_array_recursive($needle, $v);
            }
        }

        return $found;
    }
    
    /**
     * 
     * $arrayA = [[1,2,3],[10,11],[12,13,14]];
     * $arrayB = [[1,2,3],[5,6],[7,8,9]];
     * array_intersect_recursive($arrayA, $arrayB); // return: [[1,2,3],[],[]]
     * 
     * @param array $arrayA
     * @param array $arrayB
     * @param array $outputArray
     * @return array
     */
    public static function array_intersect_recursive($arrayA, $arrayB, $outputArray = array()) {
    
        $itemA = current($arrayA);
        $itemB = current($arrayB);
        $kA = key($arrayA);
        $kB = key($arrayB);
        unset($arrayA[$kA]);
        unset($arrayB[$kB]);

        if(!is_array($itemA) || !is_array($itemB)){
            return $outputArray;
        }

        $outputArray[] = array_intersect($itemA, $itemB);

        return array_intersect_recursive($arrayA, $arrayB, $outputArray);
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
     * array_filter() filters an array. But not recursively.
     * array_filter_recursive() filters an array recursively.
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
     * array_filter() received optional flag parameters in PHP 5.6: ARRAY_FILTER_USE_KEY and ARRAY_FILTER_USE_BOTH.
     * So these flags won't work in versions below php 5.6.
     * array_filter_php53_shim() is a shim which allows the usage of flags in php 5.3.
     *
     * Note: it does not work for php 5.2 because of Callbacks.
     * More info: https://www.php.net/manual/en/language.types.callable.php#117260
     *
     * Note for usage: call this method with error-surprssion operator or
     * supply the flags as strings instead of constant name.
     *
     * Examples:
     *  @jPHP::array_filter_php53_shim($arr, $callback, ARRAY_FILTER_USE_KEY);
     *  jPHP::array_filter_php53_shim($arr, $callback, 'ARRAY_FILTER_USE_KEY');
     *
     *
     * @param array $array
     * @param callable $callback
     * @param mixed $flag
     * @return type
     */
    public static function array_filter_php53_shim($array, $callback, $flag = 0){

        $newArray = array();

        end($array);
        $lastKey = key($array);
        $lastValue = current($array);
        reset($array);
        while (!empty($array)) {
            $key = key($array);
            $val = current($array);

            if($flag === 0){
                // pass value only
                $filter = $callback($val);
            }

            if($flag === 'ARRAY_FILTER_USE_KEY' || $flag === 2 ){
                // pass key only
                $filter = $callback($key);
            }

            if($flag === 'ARRAY_FILTER_USE_BOTH' || $flag === 1 ){
                // pass value and key
                $filter = $callback($val, $key);
            }

            if($filter){
                $newArray[$key] = $val;
            }

            if ($key === $lastKey && $val === $lastValue) {
                break;
            }
            next($array);
        }

        return $newArray;
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
     * is_multidimensional() checks if array is multidimensional.
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
     * array_depth() gets the highest tree depth from array. It checks recursively.
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
    public static function smart_push(&$array, $key, $value) {

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
     * E.g. substr('Australia', 0, 5) will produce: 'Austr'.
     *
     * strstr() will return a portion of the haystack by needle
     * E.g. strstr('Australia', 'alia', true) will produce: 'Austr'
     *
     * substrstr() is like a combination of substr() and strstr().
     * substrstr() will compare two strings and return the part that matches in both strings.
     * E.g. substrstr('Australia', 'Austria') will produce: 'Austr'.
     *
     * @param string $strA
     * @param string $strB
     * @return string Returns the part that matches. On no match it will return an empty string.
     */
    public static function substrstr($strA, $strB) {

        $arrayStrA = str_split($strA);
        $arrayStrB = str_split($strB);

        foreach ($arrayStrA as $offset => $value) {

            if(!array_key_exists($offset, $arrayStrB)){
                break;
            }

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

    /**
     * Alias of in_array_substringArray.
     *
     * arr_stripos() is a syntactic sugar for multiple stripos().
     * array_stripos() is a syntactic sugar for multiple stripos().
     * stripos_array() is a syntactic sugar for multiple stripos().
     *
     * Instead of doing something like this:
     *     foreach ($array as $key => $value) {
     *         if (stripos($value, 'ab') !== false || stripos($value, 'au') !== false) {
     *             // something
     *         }
     *     }
     * You can do this:
     *     foreach ($array as $key => $value) {
     *         if (jPHP::stripos_array($value, array('ab','au'))) {
     *             // something
     *         }
     *     }
     *
     * @param string|array $mainHaystack  The searched value.
     * @param array $substringList The array containing the substrings.
     * @param boolean $strict
     * @return boolean
     */
    public static function stripos_array($mainHaystack, $substringList, $strict = false){
        return self::in_array_substringArray($mainHaystack, $substringList, $strict);
    }

// ------------------------- DATE / TIME FUNCTIONS ----------------------------------
    
   /**
     * Convert the amount of minutes to a digital format, just like a digital clock. 
     *
     * You can supply int 90, this function gives you: "1:30".
     * If you supply an integer greater than 1440, then "00:00" is returned.
     * 
     * @param int $amountOfMinutes
     * @return string
     */
    public static function convertMinutesIntToDigitalClockFormat($amountOfMinutes){
        if($amountOfMinutes > 1440){
            return '00:00';
        }
        $hours = (int)($amountOfMinutes  / 60);
        $minutes = $amountOfMinutes % 60;
        return str_pad($hours, 2, '0') . ':' . str_pad($minutes, 2, '0');
    }
    
    /**
     * Convert the amount of seconds to a human readable format. 
     *
     * You can supply int 129600, this function returns: "1 days 12:0:0".
     * 
     * @param int $amountOfSeconds 
     * @return string
     */
    public static function convertSecondsToDaysHoursMinutesSeconds($amountOfSeconds) {
	
	    $amountOfDays = (int)($amountOfSeconds / 86400);
	    $secondsRemaining = (int)($amountOfSeconds % 86400);

	
	    $amountOfHours = (int)($secondsRemaining / 3600);
	    $secondsRemaining = (int)($secondsRemaining % 3600);

	    $amountOfMinutes = (int)($secondsRemaining / 60);	
	    $secondsRemaining = (int)($secondsRemaining % 60);	
	
	
	    return $amountOfDays . ' days ' . $amountOfHours . ':' . $amountOfMinutes . ':' . $secondsRemaining;
    }
}
