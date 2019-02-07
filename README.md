PHP has many built-in functions. Unfortunately, those functions do not offer the necessary functionality in some situations. See the examples below. 

It's not possible for in_array() to check if a **substring** exists in the given array. Fortunately it's possible with jPHP. 
With jPHP you can use `jPHP::in_array_substring($needle, $array)`. 
 
The function array_search() searches by string comparison, it doesn't search by **pattern matching**. Fortunately it's possible with jPHP.
With jPHP you can use `jPHP::array_search_glob_pattern($pattern, $haystack)` or `jPHP::array_search_regex_pattern($pattern, $haystack)`
 
The library jPHP offers a collection of functions that are based on existing php functions but with extended functionality.

Function list: 
* in_array_substring
* in_array_any
* in_array_all
* array_search_glob_pattern
* array_search_regex_pattern
* array_search_case_insensitive
* array_filter_recursive
* is_iterable
* is_multidimensional
* array_depth
* smartPush
* substrstr

## Array functions

### in_array_substring
     * in_array() checks if value exists. It checks by string comparison (case sensitive), thus 'A' not equal to 'a'.
     * in_array_substring() checks if substring exists. It checks by stripos(), thus case insensitive, thus 'A' equal to 'a'.
     * in_array_substring() loops over the haystack and checks if at least 1 haystack-item exitst in any part of the needle.
     

### in_array_any
     * in_array() checks if value exists. It checks only one value.
     * in_array_any() checks if any of the given needle exists.

### in_array_all
     * in_array() checks if value exists. It checks only one value.
     * in_array_any() checks if all of the given needle exists.
     
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
     
### is_iterable
     * PHP 7 has a built-in is_iterable() function. But PHP 5 doens't have that
     * by default. So, this is the is_iterable() function for PHP 5.
     * Besides that the is_iterable() of PHP 7 says that stdClass is not
     * iterable, but in fact an stdClass is iterable in foreach().
     
### is_multidimensional
     * is_multidimensional() checks if array is multidimensional.
     
### array_depth
     * array_depth() gets the highest tree depth from array. It checks recursively.
### smartPush


