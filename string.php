<?php
    class Str implements IteratorAggregate, ArrayAccess {
        /*  An improved string type, a bit like the python string.
            Note that, as close as the syntax will be, there will always be
            differences: the exceptions you expect, keyword arguments
            limitation, use of tuples and, possibly, PHP reserved keywords.

            Some differences are blindingly obvious:
            - all method names follow the PHP function naming convention
              (lower_case_underscores, not camelCase).
            - the Str class is unicode, because it is 2012.
              (you can get a ASCII string by encode()ing it, I guess.)
            - returns are all Str objects with string representation.

            Also, I don't implement functions I don't like, or functions
            I don't know how.
            - e.g. who uses expandtabs? go write your own expandtabs.
        */
        protected $contents;
        const DEFAULT_ENCODING = 'UTF-8';

        public function __construct ($contents) {
            // force convert all incoming strings to UTF-8.
            // http://ca2.php.net/manual/en/function.mb-convert-encoding.php
            // http://ca2.php.net/manual/en/function.mb-detect-encoding.php
            $this->contents = mb_convert_encoding (
                $contents,
                self::DEFAULT_ENCODING,
                mb_detect_encoding ($contents, "UTF-8")
            );
        }

        public function __toString () {
            return $this->contents;
        }

        // required implementations ===========================================
        public function getIterator() {
            // http://ca2.php.net/manual/en/class.iteratoraggregate.php
            // ?!
            return new ArrayIterator ($this);
        }

        // ArrayAccess Methods
        public function offsetExists ($index) {
            // offsetExists ( mixed $index )
            // Similar to array_key_exists

            // ?!
            return isset ($this->contents[$index]);
        }

        public function offsetGet ($index) {
            // offsetGet ( mixed $index )
            // Retrieves an array value

            // ?!
            return $this->contents[$index];
        }

        public function offsetSet ($index, $val) {
            // offsetSet ( mixed $index, mixed $val )
            // Sets an array value

            // ?!
            $this->contents[$index] = $val;
        }

        public function offsetUnset ($index) {
            // offsetUnset ( mixed $index )
            // Removes an array value

            // ?!
            $this->contents[$index] = null;
        }

        // public functions ===================================================
        public function capitalize () {
            // Return a copy of the string with its first character capitalized
            // and the rest lowercased.
            return new Str (
                mb_strtoupper ($this->contents)
            );
        }

        public function center ($width, $fillchar = ' ') {
            // Return centered in a string of length width. Padding is done 
            // using the specified fillchar (default is a space).
            return new Str (
                $this->_mb_str_pad ($width, $fillchar, STR_PAD_BOTH)
            );
        }

        public function count ($sub, $start = 0, $end = PHP_INT_MAX) {
            // Return the number of non-overlapping occurrences of substring 
            // sub in the range [start, end]. Optional arguments start and end 
            // are interpreted as in slice notation.
            return new Str (
                mb_substr_count (
                    $this->contents, // haystack
                    $sub, // needle
                    self::DEFAULT_ENCODING
                )
            );
        }

        public function decode ($encoding = self::DEFAULT_ENCODING,
                                $errors = 'ignore') {
            // Decodes the string using the codec registered for encoding. 
            // encoding defaults to the default string encoding. errors may be 
            // given to set a different error handling scheme. The default is 
            // 'strict', meaning that encoding errors raise UnicodeError. Other
            // possible values are 'ignore', 'replace' and any other name 
            // registered via codecs.register_error(), see section Codec Base 
            // Classes.

            // not implemented (makes no sense)
        }

        public function encode ($encoding = self::DEFAULT_ENCODING, 
                                $errors = 'ignore') {
            // Return an encoded version of the string. Default encoding is the
            // current default string encoding. errors may be given to set a 
            // different error handling scheme. The default for errors is 
            // 'strict', meaning that encoding errors raise a UnicodeError. 
            // Other possible values are 'ignore', 'replace', 
            // 'xmlcharrefreplace', 'backslashreplace' and any other name 
            // registered via codecs.register_error(), see section Codec Base 
            // Classes. For a list of possible encodings, see section Standard 
            // Encodings.

            // not implemented (makes no sense)
        }

        public function endswith ($suffix, $start = 0, $end = PHP_INT_MAX) {
            // Return True if the string ends with the specified suffix, 
            // otherwise return False. suffix can also be a tuple of suffixes 
            // to look for. With optional start, test beginning at that 
            // position. With optional end, stop comparing at that position.

            // http://www.php.net/manual/en/function.mb-substr.php
            $tmp_str = mb_substr ($this->contents, $start, $end, 
                                  self::DEFAULT_ENCODING);
            return (
                mb_substr (
                    $tmp_str, // haystack
                    -(mb_strlen ($tmp_str, self::DEFAULT_ENCODING)), // needle
                    PHP_INT_MAX,
                    self::DEFAULT_ENCODING
                ) === $suffix
            );
        }

        public function find ($sub, $start = 0, $end = PHP_INT_MAX,
                              $raise_error = false) {
            // Return the lowest index in the string where substring sub is 
            // found, such that sub is contained in the slice s[start:end]. 
            // Optional arguments start and end are interpreted as in slice 
            // notation. Return -1 if sub is not found.
            $res = mb_strpos (
                $this->contents,
                $sub,
                $start,
                self::DEFAULT_ENCODING
            );
            
            if ($res === false) {
                if ($raise_error) {
                    throw new Exception ("ValueError");
                } else {
                    return -1;
                }
            } else {
                return $res;
            }
        }

        // public function format(*args, **kwargs);
        public function format () {
            // Perform a string formatting operation. The string on which this method is called can contain literal text or replacement fields delimited by braces {}. Each replacement field contains either the numeric index of a positional argument, or the name of a keyword argument. Returns a copy of the string where each replacement field is replaced with the string value of the corresponding argument.
            // >>>
            // >>> "The sum of 1 + 2 is {0}".format(1+2)
            // 'The sum of 1 + 2 is 3'
            // See Format String Syntax for a description of the various formatting options that can be specified in format strings.
            // This method of string formatting is the new standard in Python 3.0, and should be preferred to the % formatting described in String Formatting Operations in new code.
            // New in version 2.6.

        }

        public function index ($sub, $start = 0, $end = PHP_INT_MAX) {
            // Like find(), but raise ValueError when the substring is not found.
            
            return $this->find ($sub, $start, $end, true);
        }

        public function isalnum () {
            // Return true if all characters in the string are alphanumeric and there is at least one character, false otherwise.
            return (
                mb_strlen ($this->contents) >= 1 && 
                _match ("/^([A-Z0-9])*$/is")
            );
        }

        public function isalpha () {
            // Return true if all characters in the string are alphabetic and there is at least one character, false otherwise.
            return (
                mb_strlen ($this->contents) >= 1 && 
                _match ("/^([A-Z])*$/is")
            );
        }

        public function isdigit () {
            // Return true if all characters in the string are digits and there is at least one character, false otherwise.
            return (
                mb_strlen ($this->contents) >= 1 && 
                _match ("/^([0-9])*$/is")
            );
        }

        public function islower () {
            // Return true if all cased characters [4] in the string are lowercase and there is at least one cased character, false otherwise.
            return mb_strtolower ($this->contents) === $this->contents;
        }

        public function isspace () {
            // Return true if there are only whitespace characters in the string and there is at least one character, false otherwise.
            return (
                mb_strlen ($this->contents) >= 1 && 
                _match ("/^\s*$/s")
            );

        }

        public function istitle () {
            // Return true if the string is a titlecased string and there is at least one character, for example uppercase characters may only follow uncased characters and lowercase characters only cased ones. Return false otherwise.

        }

        public function isupper () {
            // Return true if all cased characters [4] in the string are uppercase and there is at least one cased character, false otherwise.
            return mb_strtoupper ($this->contents) === $this->contents;
        }

        public function join ($iterable) {
            // Return a string which is the concatenation of the strings in the iterable iterable. The separator between elements is the string providing this method.
            return new Str (
                implode ($this->contents, $iterable)
            );
        }

        public function ljust ($width, $fillchar = ' ') {
            // Return the string left justified in a string of length width. Padding is done using the specified fillchar (default is a space). The original string is returned if width is less than or equal to len(s).
            // http://php.chinaunix.net/manual/tw/ref.mbstring.php#90611
            return new Str (
                $this->_mb_str_pad ($width, $fillchar, STR_PAD_LEFT)
            );
        }

        public function lower () {
            // Return a copy of the string with all the cased characters [4] converted to lowercase.
            return new Str (
                mb_strtolower ($this->contents, self::DEFAULT_ENCODING)
            );            
        }

        public function lstrip ($chars = ' ') {
            // Return a copy of the string with leading characters removed. The chars argument is a string specifying the set of characters to be removed. If omitted or None, the chars argument defaults to removing whitespace. The chars argument is not a prefix; rather, all combinations of its values are stripped:
            // >>>
            // >>> '   spacious   '.lstrip()
            // 'spacious   '
            // >>> 'www.example.com'.lstrip('cmowz.')
            // 'example.com'
            return preg_replace ('/(^\s+)/s', '', $this->contents);
        }

        public function partition ($sep) {
            // Split the string at the first occurrence of sep, and return a 3-tuple containing the part before the separator, the separator itself, and the part after the separator. If the separator is not found, return a 3-tuple containing the string itself, followed by two empty strings.

            $sep_pos = mb_strpos ($this->contents, $sep, 0, self::DEFAULT_ENCODING);
            return array (
                mb_substr ($this->contents, 0, mb_strlen($sep_pos), self::DEFAULT_ENCODING),
                $sep,
                mb_substr ($this->contents, $sep_pos + 1,PHP_INT_MAX, self::DEFAULT_ENCODING)
            );
        }

        public function replace ($old, $new, $count = PHP_INT_MAX) {
            // Return a copy of the string with all occurrences of substring old replaced by new. If the optional argument count is given, only the first count occurrences are replaced.
            // $search, $replace, $subject, $encoding
            return new Str (
                $this->_mb_str_replace ($old, $new, $this->contents, self::DEFAULT_ENCODING)
            );
        }

        public function rfind ($sub, $start = 0, $end = PHP_INT_MAX) {
            // Return the highest index in the string where substring sub is found, such that sub is contained within s[start:end]. Optional arguments start and end are interpreted as in slice notation. Return -1 on failure.

        }

        public function rindex ($sub, $start = 0, $end = PHP_INT_MAX) {
            // Like rfind() but raises ValueError when the substring sub is not found.

        }

        public function rjust ($width, $fillchar = ' ') {
            // Return the string right justified in a string of length width. Padding is done using the specified fillchar (default is a space). The original string is returned if width is less than or equal to len(s).
            // http://php.chinaunix.net/manual/tw/ref.mbstring.php#90611
            return new Str (
                $this->_mb_str_pad ($width, $fillchar, STR_PAD_RIGHT)
            );
        }

        public function rpartition ($sep) {
            // Split the string at the last occurrence of sep, and return a 3-tuple containing the part before the separator, the separator itself, and the part after the separator. If the separator is not found, return a 3-tuple containing two empty strings, followed by the string itself.

        }

        public function rsplit ($sep = ' ', $maxsplit = PHP_INT_MAX) {
            // Return a list of the words in the string, using sep as the delimiter string. If maxsplit is given, at most maxsplit splits are done, the rightmost ones. If sep is not specified or None, any whitespace string is a separator. Except for splitting from the right, rsplit() behaves like split() which is described in detail below.

        }

        public function rstrip ($chars = ' ') {
            // Return a copy of the string with trailing characters removed. The chars argument is a string specifying the set of characters to be removed. If omitted or None, the chars argument defaults to removing whitespace. The chars argument is not a suffix; rather, all combinations of its values are stripped:
            // >>>
            // >>> '   spacious   '.rstrip()
            // '   spacious'
            // >>> 'mississippi'.rstrip('ipz')
            // 'mississ'

            return preg_replace ('/(\s+$)/s', '', $this->contents);
        }

        public function split ($sep = ' ', $maxsplit = PHP_INT_MAX) {
            // Return a list of the words in the string, using sep as the delimiter string. If maxsplit is given, at most maxsplit splits are done (thus, the list will have at most maxsplit+1 elements). If maxsplit is not specified, then there is no limit on the number of splits (all possible splits are made).
            // If sep is given, consecutive delimiters are not grouped together and are deemed to delimit empty strings (for example, '1,,2'.split(',') returns ['1', '', '2']). The sep argument may consist of multiple characters (for example, '1<>2<>3'.split('<>') returns ['1', '2', '3']). Splitting an empty string with a specified separator returns [''].
            // If sep is not specified or is None, a different splitting algorithm is applied: runs of consecutive whitespace are regarded as a single separator, and the result will contain no empty strings at the start or end if the string has leading or trailing whitespace. Consequently, splitting an empty string or a string consisting of just whitespace with a None separator returns [].
            // For example, ' 1  2   3  '.split() returns ['1', '2', '3'], and '  1  2   3  '.split(None, 1) returns ['1', '2   3  '].

        }

        public function splitlines ($keepends = false) {
            // Return a list of the lines in the string, breaking at line boundaries. Line breaks are not included in the resulting list unless keepends is given and true.
            return mb_split ("/\n/s", $this->contents);
        }

        public function startswith ($prefix, $start = 0, $end = PHP_INT_MAX) {
            // Return True if string starts with the prefix, otherwise return False. prefix can also be a tuple of prefixes to look for. With optional start, test string beginning at that position. With optional end, stop comparing string at that position.
            $tmp_str = mb_substr ($this->contents, $start, $end, self::DEFAULT_ENCODING);
            return (
                mb_substr (
                    $tmp_str,
                    0,
                    mb_strlen ($tmp_str, self::DEFAULT_ENCODING),
                    self::DEFAULT_ENCODING
                ) === $suffix
            );
        }

        public function strip ($chars = ' ') {
            // Return a copy of the string with the leading and trailing characters removed. The chars argument is a string specifying the set of characters to be removed. If omitted or None, the chars argument defaults to removing whitespace. The chars argument is not a prefix or suffix; rather, all combinations of its values are stripped:
            // >>>
            // >>> '   spacious   '.strip()
            // 'spacious'
            // >>> 'www.example.com'.strip('cmowz.')
            // 'example'
            return preg_replace ('/(^\s+)|(\s+$)/s', '', $this->contents);            
        }

        public function swapcase () {
            // Return a copy of the string with uppercase characters converted to lowercase and vice versa.

        }

        public function title () {
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

        public function upper () {
            // Return a copy of the string with all the cased characters [4] converted to uppercase. Note that str.upper().isupper() might be False if s contains uncased characters or if the Unicode category of the resulting character(s) is not “Lu” (Letter, uppercase), but e.g. “Lt” (Letter, titlecase).
            // For 8-bit strings, this method is locale-dependent.
            return new Str (
                mb_strtoupper ($this->contents)
            );
        }

        public function zfill ($width) {
            // Return the numeric string left filled with zeros in a string of length width. A sign prefix is handled correctly. The original string is returned if width is less than or equal to len(s).

        }

        // private functions ==================================================
        private function _mb_str_pad ($width, $fillchar, $pad_type) {
            // http://php.chinaunix.net/manual/tw/ref.mbstring.php#90611
            return str_pad (
                $this->contents, // input
                strlen ($this->contents)
                    - mb_strlen ($this->contents, self::DEFAULT_ENCODING)
                    + $width, // length
                $fillchar, // pad_string
                $pad_type // pad_type
            );
        }

        private function _mb_str_replace ($search, $replace, $subject, $encoding) {
            // why doesn't this function exist?
            if(is_array($subject)) {
                $ret = array();
                foreach($subject as $key => $val) {
                    $ret[$key] = $this->_mb_str_replace($search, $replace, $val, $encoding);
                }
                return $ret;
            }
            foreach((array) $search as $key => $s) {
                if($s == '') {
                    continue;
                }
                $r = !is_array($replace) ? $replace : (array_key_exists($key, $replace) ? $replace[$key] : '');
                $pos = mb_strpos($subject, $s, 0, self::DEFAULT_ENCODING);
                while($pos !== false) {
                    $subject = mb_substr (
                        $subject, 
                        0, 
                        $pos, 
                        self::DEFAULT_ENCODING
                    ) . 
                    $r . 
                    mb_substr (
                        $subject, 
                        $pos + mb_strlen (
                            $s, 
                            self::DEFAULT_ENCODING
                        ), 
                        PHP_INT_MAX, 
                        self::DEFAULT_ENCODING
                    );
                    $pos = mb_strpos (
                        $subject, 
                        $s, 
                        $pos + mb_strlen(
                            $r, 
                            self::DEFAULT_ENCODING
                        ), 
                        self::DEFAULT_ENCODING
                    );
                }
            }
            return $subject;
        }

        private function _mb_str_split ($str, $length = 1) {
            if ($length < 1) return false;
            $result = array();
            for ($i = 0; $i < mb_strlen($str); $i += $length) {
                $result[] = mb_substr($str, $i, $length);
            }
            return $result;
        }
        
        private function _match ($pattern, $subject = null) {
            if ($subject === null) {
                $subject = $this->contents;
            }
            return preg_match ($pattern, $subject) === 1;
        }
    }
/*

    class StaticString {
        // static methods wrapping multibyte

        //
        // Wrapper for substr
        //
        public static function substr ($string, $start, $length = null) {
            if(String::$multibyte) {
                return new String(mb_substr($string, $start, $length, String::$multibyte_encoding));
            }
            else {
                return new String(substr($string, $start, $length));
            }
        }

        //
        // Equivelent of Javascript's String.substring
        // @link http://www.w3schools.com/jsref/jsref_substring.asp
        //
        public static function substring ($string, $start, $end) {
            if(empty($length)) {
                return self::substr($string, $start);
            }
            return self::substr($string, $end - $start);
        }

        public function charAt ($str, $point) {
            return self::substr($str, $point, 1);
        }

        public function charCodeAt ($str, $point) {
            return ord(self::substr($str, $point, 1));
        }

        public static function concat () {
            $args = func_get_args();
            $r = "";
            foreach($args as $arg) {
                $r .= (string)$arg;
            }
            return $arg;
        }

        public static function fromCharCode ($code) {
            return chr($code);
        }

        public static function indexOf ($haystack, $needle, $offset = 0) {
            if(String::$multibyte) {
                return mb_strpos($haystack, $needle, $offset, String::$multibyte_encoding);
            }
            else {
                return strpos($haystack, $needle, $offset);
            }
        }

        public static function lastIndexOf ($haystack, $needle, $offset = 0) {
            if(String::$multibyte) {
                return mb_strrpos($haystack, $needle, $offset, String::$multibyte_encoding);
            }
            else {
                return strrpos($haystack, $needle, $offset);
            }
        }

        public static function match ($haystack, $regex) {
            preg_match_all($regex, $haystack, $matches, PREG_PATTERN_ORDER);
            return new Arr($matches[0]);
        }

        public static function replace ($haystack, $needle, $replace, $regex = false) {
            if($regex) {
                $r = preg_replace($needle, $replace, $haystack);
            }
            else {
                if(String::$multibyte) {
                    $r = mb_str_replace($needle, $replace, $haystack);
                }
                else {
                    $r = str_replace($needle, $replace, $haystack);
                }
            }
            return new String($r);
        }

        public static function slice ($string, $start, $end = null) {
            return self::substring($string, $start, $end);
        }

        public static function toLowerCase ($string) {
            if(String::$multibyte) {
                return new String(mb_strtolower($string, String::$multibyte_encoding));
            }
            else {
                return new String(strtolower($string));
            }

        }

        public static function toUpperCase ($string) {
            if(String::$multibyte) {
                return new String(mb_strtoupper($string, String::$multibyte_encoding));
            }
            else {
                return new STring(strtoupper($string));
            }

        }

        public static function split ($string, $at = '') {
            if(empty($at)) {
                if(String::$multibyte) {
                    return new Arr(mb_str_split($string));
                }
                else {
                    return new Arr(str_split($string));
                }
            }
            return new Arr(explode($at, $string));
        }

        // end static wrapper methods
    }
    class String implements ArrayAccess {
        private $value;

        public static $multibyte = false;
        private static $checked = false;
        public static $multibyte_encoding = null;

        // magic methods
        public function __construct ($string) {
            if(!self::$checked) {
                self::$multibyte = extension_loaded('mbstring');
            }
            if(is_null(self::$multibyte_encoding)) {
                if(self::$multibyte) {
                    self::$multibyte_encoding = mb_internal_encoding();
                }
            }
            $this->value = (string)$string;
        }

        public function __toString () {
            return $this->value;
        }

        // end magic methods


        public static function create ($obj) {
            if($obj instanceof String) return new String($obj);
            return new String($obj);
        }

        // public methods
        public function substr ($start, $length) {
            return StaticString::substr($this->value, $start, $length);
        }

        public function substring ($start, $end) {
            return StaticString::substring($this->value, $start, $end);
        }

        public function charAt ($point) {
            return StaticString::substr($this->value, $point, 1);
        }

        public function charCodeAt ($point) {
            return ord(StaticString::substr($this->value, $point, 1));
        }

        public function indexOf ($needle, $offset) {
            return StaticString::indexOf($this->value, $needle, $offset);
        }

        public function lastIndexOf ($needle) {
            return StaticString::lastIndexOf($this->value, $needle);
        }

        public function match ($regex) {
            return StaticString::match($this->value, $regex);
        }

        public function replace ($search, $replace, $regex = false) {
            return StaticString::replace($this->value, $search, $replace, $regex);
        }

        public function first () {
            return StaticString::substr($this->value, 0, 1);
        }

        public function last () {
            return StaticString::substr($this->value, -1, 1);
        }

        public function search ($search, $offset = null) {
            return $this->indexOf($search, $offset);
        }

        public function slice ($start, $end = null) {
            return StaticString::slice($this->value, $start, $end);
        }

        public function toLowerCase () {
            return StaticString::toLowerCase($this->value);
        }

        public function toUpperCase () {
            return StaticString::toUpperCase($this->value);
        }

        public function toUpper () {
            return $this->toUpperCase();
        }

        public function toLower () {
            return $this->toLowerCase();
        }

        public function split ($at = '') {
            return StaticString::split($this->value, $at);
        }

        public function trim ($charlist = null) {
            return new String(trim($this->value, $charlist));
        }

        public function ltrim ($charlist = null) {
            return new String(ltrim($this->value, $charlist));
        }

        public function rtrim ($charlist = null) {
            return new String(rtrim($this->value, $charlist));
        }

        public function toString () {
            return $this->__toString();
        }
    }
    class Arr extends ArrayObject {
        private static $ret_obj = true;

        public function add () {
            $val = 0;
            foreach($this as $vals) {
                $val += $vals;
            }
            return $val;
        }

        public function get ($i) {
            $val = $this->offsetGet($i);
            if(is_array($val)) {
                return new self($val);
            }
            if(is_string($val) && self::$ret_obj) {
                return new String($val);
            }
            return $val;
        }

        public function each ($callback) {
            foreach($this as $key => $val) {
                call_user_func_array($callback, array(
                    $val, $key, $this
                ));
            }
            return $this;
        }

        public function set ($i, $v) {
            $this->offsetSet($i, $v);
            return $this;
        }

        public function push ($value) {
            $this[] = $value;
            return $this;
        }

        public function sort () {
            $this->asort();
            return $this;
        }

        public function toArray () {
            return $this->getArrayCopy();
        }

        public function natsort () {
            parent::natsort();
            return $this;
        }

        public function rsort () {
            parent::uasort('Arr::sort_alg');
            return $this;
        }

        public static function sort_alg ($a,$b) {
            if ($a == $b) {
                return 0;
            }
            return ($a < $b) ? 1 : -1;
        }
    }
*/