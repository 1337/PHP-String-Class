<?php
    interface BaseString {
        /*  Interface of the Python basestring type.
            Note that, as close as the syntax will be, there will always be
            differences: the exceptions you expect, keyword arguments
            limitation, use of tuples and, possibly, PHP reserved keywords.

            Also, I don't implement functions I don't like.
        */
        public function capitalize ();
        // Return a copy of the string with its first character capitalized and the rest lowercased.
        // For 8-bit strings, this method is locale-dependent.

        public function center(width[, fillchar]);
        // Return centered in a string of length width. Padding is done using the specified fillchar (default is a space).
        // Changed in version 2.4: Support for the fillchar argument.

        public function count(sub[, start[, end]]);
        // Return the number of non-overlapping occurrences of substring sub in the range [start, end]. Optional arguments start and end are interpreted as in slice notation.

        public function decode([encoding[, errors]]);
        // Decodes the string using the codec registered for encoding. encoding defaults to the default string encoding. errors may be given to set a different error handling scheme. The default is 'strict', meaning that encoding errors raise UnicodeError. Other possible values are 'ignore', 'replace' and any other name registered via codecs.register_error(), see section Codec Base Classes.
        // New in version 2.2.
        // Changed in version 2.3: Support for other error handling schemes added.
        // Changed in version 2.7: Support for keyword arguments added.

        public function encode([encoding[, errors]]);
        // Return an encoded version of the string. Default encoding is the current default string encoding. errors may be given to set a different error handling scheme. The default for errors is 'strict', meaning that encoding errors raise a UnicodeError. Other possible values are 'ignore', 'replace', 'xmlcharrefreplace', 'backslashreplace' and any other name registered via codecs.register_error(), see section Codec Base Classes. For a list of possible encodings, see section Standard Encodings.
        // New in version 2.0.
        // Changed in version 2.3: Support for 'xmlcharrefreplace' and 'backslashreplace' and other error handling schemes added.
        // Changed in version 2.7: Support for keyword arguments added.

        public function endswith(suffix[, start[, end]]);
        // Return True if the string ends with the specified suffix, otherwise return False. suffix can also be a tuple of suffixes to look for. With optional start, test beginning at that position. With optional end, stop comparing at that position.
        // Changed in version 2.5: Accept tuples as suffix.

        public function expandtabs([tabsize]);
        // Return a copy of the string where all tab characters are replaced by one or more spaces, depending on the current column and the given tab size. The column number is reset to zero after each newline occurring in the string. If tabsize is not given, a tab size of 8 characters is assumed. This doesn’t understand other non-printing characters or escape sequences.

        public function find(sub[, start[, end]]);
        // Return the lowest index in the string where substring sub is found, such that sub is contained in the slice s[start:end]. Optional arguments start and end are interpreted as in slice notation. Return -1 if sub is not found.
        // Note: The find() method should be used only if you need to know the position of sub. To check if sub is a substring or not, use the in operator: >>>
        // >>> 'Py' in 'Python'
        // True
        // >>>
        // >>> 'Py' in 'Python'
        // True

        public function format(*args, **kwargs);
        // Perform a string formatting operation. The string on which this method is called can contain literal text or replacement fields delimited by braces {}. Each replacement field contains either the numeric index of a positional argument, or the name of a keyword argument. Returns a copy of the string where each replacement field is replaced with the string value of the corresponding argument.
        // >>>
        // >>> "The sum of 1 + 2 is {0}".format(1+2)
        // 'The sum of 1 + 2 is 3'
        // See Format String Syntax for a description of the various formatting options that can be specified in format strings.
        // This method of string formatting is the new standard in Python 3.0, and should be preferred to the % formatting described in String Formatting Operations in new code.
        // New in version 2.6.

        public function index(sub[, start[, end]]);
        // Like find(), but raise ValueError when the substring is not found.

        public function isalnum();
        // Return true if all characters in the string are alphanumeric and there is at least one character, false otherwise.
        // For 8-bit strings, this method is locale-dependent.

        public function isalpha();
        // Return true if all characters in the string are alphabetic and there is at least one character, false otherwise.
        // For 8-bit strings, this method is locale-dependent.

        public function isdigit();
        // Return true if all characters in the string are digits and there is at least one character, false otherwise.
        // For 8-bit strings, this method is locale-dependent.

        public function islower();
        // Return true if all cased characters [4] in the string are lowercase and there is at least one cased character, false otherwise.
        // For 8-bit strings, this method is locale-dependent.

        public function isspace();
        // Return true if there are only whitespace characters in the string and there is at least one character, false otherwise.
        // For 8-bit strings, this method is locale-dependent.

        public function istitle();
        // Return true if the string is a titlecased string and there is at least one character, for example uppercase characters may only follow uncased characters and lowercase characters only cased ones. Return false otherwise.
        // For 8-bit strings, this method is locale-dependent.

        public function isupper();
        // Return true if all cased characters [4] in the string are uppercase and there is at least one cased character, false otherwise.
        // For 8-bit strings, this method is locale-dependent.

        public function join(iterable);
        // Return a string which is the concatenation of the strings in the iterable iterable. The separator between elements is the string providing this method.

        public function ljust(width[, fillchar])
        // Return the string left justified in a string of length width. Padding is done using the specified fillchar (default is a space). The original string is returned if width is less than or equal to len(s).
        // Changed in version 2.4: Support for the fillchar argument.

        public function lower();
        // Return a copy of the string with all the cased characters [4] converted to lowercase.
        // For 8-bit strings, this method is locale-dependent.

        public function lstrip([chars]);
        // Return a copy of the string with leading characters removed. The chars argument is a string specifying the set of characters to be removed. If omitted or None, the chars argument defaults to removing whitespace. The chars argument is not a prefix; rather, all combinations of its values are stripped:
        // >>>
        // >>> '   spacious   '.lstrip()
        // 'spacious   '
        // >>> 'www.example.com'.lstrip('cmowz.')
        // 'example.com'
        // Changed in version 2.2.2: Support for the chars argument.

        public function partition(sep);
        // Split the string at the first occurrence of sep, and return a 3-tuple containing the part before the separator, the separator itself, and the part after the separator. If the separator is not found, return a 3-tuple containing the string itself, followed by two empty strings.
        // New in version 2.5.

        public function replace(old, new[, count]);
        // Return a copy of the string with all occurrences of substring old replaced by new. If the optional argument count is given, only the first count occurrences are replaced.

        public function rfind(sub[, start[, end]]);
        // Return the highest index in the string where substring sub is found, such that sub is contained within s[start:end]. Optional arguments start and end are interpreted as in slice notation. Return -1 on failure.

        public function rindex(sub[, start[, end]]);
        // Like rfind() but raises ValueError when the substring sub is not found.

        public function rjust(width[, fillchar]);
        // Return the string right justified in a string of length width. Padding is done using the specified fillchar (default is a space). The original string is returned if width is less than or equal to len(s).
        // Changed in version 2.4: Support for the fillchar argument.

        public function rpartition(sep);
        // Split the string at the last occurrence of sep, and return a 3-tuple containing the part before the separator, the separator itself, and the part after the separator. If the separator is not found, return a 3-tuple containing two empty strings, followed by the string itself.
        // New in version 2.5.

        public function rsplit([sep[, maxsplit]]);
        // Return a list of the words in the string, using sep as the delimiter string. If maxsplit is given, at most maxsplit splits are done, the rightmost ones. If sep is not specified or None, any whitespace string is a separator. Except for splitting from the right, rsplit() behaves like split() which is described in detail below.
        // New in version 2.4.

        public function rstrip([chars]);
        // Return a copy of the string with trailing characters removed. The chars argument is a string specifying the set of characters to be removed. If omitted or None, the chars argument defaults to removing whitespace. The chars argument is not a suffix; rather, all combinations of its values are stripped:
        // >>>
        // >>> '   spacious   '.rstrip()
        // '   spacious'
        // >>> 'mississippi'.rstrip('ipz')
        // 'mississ'
        // Changed in version 2.2.2: Support for the chars argument.

        public function split([sep[, maxsplit]]);
        // Return a list of the words in the string, using sep as the delimiter string. If maxsplit is given, at most maxsplit splits are done (thus, the list will have at most maxsplit+1 elements). If maxsplit is not specified, then there is no limit on the number of splits (all possible splits are made).
        // If sep is given, consecutive delimiters are not grouped together and are deemed to delimit empty strings (for example, '1,,2'.split(',') returns ['1', '', '2']). The sep argument may consist of multiple characters (for example, '1<>2<>3'.split('<>') returns ['1', '2', '3']). Splitting an empty string with a specified separator returns [''].
        // If sep is not specified or is None, a different splitting algorithm is applied: runs of consecutive whitespace are regarded as a single separator, and the result will contain no empty strings at the start or end if the string has leading or trailing whitespace. Consequently, splitting an empty string or a string consisting of just whitespace with a None separator returns [].
        // For example, ' 1  2   3  '.split() returns ['1', '2', '3'], and '  1  2   3  '.split(None, 1) returns ['1', '2   3  '].

        public function splitlines([keepends]);
        // Return a list of the lines in the string, breaking at line boundaries. Line breaks are not included in the resulting list unless keepends is given and true.

        public function startswith(prefix[, start[, end]]);
        // Return True if string starts with the prefix, otherwise return False. prefix can also be a tuple of prefixes to look for. With optional start, test string beginning at that position. With optional end, stop comparing string at that position.
        // Changed in version 2.5: Accept tuples as prefix.
        
        public function strip([chars]);
        // Return a copy of the string with the leading and trailing characters removed. The chars argument is a string specifying the set of characters to be removed. If omitted or None, the chars argument defaults to removing whitespace. The chars argument is not a prefix or suffix; rather, all combinations of its values are stripped:
        // >>>
        // >>> '   spacious   '.strip()
        // 'spacious'
        // >>> 'www.example.com'.strip('cmowz.')
        // 'example'
        // Changed in version 2.2.2: Support for the chars argument.

        public function swapcase();
        // Return a copy of the string with uppercase characters converted to lowercase and vice versa.
        // For 8-bit strings, this method is locale-dependent.

        public function title();
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
        // For 8-bit strings, this method is locale-dependent.

        public function translate(table[, deletechars]);
        // Return a copy of the string where all characters occurring in the optional argument deletechars are removed, and the remaining characters have been mapped through the given translation table, which must be a string of length 256.
        // You can use the maketrans() helper function in the string module to create a translation table. For string objects, set the table argument to None for translations that only delete characters:
        // >>>
        // >>> 'read this short text'.translate(None, 'aeiou')
        // 'rd ths shrt txt'
        // New in version 2.6: Support for a None table argument.
        // For Unicode objects, the translate() method does not accept the optional deletechars argument. Instead, it returns a copy of the s where all characters have been mapped through the given translation table which must be a mapping of Unicode ordinals to Unicode ordinals, Unicode strings or None. Unmapped characters are left untouched. Characters mapped to None are deleted. Note, a more flexible approach is to create a custom character mapping codec using the codecs module (see encodings.cp1251 for an example).

        public function upper();
        // Return a copy of the string with all the cased characters [4] converted to uppercase. Note that str.upper().isupper() might be False if s contains uncased characters or if the Unicode category of the resulting character(s) is not “Lu” (Letter, uppercase), but e.g. “Lt” (Letter, titlecase).
        // For 8-bit strings, this method is locale-dependent.

        public function zfill(width);
        // Return the numeric string left filled with zeros in a string of length width. A sign prefix is handled correctly. The original string is returned if width is less than or equal to len(s).
        // New in version 2.2.2.
    }
    
    class Str implements BaseString {
    
    }

    class Unicode implements BaseString {
        // The following methods are present only on unicode objects:
        // unicode.isnumeric()

        // Return True if there are only numeric characters in S, False otherwise. Numeric characters include digit characters, and all characters that have the Unicode numeric value property, e.g. U+2155, VULGAR FRACTION ONE FIFTH.
        // unicode.isdecimal()

        // Return True if there are only decimal characters in S, False otherwise. Decimal characters include digit characters, and all characters that can be used to form decimal-radix numbers, e.g. U+0660, ARABIC-INDIC DIGIT ZERO.    }    
    }

