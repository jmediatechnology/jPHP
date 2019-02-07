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
