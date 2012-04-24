<?php
    /*  An improved string type, a bit like the python string.
        Note that, as close as the syntax will be, there will always be
        differences: the exceptions you expect, keyword arguments
        limitation, use of tuples and, possibly, PHP reserved keywords.
        
        Why use a string class:
        - abstracts stupid PHP function names
        - move a small step towards OOP
        - normalize argument sequences - no need to look them up!
        
        Why not use a string class:
        - uses more memory
        - slower
        - not 100% compatible

        Some differences are blindingly obvious:
        - all method names follow the PHP function naming convention
          (lower_case_underscores, not camelCase).
        - the Str class is unicode, because it is 2012.
          (you can get a ASCII string by encode()ing it, I guess.)
        - returns are all Str objects with string representation.

        Also, I don't implement functions I don't like, or functions
        I don't know how.
        - e.g. who uses expandtabs? go write your own expandtabs.
        
        Contains some code from php-string http://code.google.com/p/php-string/
    */
    
    class BaseString {
        /*  Functions' scope. Not meant to be accessed.
        
            See "class Str" (below) instead!
        
            Static functions are 4x faster, and saves lots of RAM.
        */
        const DE = 'UTF-8';

        public static function capitalize ($s) {
            // Return a copy of the string with its first character capitalized
            // and the rest lowercased.
            if (!isset ($s[0])) {
                return '';
            }
            return new Str (mb_strtoupper ($s[0], self::DE) .
                            self::substring ($s, 1, PHP_INT_MAX));
        }
        
        public static function center ($s, $width, $fillchar) {
            // Return centered in a string of length width. Padding is done
            // using the specified fillchar (default is a space).
            return new Str (self::_mb_str_pad ($s, $width, $fillchar, STR_PAD_BOTH));
        }
        
        public static function charAt ($s, $point) { // JS
            return new Str (self::substring ($s, $point, 1));
        }
        
        public static function charCodeAt ($s, $point) { // JS
            // ord() is not unicode-safe!
            return ord (mb_substr ($s, $point, 1, self::DE));
        }
        
        public static function concat ($s, $args) {
            // returns added function arguments to the string.
            // original string is not modified.
            $r = $s;
            foreach($args as $arg) {
                $r .= (string) new Str ($arg);
            }
            return new Str ($r);
        }
        
        public static function count ($s, $sub, $start = 0, $end = PHP_INT_MAX) {
            // Return the number of non-overlapping occurrences of substring
            // sub in the range [start, end]. Optional arguments start and end
            // are interpreted as in slice notation.
            $tmp_str = mb_substr ($s, $start, $end, self::DE);
            return mb_substr_count ($tmp_str, (string) $sub, self::DE);
        }
        
        public static function endswith ($s, $suffix, $start = 0, 
                                         $end = PHP_INT_MAX) {
            // Return True if the string ends with the specified suffix,
            // otherwise return False. suffix can also be a tuple of suffixes
            // to look for. With optional start, test beginning at that
            // position. With optional end, stop comparing at that position.

            // http://www.php.net/manual/en/function.mb-substr.php
            $tmp_str = mb_substr ($s, $start, $end, self::DE);
            $len_suffix = self::length ($suffix);
            return mb_substr ($tmp_str, // haystack
                              self::length ($tmp_str) - $len_suffix,
                              $len_suffix,
                              self::DE) === $suffix;
        }
        
        public static function find ($s, $sub, $start = 0, $end = PHP_INT_MAX,
                                     $raise_error = false) {
            // Return the lowest index in the string where substring sub is
            // found, such that sub is contained in the slice s[start:end].
            // Optional arguments start and end are interpreted as in slice
            // notation. Return -1 if sub is not found.
            $res = mb_strpos (mb_substr ($s, $start, $end, self::DE),
                              $sub,
                              $start,
                              self::DE);

            // found
            if ($res !== false) {
                return $res;
            }

            // not found
            if ($raise_error) {
                throw new Exception ('ValueError');
            } else {
                return -1;
            }
        }
        
        // public function format(*args, **kwargs);
        public static function format ($s, $args) {
            // Perform a string formatting operation. The string on which this
            // method is called can contain literal text or replacement fields
            // delimited by braces {}. Each replacement field contains either
            // the numeric index of a positional argument, or the name of a
            // keyword argument. Returns a copy of the string where each
            // replacement field is replaced with the string value of the
            // corresponding argument.
            // >>>
            // >>> "The sum of 1 + 2 is {0}".format(1+2)
            // 'The sum of 1 + 2 is 3'
            // See Format String Syntax for a description of the various
            // formatting options that can be specified in format strings.
            // This method of string formatting is the new standard in Python
            // 3.0, and should be preferred to the % formatting described in
            // String Formatting Operations in new code.
            // New in version 2.6.
            
            
            // args() are passed as array(args).
        }
        
        public static function fromCharCode ($code) { // JS
            // http://www.php.net/manual/en/function.chr.php#69082
            return new Str (mb_convert_encoding (pack ("N", $code),
                                                 self::DE,
                                                 'UCS-4BE'));
        }
        
        public static function index ($s, $sub, $start = 0, $end = PHP_INT_MAX) {
            // Like find(), but raise ValueError when the substring is not found.
            return self::find ($s, $sub, $start, $end, true);
        }
        
        public static function indexOf ($s, $substr, $offset = 0) {
            /**
             * Returns the index of the first occurance of $substr in the string.
             * In case $substr is not a substring of the string, returns false.
             * @param String $substr substring
             * @param int $offset
             * @return int|bool
             */
            return mb_strpos ($s, (string) $substr, (int) $offset, self::DE);
        }
        
        public static function isalnum ($s) {
            // Return true if all characters in the string are alphanumeric and
            // there is at least one character, false otherwise.
            return self::length ($s) > 0 && self::_match ($s, '/^[A-Z0-9]+$/uims');
        }
        
        public static function isalpha ($s) {
            // Return true if all characters in the string are alphabetic and
            // there is at least one character, false otherwise.
            return self::length ($s) > 0 && self::_match ($s, '/^[A-Z]+$/uims');
        }
        
        public static function isdigit ($s) {
            // Return true if all characters in the string are digits and there
            // is at least one character, false otherwise.
            return self::length ($s) > 0 && self::_match ($s, '/^[0-9]+$/ums');
        }

        public static function islower ($s) {
            // Return true if all cased characters [4] in the string are
            // lowercase and there is at least one cased character, false
            // otherwise.
            return self::length ($s) > 0 && ((string) self::lower ($s)) === $s;
        }

        public static function isspace ($s) {
            // Return true if there are only whitespace characters in the
            // string and there is at least one character, false otherwise.
            return self::length ($s) > 0 && self::_match ($s, '/^\s+$/ums');
        }

        public static function istitle ($s) {
            // Return true if the string is a titlecased string and there is at
            // least one character, for example uppercase characters may only
            // follow uncased characters and lowercase characters only cased
            // ones. Return false otherwise.
            return self::length ($s) > 0 && ucwords ($s) === $s;
        }

        public static function isupper ($s) {
            // Return true if all cased characters [4] in the string are
            // uppercase and there is at least one cased character, false
            // otherwise.
            return self::length ($s) > 0 && ((string) self::upper ($s)) === $s;
        }

        public static function join ($s, $iterable) {
            // Return a string which is the concatenation of the strings in the
            // iterable iterable. The separator between elements is the string
            // providing this method.
            return new Str (implode ($s, $iterable));
        }

        public static function json ($s) {
            // what do you plan to use this for?
            return new Str (json_encode ($s));
        }

        public static function lastIndexOf ($s, $substr, $offset = 0) {
            /**
             * Returns the index of the last occurance of $substr in the string.
             * In case $substr is not a substring of the string, returns false.
             * @param String $substr substring
             * @param int $offset
             * @return int|bool
             */
            return mb_strrpos ($s, (string) $substr, (int) $offset, self::DE);
        }
        
        public static function length ($s) {
            // Return a string which is the concatenation of the strings in the
            // iterable iterable. The separator between elements is the string
            // providing this method.
            return mb_strlen ($s, self::DE);
        }

        public static function ljust ($s, $width, $fillchar = ' ') {
            // Return the string left justified in a string of length width.
            // Padding is done using the specified fillchar (default is a
            // space). The original string is returned if width is less than
            // or equal to len(s).
            // http://php.chinaunix.net/manual/tw/ref.mbstring.php#90611
            return new Str (self::_mb_str_pad ($s,
                                               $width,
                                               $fillchar,
                                               STR_PAD_RIGHT));
        }

        public static function lower ($s) {
            // Return a copy of the string with all the cased characters [4]
            // converted to lowercase.
            return new Str (mb_strtolower ($s, self::DE));
        }
        
        public static function lstrip ($s, $chars = ' ') {
            // Return a copy of the string with leading characters removed. The
            // chars argument is a string specifying the set of characters to
            // be removed. If omitted or None, the chars argument defaults to
            // removing whitespace. The chars argument is not a prefix; rather,
            // all combinations of its values are stripped:
            // >>>
            // >>> '   spacious   '.lstrip()
            // 'spacious   '
            // >>> 'www.example.com'.lstrip('cmowz.')
            // 'example.com'
            return preg_replace ('/^' . preg_quote ($chars, '/') . '/us', '', $s);
        }

        public static function partition ($s, $sep) {
            // Split the string at the first occurrence of sep, and return a
            // 3-tuple containing the part before the separator, the separator
            // itself, and the part after the separator. If the separator is
            // not found, return a 3-tuple containing the string itself,
            // followed by two empty strings.

            $sep_pos = mb_strpos ($s, $sep, 0, self::DE);
            return array (mb_substr ($s, 0, self::length ($sep_pos), self::DE),
                          $sep,
                          mb_substr ($s, $sep_pos + 1, PHP_INT_MAX, self::DE));
        }

        public static function replace ($s, $old, $new, $count = PHP_INT_MAX) {
            // Return a copy of the string with all occurrences of substring
            // old replaced by new. If the optional argument count is given,
            // only the first count occurrences are replaced.
            return new Str (self::_mb_str_replace ($old, $new, $s, $count, self::DE));
        }

        public static function rfind ($s, $sub, $start = null, $end = 0,
                                      $raise_error = false) {
            // Return the highest index in the string where substring sub is
            // found, such that sub is contained within s[start:end]. Optional
            // arguments start and end are interpreted as in slice notation.
            // Return -1 on failure.
            if ($start === null) {
                $start = self::length ($s);
            }
            $res = mb_strrpos (self::substring ($s, $start, $end),
                               $sub,
                               $start,
                               self::DE);

            if ($res !== false) {
                return $res;
            }

            // not found
            if ($raise_error) {
                throw new Exception ("ValueError");
            } else {
                return -1;
            }
        }

        public static function rindex ($s, $sub, $start = 0,
                                       $end = PHP_INT_MAX) {
            // Like rfind() but raises ValueError when the substring sub is not found.
            return self::rfind ($s, $sub, $start, $end, true);
        }

        public static function rjust ($s, $width, $fillchar = ' ') {
            // Return the string right justified in a string of length width. 
            // Padding is done using the specified fillchar (default is a 
            // space). The original string is returned if width is less than or
            // equal to len(s).
            // http://php.chinaunix.net/manual/tw/ref.mbstring.php#90611
            return new Str (self::_mb_str_pad ($s,
                                               $width, 
                                               $fillchar, 
                                               STR_PAD_LEFT));
        }

        public static function rpartition ($s, $sep) {
            // Split the string at the last occurrence of sep, and return a 
            // 3-tuple containing the part before the separator, the separator 
            // itself, and the part after the separator. If the separator is 
            // not found, return a 3-tuple containing two empty strings, 
            // followed by the string itself.
            /*
            $sep_pos = mb_strrpos ($s, $sep, 0, self::DE);
            return array (mb_substr ($s, 0, mb_strlen ($sep_pos), self::DE),
                          $sep,
                          mb_substr ($s, $sep_pos + 1, PHP_INT_MAX, self::DE));
            */
        }

        public static function rsplit ($s, $sep = ' ', $maxsplit = PHP_INT_MAX) {
            // Return a list of the words in the string, using sep as the 
            // delimiter string. If maxsplit is given, at most maxsplit splits 
            // are done, the rightmost ones. If sep is not specified or None, 
            // any whitespace string is a separator. Except for splitting from 
            // the right, rsplit() behaves like split() which is described in 
            // detail below.
            
            // not implemented
        }

        public static function rstrip ($s, $chars = ' ') {
            // Return a copy of the string with trailing characters removed. 
            // The chars argument is a string specifying the set of characters
            // to be removed. If omitted or None, the chars argument defaults 
            // to removing whitespace. The chars argument is not a suffix; 
            // rather, all combinations of its values are stripped:
            // >>>
            // >>> '   spacious   '.rstrip()
            // '   spacious'
            // >>> 'mississippi'.rstrip('ipz')
            // 'mississ'
            return preg_replace ('/' . preg_quote ($chars, '/') . '$/us', '', $s);
        }
        
        /**
         * Removes a part of the string and replace it with something else.
         * Example:
         * <code>
         * $string = new String('The fox jumped over the lazy dog.');
         * echo $string->splice(4, 0, 'quick brown ');
         * </code>
         * prints 'The quick brown fox jumped over the lazy dog.'
         * @return String
         */
        public function splice ($s, $offset, $length = null, $replacement = '') {
            $count = self::length ($s);
            
            // Offset handling (negative values measure from end of string)
            if ($offset < 0) {
                $offset += $count;
            }
            
            // Length handling (positive values measure from $offset; negative, from end of string; omitted = end of string)
            if ($length === null) {
                $length = $count;
            } else if ($length < 0) {
                $length += $count - $offset;
            }

            return new Str (self::substring ($s, 0, $offset) .
                            (string) $replacement .
                            self::substring ($s, $offset + $length));
        }
        
        public static function split ($s, $sep = '\s', $maxsplit = PHP_INT_MAX) {
            // Return a list of the words in the string, using sep as the 
            // delimiter string. If maxsplit is given, at most maxsplit splits 
            // are done (thus, the list will have at most maxsplit+1 elements).
            // If maxsplit is not specified, then there is no limit on the 
            // number of splits (all possible splits are made).
            // If sep is given, consecutive delimiters are not grouped together
            // and are deemed to delimit empty strings (for example, '1,,2'
            // .split(',') returns ['1', '', '2']). The sep argument may 
            // consist of multiple characters (for example, '1<>2<>3'
            // .split('<>') returns ['1', '2', '3']). Splitting an empty string
            // with a specified separator returns [''].
            // If sep is not specified or is None, a different splitting 
            // algorithm is applied: runs of consecutive whitespace are 
            // regarded as a single separator, and the result will contain no 
            // empty strings at the start or end if the string has leading or 
            // trailing whitespace. Consequently, splitting an empty string or 
            // a string consisting of just whitespace with a None separator 
            // returns [].
            // For example, ' 1  2   3  '.split() returns ['1', '2', '3'], and 
            // '  1  2   3  '.split(None, 1) returns ['1', '2   3  '].
            
            // fuck you, fuck everyone 
            // http://ca2.php.net/manual/en/function.mb-split.php#108189
            mb_regex_encoding (self::DE);
            mb_internal_encoding (self::DE);

            // no separators, because php says no
            // http://ca2.php.net/manual/en/function.mb-split.php#103470
            return mb_split ($sep, $s, $maxsplit);
        }

        public static function splitlines ($s, $keepends = false) {
            // Return a list of the lines in the string, breaking at line 
            // boundaries. Line breaks are not included in the resulting list 
            // unless keepends is given and true.

            // fuck you, fuck everyone 
            // http://ca2.php.net/manual/en/function.mb-split.php#108189
            mb_regex_encoding (self::DE);
            mb_internal_encoding (self::DE);

            // no separators, because php says no
            // http://ca2.php.net/manual/en/function.mb-split.php#103470
            return mb_split ('\n', $s);
        }

        public static function startswith ($s, $prefix, $start = 0, 
                                           $end = PHP_INT_MAX) {
            // Return True if string starts with the prefix, otherwise return 
            // False. prefix can also be a tuple of prefixes to look for. With 
            // optional start, test string beginning at that position. With 
            // optional end, stop comparing string at that position.
            $tmp_str = mb_substr ($s, $start, $end, self::DE);
            return mb_substr ($tmp_str, 0, self::length ($prefix), self::DE) 
                   === $prefix;
        }

        public static function strip ($s, $chars = ' ') {
            // Return a copy of the string with the leading and trailing characters removed. The chars argument is a string specifying the set of characters to be removed. If omitted or None, the chars argument defaults to removing whitespace. The chars argument is not a prefix or suffix; rather, all combinations of its values are stripped:
            // >>>
            // >>> '   spacious   '.strip()
            // 'spacious'
            // >>> 'www.example.com'.strip('cmowz.')
            // 'example'
            return preg_replace ('/(^\s+)|(\s+$)/s', '', $s);
        }

        public function substring ($s, $start, $length = PHP_INT_MAX) {
            /**
             * Returns part of the string.
             * @param int $start
             * @param int $length
             * @return String
             */
            return new Str (mb_substr ($s, $start, $length, self::DE));
        }
        
        public function swapcase ($s) {
            // Return a copy of the string with uppercase characters converted to lowercase and vice versa.
            $string = '';
            $length = self::length ($s);
            for ($i = 0; $i < $length; $i++) {
                $char = $this->charAt ($i);
                if ($char->islower()) {
                    $string .= $char->upper ();
                } else {
                    $string .= $char->lower ();
                }
            }
            return new Str ($string);
        }

        public static function title ($s) {
            // Return a titlecased version of the string where words start with an uppercase character and the remaining characters are lowercase.
            // The algorithm uses a simple language-independent definition of a word as groups of consecutive letters. The definition works in many contexts but it means that apostrophes in contractions and possessives form word boundaries, which may not be the desired result:
            // >>>
            // >>> "they're bill's friends from the UK".title()
            // "They'Re Bill'S Friends From The Uk"
            // A workaround for apostrophes can be constructed using regular expressions:
            // >>>
            // >>> import re
            // >>> def titlecase(s):
                    // return re.sub(r"[A-Za-z]+('[A-Za-z]+)?",
                                  // lambda mo: mo.group(0)[0].upper() +
                                             // mo.group(0)[1:].lower(),
                                  // s)
            // >>> titlecase("they're bill's friends.")
            // "They're Bill's Friends."
            return new Str (ucwords ($s));
        }

        public function toLowerCase () { // JS
            return $this->lower();
        }

        public function toUpperCase () { // JS
            return $this->upper();
        }

        public function translate ($table, $deletechars = null) {
            // Return a copy of the string where all characters occurring in the optional argument deletechars are removed, and the remaining characters have been mapped through the given translation table, which must be a string of length 256.
            // You can use the maketrans() helper function in the string module to create a translation table. For string objects, set the table argument to None for translations that only delete characters:
            // >>>
            // >>> 'read this short text'.translate(None, 'aeiou')
            // 'rd ths shrt txt'
            // New in version 2.6: Support for a None table argument.
            // For Unicode objects, the translate() method does not accept the optional deletechars argument. Instead, it returns a copy of the s where all characters have been mapped through the given translation table which must be a mapping of Unicode ordinals to Unicode ordinals, Unicode strings or None. Unmapped characters are left untouched. Characters mapped to None are deleted. Note, a more flexible approach is to create a custom character mapping codec using the codecs module (see encodings.cp1251 for an example).

        }

        public function upper ($s) {
            // Return a copy of the string with all the cased characters [4] 
            // converted to uppercase. Note that str.upper().isupper() might be
            // False if s contains uncased characters or if the Unicode 
            // category of the resulting character(s) is not “Lu” (Letter, 
            // uppercase), but e.g. “Lt” (Letter, titlecase).
            // For 8-bit strings, this method is locale-dependent.
            return new Str (mb_strtoupper ($s));
        }

        public function zfill ($width) {
            // Return the numeric string left filled with zeros in a string of length width. A sign prefix is handled correctly. The original string is returned if width is less than or equal to len(s).

        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        



        // private functions ==================================================
        private static function _mb_str_pad ($s, $width, $fillchar, $pad_type) {
            // http://php.chinaunix.net/manual/tw/ref.mbstring.php#90611
            return str_pad ($s, // input
                            strlen ($s) - self::length ($s) + $width, // length
                            $fillchar, // pad_string
                            $pad_type); // pad_type
        }

        private static function _mb_str_replace ($search, $replace, $subject, 
                                                 $count, $encoding) {
            // why doesn't this function exist?
            if(is_array($subject)) {
                $ret = array();
                foreach($subject as $key => $val) {
                    $ret[$key] = $this->_mb_str_replace ($search,
                                                         $replace,
                                                         $val,
                                                         $count,
                                                         $encoding);
                }
                return $ret;
            }
            foreach((array) $search as $key => $o) {
                if($o == '') {
                    continue;
                }
                $r = !is_array($replace) ?
                        $replace :
                        (array_key_exists ($key, $replace) ?
                            $replace[$key] :
                            '');
                $pos = mb_strpos ($subject, $o, 0, self::DE);
                while ($pos !== false && $count > 0) {
                    $subject = mb_substr ($subject,
                                          0,
                                          $pos,
                                          self::DE) .
                                    $r .
                                    mb_substr ($subject,
                                               $pos + self::length ($o),
                                               PHP_INT_MAX,
                                               self::DE);
                    $pos = mb_strpos ($subject,
                                      $o,
                                      $pos + self::length ($r),
                                      self::DE);
                    $count --;
                }
            }
            return $subject;
        }

        private static function _mb_str_split ($str, $length = 1) {
            if ($length < 1) return false;
            $result = array();
            for ($i = 0; $i < self::length ($str); $i += $length) {
                $result[] = mb_substr($str, $i, $length);
            }
            return $result;
        }

        private static function _match ($subject, $pattern) {
            return preg_match ($pattern, $subject) === 1;
        }

        private static function _mb_alpha ($subject = null) {
            $chars = 'abcdefghijklmnopqrstuvwxyz';
        }
    }
    
    
    class Str implements IteratorAggregate, ArrayAccess {
        protected $s;
        const DE = 'UTF-8';

        public function __construct ($s) {
            // force convert all incoming strings to UTF-8.
            
            $this->s = mb_convert_encoding (
                $s,
                self::DE,
                mb_detect_encoding ($s, self::DE)
            );
        }

        public function __toString () {
            return $this->s;
        }
        
        public function doc () {
            return get_class_methods (get_class ());
        }

        // required implementations ===========================================
        
        public function getIterator () {
            // http://ca2.php.net/manual/en/class.iteratoraggregate.php
            // ?!
            return new ArrayIterator ($this);
        }

        // ArrayAccess Methods
        public function offsetExists ($index) {
            // offsetExists ( mixed $index )
            // Similar to array_key_exists

            // ?!
            return isset ($this->s[$index]);
        }

        public function offsetGet ($index) {
            // offsetGet ( mixed $index )
            // Retrieves an array value

            // ?!
            return $this->s[$index];
        }

        public function offsetSet ($index, $val) {
            // offsetSet ( mixed $index, mixed $val )
            // Sets an array value

            // ?!
            $this->s[$index] = $val;
        }

        public function offsetUnset ($index) {
            // offsetUnset ( mixed $index )
            // Removes an array value

            // ?!
            $this->s[$index] = null;
        }

        // public functions (relays to static processor class) ================
        public function capitalize () {
            return BaseString::capitalize ($this->s); 
        } public function center ($width, $fillchar = ' ') {
            return new Str (BaseString::center ($this->s, $width, $fillchar));
        } public function charAt ($point) {
            return BaseString::charAt ($this->s, $point);
        } public function charCodeAt ($point) {
            return BaseString::charCodeAt ($this->s, $point);
        } public function concat () {
            return BaseString::concat ($this->s, func_get_args ());
        } public function count ($sub, $start = 0, $end = PHP_INT_MAX) {
            return BaseString::count ($this->s, $sub, $start, $end);
        } public function endswith ($suffix, $start = 0, $end = PHP_INT_MAX) {
            return BaseString::endswith ($this->s, $suffix, $start, $end);
        } public function find ($sub, $start = 0, $end = PHP_INT_MAX, $raise_error = false) {
            return BaseString::find ($this->s, $sub, $start, $end, $raise_error);
        } public function format () {
            return BaseString::format ($this->s, func_get_args ());
        } public function fromCharCode ($code) {
            return BaseString::fromCharCode ($code);
        } public function index ($sub, $start = 0, $end = PHP_INT_MAX) {
            return BaseString::index ($this->s, $sub, $start, $end);
        } public function indexOf ($substr, $offset = 0) {
            return BaseString::indexOf ($this->s, $substr, $offset);
        } public function json () {
            return BaseString::json ($this->s);
        } public function isalnum () {
            return BaseString::isalnum ($this->s);
        } public function isalpha () {
            return BaseString::isalpha ($this->s);
        } public function isdigit () {
            return BaseString::isdigit ($this->s);
        } public function islower () {
            return BaseString::islower ($this->s);
        } public function isspace () {
            return BaseString::isspace ($this->s);
        } public function istitle () {
            return BaseString::istitle ($this->s);
        } public function isupper () {
            return BaseString::isupper ($this->s);
        } public function join ($iterable) {
            return BaseString::join ($this->s, $iterable);
        } public function lastIndexOf ($substr, $offset = 0) {
            return BaseString::lastIndexOf ($this->s, $substr, $offset);
        } public function length () {
            return BaseString::length ($this->s);
        } public function ljust ($width, $fillchar = ' ') {
            return BaseString::ljust ($this->s, $width, $fillchar);
        } public function lower () {
            return BaseString::lower ($this->s);
        } public function lstrip ($chars = ' ') {
            return BaseString::lstrip ($this->s, $chars);
        } public function partition ($sep) {
            return BaseString::partition ($this->s, $sep);
        } public function replace ($old, $new, $count = PHP_INT_MAX) {
            return BaseString::replace ($this->s, $old, $new, $count);
        } public function rfind ($sub, $start = null, $end = 0, $raise_error = false) {
            return BaseString::rfind ($this->s, $sub, $start, $end, $raise_error);
        } public function rindex ($sub, $start = 0, $end = PHP_INT_MAX) {
            return BaseString::rindex ($this->s, $sub, $start, $end, true);
        } public function rjust ($width, $fillchar = ' ') {
            return BaseString::rjust ($this->s, $width, $fillchar);
        } public function rpartition ($sep) {
            return BaseString::rpartition ($this->s, $sep);
        } public function rsplit ($sep = ' ', $maxsplit = PHP_INT_MAX) {
            return BaseString::rsplit ($this->s, $sep, $maxsplit);
        } public function rstrip ($chars = ' ') {
            return BaseString::rstrip ($this->s, $chars);
        } public function splice ($offset, $length = null, $replacement = '') {
            return BaseString::splice ($this->s, $offset, $length, $replacement);
        } public function split ($sep = '\s', $maxsplit = PHP_INT_MAX) {
            return BaseString::split ($this->s, $sep, $maxsplit);
        } public function splitlines ($keepends = false) {
            return BaseString::splitlines ($this->s, $keepends);
        } public function startswith ($prefix, $start = 0, $end = PHP_INT_MAX) {
            return BaseString::startswith ($this->s, $prefix, $start, $end);
        } public function strip ($chars = ' ') {
            return BaseString::strip ($this->s, $chars);
        } public function swapcase () {
            return BaseString::swapcase ($this->s);
        } public function title () {
            return BaseString::title ($this->s);
        } public function toLowerCase () {
            return BaseString::toLowerCase ($this->s);
        } public function toUpperCase () {
            return BaseString::toUpperCase ($this->s);
        } public function translate ($table, $deletechars = null) {
            return BaseString::translate ($this->s, $table, $deletechars);
        } public function upper () {
            return BaseString::upper ($this->s);
        } public function zfill ($width) {
            return BaseString::zfill ($this->s, $width);
        }
    }