// why doesn't this function exist?
if(!function_exists('mb_str_replace')) {
	function mb_str_replace($search, $replace, $subject) {
		if(is_array($subject)) {
			$ret = array();
			foreach($subject as $key => $val) {
				$ret[$key] = mb_str_replace($search, $replace, $val);
			}
			return $ret;
		}
		foreach((array) $search as $key => $s) {
			if($s == '') {
				continue;
			}
			$r = !is_array($replace) ? $replace : (array_key_exists($key, $replace) ? $replace[$key] : '');
			$pos = mb_strpos($subject, $s);
			while($pos !== false) {
				$subject = mb_substr($subject, 0, $pos) . $r . mb_substr($subject, $pos + mb_strlen($s));
				$pos = mb_strpos($subject, $s, $pos + mb_strlen($r));
			}
		}
		return $subject;
	}
}
if(!function_exists('mb_str_split')) {
	function mb_str_split($str, $length = 1) {
		if ($length < 1) return FALSE;

		$result = array();

		for ($i = 0; $i < mb_strlen($str); $i += $length) {
			$result[] = mb_substr($str, $i, $length);
		}

		return $result;
	}
}

class StaticString {
	/* static methods wrapping multibyte */

	/**
	 * Wrapper for substr
	 */
	public static function substr ($string, $start, $length = null) {
		if(String::$multibyte) {
			return new String(mb_substr($string, $start, $length, String::$multibyte_encoding));
		}
		else {
			return new String(substr($string, $start, $length));
		}
	}

