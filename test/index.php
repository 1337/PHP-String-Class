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
            $this->assertEqual($this->str->endswith('子'), true);
            $this->assertEqual($this->str->endswith('歲'), false);
            $this->assertEqual($this->str->endswith('Y', 0, 6), true);
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

        function test_format () {
            $this->assertEqual(false, true);
        }

        function test_index () {
            // Like find(), but raise ValueError when the substring is not found.
            $this->assertEqual($this->str->index('t'), 0);
            $this->assertEqual($this->str->index('w'), 1);
            $this->assertEqual($this->str->index('歲'), 8);
            $this->assertEqual($this->str->index('子'), 10);
            $this->assertEqual($this->str->index('子', 0, 9), -1);
        }

        function test_indexOf () {
            // Like find(), but raise ValueError when the substring is not found.
            $this->assertEqual($this->str->indexOf('t'), 0);
            $this->assertEqual($this->str->indexOf('w'), 1);
            $this->assertEqual($this->str->indexOf('歲'), 8);
            $this->assertEqual($this->str->indexOf('子'), 10);
            $this->assertEqual($this->str->indexOf('子', 0, 9), -1);
        }

        function test_isalnum () {
            // Return true if all characters in the string are alphanumeric and
            // there is at least one character, false otherwise.
            $a = new Str("");
            $this->assertEqual($a->isalnum(), false);
            $a = new Str("ABC");
            $this->assertEqual($a->isalnum(), true);
            $a = new Str("123");
            $this->assertEqual($a->isalnum(), true);
            $a = new Str("Abc123");
            $this->assertEqual($a->isalnum(), true);
            $a = new Str("Abc123 ");
            $this->assertEqual($a->isalnum(), false);
            $a = new Str("123子");
            $this->assertEqual($a->isalnum(), false);
        }

        function test_isalpha () {
            // Return true if all characters in the string are alphabetic and
            // there is at least one character, false otherwise.
            $a = new Str("");
            $this->assertEqual($a->isalpha(), false);
            $a = new Str("ABC");
            $this->assertEqual($a->isalpha(), true);
            $a = new Str("123");
            $this->assertEqual($a->isalpha(), false);
            $a = new Str("123子");
            $this->assertEqual($a->isalpha(), false);
        }

        function test_isdigit () {
            // Return true if all characters in the string are digits and there
            // is at least one character, false otherwise.
            $a = new Str("");
            $this->assertEqual($a->isdigit(), false);
            $a = new Str("ABC");
            $this->assertEqual($a->isdigit(), false);
            $a = new Str("123");
            $this->assertEqual($a->isdigit(), true);
            $a = new Str("123子");
            $this->assertEqual($a->isdigit(), false);
        }

        function test_islower () {
            // Return true if all cased characters [4] in the string are
            // lowercase and there is at least one cased character, false
            // otherwise.
            $a = new Str('');
            $this->assertEqual($a->islower(), false);
            $a = new Str("abc");
            $this->assertEqual($a->islower(), true);
            $a = new Str("Abc");
            $this->assertEqual($a->islower(), false);
            $a = new Str("ab9");
            $this->assertEqual($a->islower(), true);
        }

        function test_isspace () {
            // Return true if there are only whitespace characters in the
            // string and there is at least one character, false otherwise.
            $a = new Str("");
            $this->assertEqual($a->isspace(), false);
            $a = new Str("abc");
            $this->assertEqual($a->isspace(), false);
            $a = new Str("isspace ");
            $this->assertEqual($a->isspace(), false);
            $a = new Str(" ");
            $this->assertEqual($a->isspace(), true);
        }

        function test_istitle () {
            // Return true if the string is a titlecased string and there is at
            // least one character, for example uppercase characters may only
            // follow uncased characters and lowercase characters only cased
            // ones. Return false otherwise.
            $a = new Str("Abc Def");
            $this->assertEqual($a->istitle(), true);
            $a = new Str("abc def");
            $this->assertEqual($a->isspace(), false);
            $a = new Str("Abc De子");
            $this->assertEqual($a->isspace(), true);
        }

        function test_isupper () {
            // Return true if all cased characters [4] in the string are
            // uppercase and there is at least one cased character, false
            // otherwise.
            $this->assertEqual($this->str->isupper(), false);
            $a = new Str("");
            $this->assertEqual($a->isupper(), false);
            $a = new Str("abc");
            $this->assertEqual($a->isupper(), false);
            $a = new Str("Abc");
            $this->assertEqual($a->isupper(), false);
            $a = new Str("AB9");
            $this->assertEqual($a->isupper(), true);
            $a = new Str("ABC");
            $this->assertEqual($a->isupper(), true);
        }

        function test_join () {
            // Return a string which is the concatenation of the strings in the
            // iterable iterable. The separator between elements is the string
            // providing this method.
            $iterable = array (1," 2","ffffuuuu-", "歲");
            $a = new Str (',');
            $this->assertEqual($a->join($iterable), '1, 2,ffffuuuu-,歲');
            $a = new Str ('歲');
            $this->assertEqual($a->join($iterable), '1歲 2歲ffffuuuu-歲歲');
        }

        function test_json () {
            $this->assertEqual($this->str->json(), '"twenTY-2\u6b72\u7537\u5b50"');
        }

        function test_lastIndexOf () {
            $this->assertEqual($this->str->lastIndexOf('Y'), 5);
        }

        function test_length () {
            $this->assertEqual($this->str->length(), 11);
        }

        function test_ljust () {
            // Return the string left justified in a string of length width.
            // Padding is done using the specified fillchar (default is a
            // space). The original string is returned if width is less than
            // or equal to len(s).
            $this->assertEqual($this->str->ljust(0), 'twenTY-2歲男子');
            $this->assertEqual($this->str->ljust(10), 'twenTY-2歲男子');
            $this->assertEqual($this->str->ljust(15), 'twenTY-2歲男子    ');
            $this->assertEqual($this->str->ljust(15, 't'), 'twenTY-2歲男子tttt');
            $this->assertEqual($this->str->ljust(13, 't'), 'twenTY-2歲男子tt');
            $this->assertEqual($this->str->ljust(13, '男'), 'twenTY-2歲男子男男');
        }

        function test_lower () {
            $a = new Str ("aBc");
            $this->assertEqual($a->lower(), 'abc');
            $a = new Str ("aB男");
            $this->assertEqual($a->lower(), 'ab男');
        }

        function test_lstrip () {
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
            $this->assertEqual($this->str->lstrip(), 'twenTY-2歲男子');
            $this->assertEqual($this->str->lstrip('t'), 'wenTY-2歲男子');
            $this->assertEqual($this->str->lstrip('tw'), 'enTY-2歲男子');
            $a = new Str (" ab男");
            $this->assertEqual($a->lstrip(), 'ab男');
        }

        function test_partition () {
            // Split the string at the first occurrence of sep, and return a
            // 3-tuple containing the part before the separator, the separator
            // itself, and the part after the separator. If the separator is
            // not found, return a 3-tuple containing the string itself,
            // followed by two empty strings.
            $a = new Str ("ab男");
            $this->assertEqual($a->partition ('b'), array ('a','b','男'));
            $a = new Str ("abbb男");
            $this->assertEqual($a->partition ('b'), array ('a','b','bb男'));
            $a = new Str ("ab男");
            $this->assertEqual($a->partition ('c'), array ('ab男','',''));
        }

        function test_replace () {
            // Return a copy of the string with all occurrences of substring
            // old replaced by new. If the optional argument count is given,
            // only the first count occurrences are replaced.
            // $search, $replace, $subject, $encoding
            $this->assertEqual($this->str->replace('t', 'w'), 'wwenTY-2歲男子');
            $this->assertEqual($this->str->replace('t', '子'), '子wenTY-2歲男子');
            $this->assertEqual($this->str->replace('男', 'w'), 'twenTY-2歲w子');
            $a = new Str ("男男男男男");
            $this->assertEqual($a->replace('男', 'w', 3), 'www男男');
        }

        function test_rfind () {
            // Return the highest index in the string where substring sub is
            // found, such that sub is contained within s[start:end]. Optional
            // arguments start and end are interpreted as in slice notation.
            // Return -1 on failure.
            $this->assertEqual($this->str->rfind('男'), 9);
            $this->assertEqual($this->str->rfind('男', 8), 9);
            $this->assertEqual($this->str->rfind('男', 10), -1);
        }

        function test_rjust () {
            // Return the string right justified in a string of length width.
            // Padding is done using the specified fillchar (default is a
            // space). The original string is returned if width is less than or
            // equal to len(s).
            $this->assertEqual($this->str->rjust(0), 'twenTY-2歲男子');
            $this->assertEqual($this->str->rjust(10), 'twenTY-2歲男子');
            $this->assertEqual($this->str->rjust(15), '    twenTY-2歲男子');
            $this->assertEqual($this->str->rjust(15, 't'), 'tttttwenTY-2歲男子');
            $this->assertEqual($this->str->rjust(13, '男'), '男男twenTY-2歲男子');
        }

        function test_rindex () {
            // Return the highest index in the string where substring sub is
            // found, such that sub is contained within s[start:end]. Optional
            // arguments start and end are interpreted as in slice notation.
            // Return -1 on failure.
            $this->assertEqual($this->str->rindex('男'), 9);
            $this->assertEqual($this->str->rindex('男', 8), 9);
            $this->assertEqual($this->str->rindex('男', 10), -1);
        }

        public function test_rpartition () {
            $this->assertEqual(false, true);
        }

        public function test_rsplit () {
            $this->assertEqual(false, true);
        }

        public function test_rstrip () {
            $this->assertEqual(false, true);
        }

        public function test_splice () {
            $a = new Str ('The fox jumped over the lazy dog.');
            $this->assertEqual($a->splice(4, 0, 'quick brown '),
                               'The quick brown fox jumped over the lazy dog.');
        }

        public function test_split () {
            // Return a list of the words in the string, using sep as the delimiter string. If maxsplit is given, at most maxsplit splits are done (thus, the list will have at most maxsplit+1 elements). If maxsplit is not specified, then there is no limit on the number of splits (all possible splits are made).
            // If sep is given, consecutive delimiters are not grouped together and are deemed to delimit empty strings (for example, '1,,2'.split(',') returns ['1', '', '2']). The sep argument may consist of multiple characters (for example, '1<>2<>3'.split('<>') returns ['1', '2', '3']). Splitting an empty string with a specified separator returns [''].
            // If sep is not specified or is None, a different splitting algorithm is applied: runs of consecutive whitespace are regarded as a single separator, and the result will contain no empty strings at the start or end if the string has leading or trailing whitespace. Consequently, splitting an empty string or a string consisting of just whitespace with a None separator returns [].
            // For example, ' 1  2   3  '.split() returns ['1', '2', '3'], and '  1  2   3  '.split(None, 1) returns ['1', '2   3  '].
            $a = new Str ("1, 2, 3");
            $this->assertEqual($a->split(', '), array ('1','2','3'));
            $a = new Str ("1男 2男 3");
            $this->assertEqual($a->split('男 '), array ('1','2','3'));
            $a = new Str ("男 男 男");
            $this->assertEqual($a->split(), array ('男','男','男'));
        }

        public function test_splitlines ($keepends = false) {
            // Return a list of the lines in the string, breaking at line boundaries. Line breaks are not included in the resulting list unless keepends is given and true.
            $this->assertEqual(false, true);
        }

        public function test_startswith () {
            // Return True if string starts with the prefix, otherwise return False. prefix can also be a tuple of prefixes to look for. With optional start, test string beginning at that position. With optional end, stop comparing string at that position.
            $this->assertEqual($this->str->startswith('t'), true);
            $this->assertEqual($this->str->startswith('tw'), true);
            $this->assertEqual($this->str->startswith('男', 8), true);
        }

        public function test_strip () {
            $a = new Str (" ab男  ");
            $this->assertEqual($a->strip(), 'ab男');
        }

        public function test_substring () {
            $this->assertEqual(false, true);
        }

        public function test_swapcase () {
            $this->assertEqual($this->str->swapcase(), "TWENty-2歲男子");
        }

        public function test_title () {
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
            $this->assertEqual(false, true);
        }

        public function test_translate () {
            // Return a copy of the string where all characters occurring in the optional argument deletechars are removed, and the remaining characters have been mapped through the given translation table, which must be a string of length 256.
            // You can use the maketrans() helper function in the string module to create a translation table. For string objects, set the table argument to None for translations that only delete characters:
            // >>>
            // >>> 'read this short text'.translate(None, 'aeiou')
            // 'rd ths shrt txt'
            // New in version 2.6: Support for a None table argument.
            // For Unicode objects, the translate() method does not accept the optional deletechars argument. Instead, it returns a copy of the s where all characters have been mapped through the given translation table which must be a mapping of Unicode ordinals to Unicode ordinals, Unicode strings or None. Unmapped characters are left untouched. Characters mapped to None are deleted. Note, a more flexible approach is to create a custom character mapping codec using the codecs module (see encodings.cp1251 for an example).
            $this->assertEqual(false, true);
        }

        public function test_upper () {
            // Return a copy of the string with all the cased characters [4] converted to uppercase. Note that str.upper().isupper() might be False if s contains uncased characters or if the Unicode category of the resulting character(s) is not “Lu” (Letter, uppercase), but e.g. “Lt” (Letter, titlecase).
            // For 8-bit strings, this method is locale-dependent.
            $this->assertEqual($this->str->upper(), "TWENTY-2歲男子");
        }

        public function test_zfill () {
            // Return the numeric string left filled with zeros in a string of length width. A sign prefix is handled correctly. The original string is returned if width is less than or equal to len(s).
            $this->assertEqual(false, true);
        }

    } $e = new StringTest ();

    showResults (array ($e));
?>
