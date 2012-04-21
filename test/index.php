<?php
    // Example tests.
 
    require_once ('UnitTestClass.class.php');
    require_once ('UnitTestClass.view.php');
    require_once ('../string.php');

    class StringTest extends UnitTestClass {
        // detection of features (requires 'disable_classes' and 'disable_functions' to be off
        public $str;
        
        function setup () {
            $this->str = new Str ("twenTY-2歲男子");
        }
        
        function test_capitalize () {
            $this->assertEqual($this->str->capitalize(), "TwenTY-2歲男子");
        }

        function test_center () {
            // Return centered in a string of length width. Padding is done 
            // using the specified fillchar (default is a space).
            $this->assertEqual($this->str->center(0), "twenTY-2歲男子");
            $this->assertEqual($this->str->center(11), "twenTY-2歲男子");
            $this->assertEqual($this->str->center(13), " twenTY-2歲男子 ");
            $this->assertEqual($this->str->center(13, '-'), "-twenTY-2歲男子-");
        }

        function test_charAt () {
            $this->assertEqual($this->str->charAt(0), "t");
            $this->assertEqual($this->str->charAt(1), "w");
            $this->assertEqual($this->str->charAt(10), "子");
            $this->assertEqual($this->str->charAt(-1), "子");
        }

        function test_charCodeAt () {
            // JS
            $this->assertEqual($this->str->charCodeAt(0), ord('t'));
            $this->assertEqual($this->str->charCodeAt(1), ord('w'));
            $this->assertEqual($this->str->charCodeAt(-1), ord('子'));
        }

        function test_concat () {
            $this->assertEqual($this->str->concat(''), 'twenTY-2歲男子');
            $this->assertEqual($this->str->concat(' '), 'twenTY-2歲男子 ');
            $this->assertEqual($this->str->concat('x', 'd'), 'twenTY-2歲男子xd');
            $this->assertEqual($this->str->concat('歲'), 'twenTY-2歲男子歲');
        }

        function test_count () {
            // Return the number of non-overlapping occurrences of substring 
            // sub in the range [start, end]. Optional arguments start and end 
            // are interpreted as in slice notation.
            $this->assertEqual($this->str->count('t'), 1);
            $this->assertEqual($this->str->count('twenty'), 0);
            $this->assertEqual($this->str->count('歲男子'), 1);
            $this->assertEqual($this->str->count('歲', 10, 5), 0);
        }

        function test_endswith () {
            // Return True if the string ends with the specified suffix, 
            // otherwise return False. suffix can also be a tuple of suffixes 
            // to look for. With optional start, test beginning at that 
            // position. With optional end, stop comparing at that position.
            
            // $suffix, $start = 0, $end = PHP_INT_MAX
            $this->assertEqual($this->str->endswith('子'), true);
            $this->assertEqual($this->str->endswith('歲'), false);
            $this->assertEqual($this->str->endswith('y', 0, 6), true);
        }

        function test_find () {
            // Return the lowest index in the string where substring sub is 
            // found, such that sub is contained in the slice s[start:end]. 
            // Optional arguments start and end are interpreted as in slice 
            // notation. Return -1 if sub is not found.
            // $sub, $start = 0, $end = PHP_INT_MAX, $raise_error = false
            $this->assertEqual($this->str->find('t'), 0);
            $this->assertEqual($this->str->find('w'), 1);
            $this->assertEqual($this->str->find('歲'), 8);
            $this->assertEqual($this->str->find('子'), 10);
            $this->assertEqual($this->str->find('子', 0, 9), -1);
        }
        
        function test_fromCharCode () {
            $this->assertEqual($this->str->fromCharCode(65), 'A');
        }

        function test_index () {
            // Like find(), but raise ValueError when the substring is not found.
            $this->assertEqual($this->str->find('t'), 0);
            $this->assertEqual($this->str->find('w'), 1);
            $this->assertEqual($this->str->find('歲'), 8);
            $this->assertEqual($this->str->find('子'), 10);
            $this->assertEqual($this->str->find('子', 0, 9), -1);
        }

        function test_isalnum () {
            // Return true if all characters in the string are alphanumeric and
            // there is at least one character, false otherwise.
            $a = new Str("");
            $this->assertEqual($a->isalnum(), false);
            $a = new Str("ABC");
            $this->assertEqual($a->isalnum(), true);
            $b = new Str("123");
            $this->assertEqual($a->isalnum(), true);
            $b = new Str("123子");
            $this->assertEqual($a->isalnum(), false);
        }

        function test_isalpha () {
            // Return true if all characters in the string are alphabetic and 
            // there is at least one character, false otherwise.
            $a = new Str("");
            $this->assertEqual($a->isalpha(), false);
            $a = new Str("ABC");
            $this->assertEqual($a->isalpha(), true);
            $b = new Str("123");
            $this->assertEqual($a->isalpha(), false);
            $b = new Str("123子");
            $this->assertEqual($a->isalpha(), false);
        }

        function test_isdigit () {
            // Return true if all characters in the string are digits and there
            // is at least one character, false otherwise.
            $a = new Str("");
            $this->assertEqual($a->isdigit(), false);
            $a = new Str("ABC");
            $this->assertEqual($a->isdigit(), false);
            $b = new Str("123");
            $this->assertEqual($a->isdigit(), true);
            $b = new Str("123子");
            $this->assertEqual($a->isdigit(), false);
        }

        function test_islower () {
            // Return true if all cased characters [4] in the string are 
            // lowercase and there is at least one cased character, false 
            // otherwise.
            $a = new Str("");
            $this->assertEqual($a->islower(), false);
            $a = new Str("abc");
            $this->assertEqual($a->islower(), true);
            $b = new Str("Abc");
            $this->assertEqual($a->islower(), false);
            $b = new Str("ab9");
            $this->assertEqual($a->islower(), false);
        }

        public function isspace () {
            // Return true if there are only whitespace characters in the 
            // string and there is at least one character, false otherwise.
            return (
                mb_strlen ($this->contents) >= 1 && 
                _match ("/^\s*$/s")
            );

        }

        public function istitle () {
            // Return true if the string is a titlecased string and there is at
            // least one character, for example uppercase characters may only 
            // follow uncased characters and lowercase characters only cased 
            // ones. Return false otherwise.

        }

        public function isupper () {
            // Return true if all cased characters [4] in the string are 
            // uppercase and there is at least one cased character, false 
            // otherwise.
            return ((string) $this->upper ()) === $this->contents;
        }

        public function join ($iterable) {
            // Return a string which is the concatenation of the strings in the
            // iterable iterable. The separator between elements is the string
            // providing this method.
            return new Str (
                implode ($this->contents, $iterable)
            );
        }

        public function ljust ($width, $fillchar = ' ') {
            // Return the string left justified in a string of length width. 
            // Padding is done using the specified fillchar (default is a 
            // space). The original string is returned if width is less than 
            // or equal to len(s).
            // http://php.chinaunix.net/manual/tw/ref.mbstring.php#90611
            return new Str (
                $this->_mb_str_pad ($width, $fillchar, STR_PAD_LEFT)
            );
        }

        public function lower () {
            // Return a copy of the string with all the cased characters [4] 
            // converted to lowercase.
            return new Str (
                mb_strtolower ($this->contents, self::DEFAULT_ENCODING)
            );            
        }

        public function lstrip ($chars = ' ') {
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
            return preg_replace ('/(^\s+)/s', '', $this->contents);
        }

        public function partition ($sep) {
            // Split the string at the first occurrence of sep, and return a 
            // 3-tuple containing the part before the separator, the separator 
            // itself, and the part after the separator. If the separator is 
            // not found, return a 3-tuple containing the string itself, 
            // followed by two empty strings.

            $sep_pos = mb_strpos ($this->contents, $sep, 0, self::DEFAULT_ENCODING);
            return array (
                mb_substr ($this->contents, 0, mb_strlen($sep_pos), self::DEFAULT_ENCODING),
                $sep,
                mb_substr ($this->contents, $sep_pos + 1,PHP_INT_MAX, self::DEFAULT_ENCODING)
            );
        }

        public function replace ($old, $new, $count = PHP_INT_MAX) {
            // Return a copy of the string with all occurrences of substring 
            // old replaced by new. If the optional argument count is given, 
            // only the first count occurrences are replaced.
            // $search, $replace, $subject, $encoding
            return new Str (
                $this->_mb_str_replace ($old, $new, $this->contents, self::DEFAULT_ENCODING)
            );
        }

        public function rfind ($sub, $start = 0, $end = PHP_INT_MAX) {
            // Return the highest index in the string where substring sub is 
            // found, such that sub is contained within s[start:end]. Optional 
            // arguments start and end are interpreted as in slice notation. 
            // Return -1 on failure.

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
        
        public function toLowerCase () {
            // JS
            return $this->lower();
        }

        public function toUpperCase () {
            // JS
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

    } $e = new StringTest ();
 
    showResults (array ($e));
?>