	/**
	 * Equivelent of Javascript's String.substring
	 * @link http://www.w3schools.com/jsref/jsref_substring.asp
	 */
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

	public static function strlen ($string) {
		if(String::$multibyte) {
			return mb_strlen($string, String::$multibyte_encoding);
		}
		else {
			return strlen($string);
		}
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

	/* end static wrapper methods */
}
class String implements ArrayAccess {
	private $value;

	public static $multibyte = false;
	private static $checked = false;
	public static $multibyte_encoding = null;

	/* magic methods */
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

	/* end magic methods */

	/* ArrayAccess Methods */

	/** offsetExists ( mixed $index )
		*
		* Similar to array_key_exists
		*/
	public function offsetExists ($index) {
		return !empty($this->value[$index]);
	}

	/* offsetGet ( mixed $index )
	 *
	 * Retrieves an array value
	 */
	public function offsetGet ($index) {
		return StaticString::substr($this->value, $index, 1)->toString();
	}

	/* offsetSet ( mixed $index, mixed $val )
	 *
	 * Sets an array value
	 */
	public function offsetSet ($index, $val) {
		$this->value = StaticString::substring($this->value, 0, $index) . $val . StaticString::substring($this->value, $index+1, StaticString::strlen($this->value));
	}

	/* offsetUnset ( mixed $index )
	 *
	 * Removes an array value
	 */
	public function offsetUnset ($index) {
		$this->value = StaticString::substr($this->value, 0, $index) . StaticString::substr($this->value, $index+1);
	}

	public static function create ($obj) {
		if($obj instanceof String) return new String($obj);
		return new String($obj);
	}

	/* public methods */
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

	public function join ($paste = '') {
		return implode($paste, $this->getArrayCopy());
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

