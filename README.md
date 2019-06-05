PHP has many built-in functions. Unfortunately, those functions do not offer the necessary functionality in some situations. See the examples below. 

It's not possible for in_array() to check if a **substring** exists in the given array. Fortunately it's possible with jPHP. 
With jPHP you can use `jPHP::in_array_substring($needle, $array)`. 
 
The function array_search() searches by string comparison, it doesn't search by **pattern matching**. Fortunately it's possible with jPHP, jPHP offers `jPHP::array_search_glob_pattern($pattern, $haystack)` or `jPHP::array_search_regex_pattern($pattern, $haystack)` for this situation.
 
The library jPHP offers a collection of functions (static methods) that are based on existing php functions but with extended functionality.

Function list: 
* in_array_substring
* in_array_any
* in_array_all
* in_array_recursive
* array_search_glob_pattern
* array_search_regex_pattern
* array_search_case_insensitive
* array_filter_recursive
* array_filter_php53_shim
* is_iterable
* is_multidimensional
* array_depth
* smart_push
* substr

## Array functions

### in_array_substring
     * in_array() checks if value exists. It checks by string comparison (case sensitive), thus 'A' not equal to 'a'.
     * in_array_substring() checks if substring exists. It checks by stripos(), thus case insensitive, thus 'A' equal to 'a'.
     * in_array_substring() loops over the haystack and checks if at least 1 haystack-item exitst in any part of the needle.
     

### in_array_any
     * in_array() checks if value exists. It checks only one value.
     * in_array_any() checks if any of the given needles exists.

### in_array_all
     * in_array() checks if value exists. It checks only one value.
     * in_array_any() checks if all of the given needles exists.
     
### in_array_recursive
     * in_array() checks if a value exists in an array. It checks only one level deep. 
     * in_array_recursive() checks recursively.    
     
### array_search_glob_pattern
     * array_search() searches a value in the the array, and gives the key. It checks by string comparison (case sensitive).
     * array_search_glob_pattern() does the same, but it checks by globbing patterns/standard wildcards.

### array_search_regex_pattern
     * array_search() searches a value in the the array, and gives the key. It checks by string comparison.
     * array_search_regex_pattern() does the same, but it checks by regular expression.

### array_search_case_insensitive
     * array_search() compares case-sensitive.
     * array_search_case_insensitive() compares case-insentivie

### array_filter_recursive
     * array_filter() filters an array. But not recursively.
     * array_filter_recursive() filters an array recursively.
     
### array_filter_php53_shim
     * array_filter() received optional flag parameters in PHP 5.6: ARRAY_FILTER_USE_KEY and ARRAY_FILTER_USE_BOTH.
     * So these flags won't work in versions below php 5.6.
     * array_filter_php53_shim() is a shim which allows the usage of flags in php 5.3. 
     * Note: it does not work for php 5.2 because of Callbacks.
     
### is_iterable
     * PHP 7 has a built-in is_iterable() function. But PHP 5 doens't have that
     * by default. So, this is the is_iterable() function for PHP 5.
     * Besides that the is_iterable() of PHP 7 says that stdClass is not
     * iterable, but in fact an stdClass is iterable in foreach().
     
### is_multidimensional
     * is_multidimensional() checks if array is multidimensional.
     
### array_depth
     * array_depth() gets the highest tree depth from array. It checks recursively.
### smart_push
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

## String functions

### substrstr     
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

