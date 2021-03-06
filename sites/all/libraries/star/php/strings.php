<?php
// useful string functions:

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Bonus echo functions.

/**
 * Echo a string with a newline.
 *
 * @param string $str
 */
function echoln($str = '') {
  echo "$str\n";
}

/**
 * Echo a string with a break tag and a newline.
 *
 * @param string $str
 */
function echobr($str = '') {
  echo "$str<br>\n";
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Append functions.

/**
 * Append one string to another.
 *
 * @param string $str
 * @param string $str_to_append
 */
function append(&$str, $str_to_append = '') {
  $str .= $str_to_append;
}

/**
 * Append one string with a newline to another string, i.e. append a line.
 *
 * @param string $str
 * @param string $str_to_append
 */
function appendln(&$str, $str_to_append = '') {
  $str .= "$str_to_append\n";
}

/**
 * Append one string with a break tag and a newline to another string, i.e. append an HTML line.
 *
 * @param string $str
 * @param string $str_to_append
 */
function appendbr(&$str, $str_to_append = '') {
  $str .= "$str_to_append<br>\n";
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Probably don't need this one any more.
function extractFilename($path) {
  $filename = $path;
  $n = strrpos($path, "/");
  if ($n !== FALSE)
    $filename = substr($filename, $n + 1);
  return $filename;
}

/**
 * Checks if a character is a vowel.
 *
 * @param string $ch
 * @return bool
 */
function isVowel($ch) {
  return in_array(strtolower($ch), array("a", "e", "i", "o", "u"));
}

function plural($str, $n = 0, $returnNum = FALSE)
{
  // if $n == 1, returns $str (which should be singular form)
  // if $n != 1, returns the plural form of $str
  // Please note this function covers most but not all English plurals.
  if ($n == 1)
    $result = $str;
  else
  {
    // find plural form:
    $len = strlen($str);
    $lastCh = $str{$len - 1};
    $secondLastCh = $str{$len - 2};
    $last2Chars = $lastCh.$secondLastCh;
    if ($lastCh == ".")
    {
      // it's an abbreviation, no change:
      $result = $str;
    }
    else if ($last2Chars == 'is') // e.g. synopsis -> synopses
    {
      // change 'is' to 'es':
      $result = substr($str, 0, $len - 2).'es';
    }
    else if (
      in_array($lastCh, array('s', 'z', 'x')) ||
      in_array($last2Chars, array('ch', 'sh')) ||
      in_array($str, array('echo', 'embargo', 'hero', 'potato', 'tomato', 'torpedo', 'veto')))
    {
      // add 'es':
      $result = $str.'es';
    }
    else if ($lastCh == 'f') // e.g. elf
    {
      // change 'f' to 'ves':
      $result = substr($str, 0, $len - 1).'ves';
    }
    else if ($last2Chars == 'fe') // e.g. life
    {
      // change 'fe' to 'ves':
      $result = substr($str, 0, $len - 2).'ves';
    }
    else if ($lastCh == "y" && !isVowel($secondLastCh))
    {
      // ends in a consonant followed by 'y', change to 'ies':
      $result = substr($str, 0, $len - 1)."ies";
    }
    else
    {
      // most other cases, add 's':
      $result = $str."s";
    }
  }
  // return result:
  if ($returnNum)
    return $n.' '.$result;
  else
    return $result;
}

/**
 * Replaces Unix (\r\n) and old Mac (\r) newlines with Windows newlines (\n).
 *
 * @param string $str
 * @return string
 */
function simpleNewlines($str) {
  $str = str_replace("\r\n", "\n", $str);
  $str = str_replace("\r", "\n", $str);
  return $str;
}

/**
 * Converts all newlines, whether from Windows, Mac or Unix, into HTML break tags plus \n.
 *
 * @param string $str
 * @return string
 */
function nl2brs($str) {
  return str_replace("\n", "<br>\n", simpleNewlines($str));
}

/**
 * This function is handy for addresses that have been entered into a multiline textbox,
 * which you want to convert to a string with no newlines or breaks.
 *
 * @param string $str
 * @return string
 */
function nl2commas($str) {
  return str_replace(array(",\n", "\n"), ', ', simpleNewlines($str));
}

/**
 * Backslashes newlines and carriage returns. Useful for outputting strings to JavaScript.
 *
 * e.g.
 *     echo "var str = '".nl2slashn("This string has\nlinefeeds in it.")."';";
 * is the same as
 *     echo "var str = 'This string has\\nlinefeeds in it.';";
 * which renders in JavaScript as
 *     var str = 'This string has\nlinefeeds in it.';
 *
 * @param string $str
 * @return string
 */
function nl2slashn($str) {
  $str = str_replace("\n", "\\n", $str);
  $str = str_replace("\r", "\\r", $str);
  $str = str_replace("\t", "\\t", $str);
  return $str;
}


function addslashes_nl($str) {
  // same as addslashes but also converts newlines and carriage returns to backslash codes:
  return nl2slashn(addslashes($str));
}

/**
 * Removes all characters from a string that do not match the specified char type.
 *
 * @see http://www.php.net/manual/en/book.ctype.php
 *
 * @param string $str
 * @param string $ctype
 *   Matches one of the ctype functions: 'alnum', 'alpha', 'cntrl', 'digit', 'graph', 'lower',
 *     'print', 'punct', 'space', 'upper', 'xdigit'.
 * @return string
 */
function stripNonMatchingChars($str, $ctype) {
  $str = (string) $str;
  if ($str == '') {
    return '';
  }
  $result = '';
  $fn = 'ctype_' . $ctype;
  for ($i = 0; $i < strlen($str); $i++)  {
    if ($fn($str[$i])) {
      $result .= $str[$i];
    }
  }
  return $result;
}

/**
 * Removes all non-digit characters from a string.
 *
 * @param string $str
 * @return string
 */
function stripNonDigits($str) {
  return stripNonMatchingChars($str, 'digit');
}

/**
 * Removes all non-letters from a string.
 *
 * @param string $str
 * @return string
 */
function stripNonAlpha($str) {
  return stripNonMatchingChars($str, 'alpha');
}

/**
 * Removes all non-alphanumeric characters from a string.
 *
 * @param string $str
 * @return string
 */
function stripNonAlnum($str) {
  return stripNonMatchingChars($str, 'alnum');
}

/**
 * Removes all whitespace characters from a string.
 *
 * @param string $str
 * @return string
 */
function stripWhitespace($str) {
  return stripNonMatchingChars($str, 'space');
}

/**
 * Returns true if $str contains one or more digits.
 *
 * @param string $str
 * @return bool
 */
function containsDigits($str) {
  for ($i = 0; $i < strlen($str); $i++)  {
    if (ctype_digit($str{$i})) {
      return TRUE;
    }
  }
  return FALSE;
}

/**
 * Splits $name into:
 *     - social title
 *     - first name
 *     - middle name(s)
 *     - last name (including nobiliary particles)
 * Note, this function is designed for western-style names,
 * i.e. it is not suited for names that begin with the family name, e.g. Chinese
 *
 * @todo Add support for middle name.
 * @todo Add support for Jr./Sr.
 * @todo Add support for roman numerals following name (i.e. Charles Emerson Winchester III)
 *
 * @param string $name
 * @param string $title
 * @param string $firstName
 * @param string $middleName
 * @param string $lastName
 */
function splitName($name) {
  // social titles:
  $socialTitles = array('mr', 'mrs', 'miss', 'ms', 'dr', 'prof');

  // words that belong in the surname:
  $nobiliaryParticles = array('a', 'bat', 'ben', 'bin', 'da', 'das', 'de', 'del', 'della', 'dem',
    'den', 'der', 'des', 'di', 'do', 'dos', 'du', 'ibn', 'la', 'las', 'le', 'li', 'lo', 'mac',
    'mc', 'op', "'t", 'te', 'ten', 'ter', 'van', 'ver', 'von', 'y', 'z', 'zu', 'zum', 'zur');

  // parse name into words:
  $names = explode(' ', $name);
  foreach ($names as $key => $name) {
    $names[$key] = trim($name);
  }
  $names = array_filter($names);

  // how many?
  $nNames = count($names);

  // look for title:
  $title = '';
  foreach ($socialTitles as $st) {
    if (strtolower($names[0]) == $st || strtolower($names[0]) == $st . '.') {
      $title = array_shift($names);
      $nNames--;
      // remove the full-stop if present:
      if (endsWith($title, '.')) {
        $title = substr($title, 0, strlen($title) - 1);
      }
      break;
    }
  }

  if ($nNames == 1)  {
    // only one word:
    if ($title) {
      // if there's a title, assume that the name is the last name:
      $lastName = $names[0];
    }
    else {
      // assume it's the first name:
      $firstName = $names[0];
    }
  }
  else {
    // go through names from right to left building the surname:
    $firstName = $names[0];
    $lastName = &$names[$nNames - 1];
    for ($i = $nNames - 2; $i >= 0; $i--) {
      if (in_array(strtolower($names[$i]), $nobiliaryParticles)) {
        $lastName = $names[$i] . ' ' . $lastName;
        unset($names[$i]);
      }
      else {
        break;
      }
    }
  }
  // result:
  $names = array_values($names);
  $names['title'] = $title;
  $names['first'] = $firstName;
  $names['last'] = $lastName;
  return $names;
}


/**
 * Convert a string to a boolean.
 * Case-insensitive.
 *
 * @param string $str
 * @return bool
 */
function str2bool($str) {
  return in_array(strtolower($str), array(1, 't', 'true', 'y', 'yes', 'on'));
}


/**
 * Converts a boolean value to a string, either 'TRUE' or 'FALSE'.
 * Useful for outputting bools in JavaScript.
 *
 * @param bool $bool
 * @return string
 */
function bool2str($bool)
{
  return $bool ? 'TRUE' : 'FALSE';
}


/**
 * Converts a boolean value to either 'YES' or 'NO'.
 * Useful for display boolean values in a web page.
 *
 * @param bool $bool
 * @return string
 */
function bool2yn($bool)
{
  return $bool ? 'YES' : 'NO';
}


/**
 * Converts a string to a bit.  Same as str2bool except that result is 1 or 0.
 * Useful for converting booleans for database entry.
 *
 * @param str $str
 * @return int
 */
function str2bit($str)
{
  return (int)str2bool($str);
}



function expandYN($ch, $Y = 'Yes', $N = 'No', $default = 'N')
{
  if ($ch === TRUE || $ch == 'Y')
    return $Y;
  else if ($ch === FALSE || $ch == 'N' || $default == 'N')
    return $N;
  else
    return $default;
}


/**
 * If $str begins with http:// or https://, then this is removed and the resulting string returned.
 *
 * @param string $str
 * @return string
 */
function trimhttp($str)
{
  $str = trim($str);
  $lower = strtolower($str);
  if (strpos($lower, 'http://') === 0)
  {
    $str = substr($str, 7);
  }
  elseif (strpos($lower, 'https://') === 0)
  {
    $str = substr($str, 8);
  }
  return $str;
}


/**
 * If $str doesn't begin with 'http://', then this is added and the resulting string returned.
 *
 * @param string $str
 * @return string
 */
function addhttp($str)
{
  $str = trim($str);
  $lower = strtolower($str);
  if (strpos($lower, 'http://') !== 0 && strpos($lower, 'https://') !== 0)
  {
    $str = "http://$str";
  }
  return $str;
}


/**
 * Takes a URL entered into a form field and checks the http:// prefix.
 * If $str == 'http://', then an empty string is returned.
 * Otherwise, if the string does not begin with http:// or https:// then http:// is appended.
 *
 * @param string $str
 * @return string
 */
function url2db($str)
{
  if ($str == 'http://' || $str == 'https://')
  {
    return '';
  }
  elseif ($str != '')
  {
    return addhttp($str);
  }
  return $str;
}

/**
 * Converts a database field into a URL for display in a form field.
 * Simply, if $str == '', the result is 'http://' - this provides a prompt for the user.
 *
 * @param string $str
 * @return string
 */
function db2url($str)
{
  return $str ? db2html($str) : 'http://';
}

function gibberish($nParagraphs, $minWordsPerParagraph, $maxWordsPerParagraph)
{
  for ($p = 0; $p < $nParagraphs; $p++)
  {
    $words = '';
    $nWords = rand($minWordsPerParagraph, $maxWordsPerParagraph);
    // paragraph is $nWords of gibberish:
    for ($n = 0; $n < $nWords; $n++)
    {
      $wordLen = rand(1, 12);
      $word = '';
      for ($c = 0; $c < $wordLen; $c++)
      {
        $ch = chr(rand(97, 122));
        if ($c == 0)
          $ch = strtoupper($ch);
        $word .= $ch;
      }
      $words[] = $word;
    }
    $paragraphs[] = implode(' ', $words).".";
  }
  return implode("\r\n\r\n", $paragraphs);
}


function colourStr($red, $green, $blue)
{
  // returns a hexadecimal colour string (e.g F3BC3E) given values for red, green, blue (0..255)
  return strtoupper(str_pad(base_convert($red, 10, 16), 2, '0', STR_PAD_LEFT).
    str_pad(base_convert($green, 10, 16), 2, '0', STR_PAD_LEFT).
    str_pad(base_convert($blue, 10, 16), 2, '0', STR_PAD_LEFT));
}

/**
 * Checks if $needle is in $haystack.
 *
 * @param string $haystack
 * @param string $needle
 * @param bool $case_sensitive
 * @return bool
 */
function in_str($haystack, $needle, $case_sensitive = TRUE) {
  if ($case_sensitive) {
    return strpos($haystack, $needle) !== FALSE;
  }
  return strpos(strtolower($haystack), strtolower($needle)) !== FALSE;
}

function html2db($str)
{
  // This is used to convert fields submitted using a form into a format suitable for
  // entry into the database.
  // First the slashes are removed, then some html entities are converted,
  // then the slashes are replaced.
  return addslashes(trim(convertHtmlEntities(stripslashes($str))));
}


function post2html($str)
{
  // for displaying fields in a form that have already been sent through post with magic-quotes on/added:
  return htmlSpecialChars(stripslashes($str), ENT_QUOTES);
}


function rec2db($rec)
{
  foreach ($rec as $key => $field)
    $rec[$key] = html2db($field);
  return $rec;
}


function db2html($str)
{
  // This is used to convert database strings into a format useful for displaying in form fields.
  // Basically just htmlSpecialChars with both single and double quotes converted to html entities.
  return htmlSpecialChars($str, ENT_QUOTES);
}

/**
 * Returns n left-most characters from $str.
 *
 * @param string $str
 * @param int $n
 * @return string
 */
function left($str, $n) {
  return substr($str, 0, $n);
}

/**
 * Returns n right-most characters from $str.
 *
 * @param string $str
 * @param int $n
 * @return string
 */
function right($str, $n) {
  return substr($str, -$n);
}

/**
 * Returns TRUE if $str begins with $substr.
 *
 * @param string $str
 * @param string $substr
 * @param bool $ignoreCase
 * @retrun bool
 */
function beginsWith($str, $substr, $ignoreCase = FALSE) {
  if ($ignoreCase) {
    $str = strtolower($str);
    $substr = strtolower($substr);
  }
  return left($str, strlen($substr)) == $substr;
}

/**
 * Returns TRUE if $str ends with $substr.
 *
 * @param string $str
 * @param string $substr
 * @param bool $ignoreCase
 * @retrun bool
 */
function endsWith($str, $substr, $ignoreCase = FALSE) {
  if ($ignoreCase) {
    $str = strtolower($str);
    $substr = strtolower($substr);
  }
  return right($str, strlen($substr)) == $substr;
}

/**
 * Will return a string in the form of "A, B, C & D", constructed from the supplied array.
 *
 * @param array $arr
 * @param string $conj
 * @return string
 */
function makeList($arr, $conj = "&") {
  if (count($arr) == 0) {
    return "";
  }
  elseif (count($arr) == 1) {
    return $arr[0];
  }
  elseif (count($arr) == 2) {
    return "{$arr[0]} $conj {$arr[1]}";
  }
  else {
    $first = array_shift($arr);
    return "$first, " . makeList($arr);
  }
}

function editDistance($s, $t) {
  // note - I did not realise there was a levenshtein function built into PHP
  // when I made this one!

  /*
  ORIGINAL CODE FROM http://www.merriampark.com/ld.htm
  '  Levenshtein distance (LD) is a measure of the similarity between two strings,
  '  which we will refer to as the source string (s) and the target string (t). The
  '  distance is the number of deletions, insertions, or substitutions required to
  '  transform s into t. For example, If s is "test" and t is "test", then LD(s,t) = 0,
  '  because no transformations are needed. The strings are already identical. If s is
  '  "test" and t is "tent", then LD(s,t) = 1, because one substitution
  '  (change "s" to "n") is sufficient to transform s into t. The greater
  '  the Levenshtein distance, the more different the strings are.
  '  Levenshtein distance is named after the Russian scientist Vladimir
  '  Levenshtein, who devised the algorithm in 1965. If you can't spell or pronounce
  '  Levenshtein, the metric is also sometimes called edit distance.
  */

  // Step 1
  $n = strlen($s);
  $m = strlen($t);
  if ($n == 0) {
    return $m;
  }
  if ($m == 0) {
    return $n;
  }

  // Step 2
  for ($i = 0; $i <= $n; $i++) {
    $d[$i][0] = $i;
  }
  for ($j = 0; $j <= $m; $j++) {
    $d[0][$j] = $j;
  }

  // Step 3
  for ($i = 1; $i <= $n; $i++) {
    $s_i = $s{$i - 1};  // the $i'th character of $s
    // Step 4
    for ($j = 1; $j <= $m; $j++) {
      $t_j = $t{$j - 1}; // the $j'th character of $t

      // Step 5
      $cost = $s_i == $t_j ? 0 : 1;

      // Step 6
      $d[$i][$j] = min($d[$i - 1][$j] + 1, $d[$i][$j - 1] + 1, $d[$i - 1][$j - 1] + $cost);
    }
  }

  // Step 7
  return $d[$n][$m];
}

/**
 * Returns str with only alphanumeric or hyphens, any other chars removed.
 *
 * @param string $str
 * @return string
 */
function makeDomainWord($str) {
  $out = "";
  for ($i = 0; $i < strlen($str); $i++) {
    $ch = $str{$i};
    if (ctype_alnum($ch) || ($ch == '-' && $out != ''))
      $out .= $ch;
  }

  // Trim any trailing hyphens:
  while ($out[strlen($out) - 1] == '-') {
    $out = left($out, strlen($out) - 1);
  }

  return strtolower($out);
}

/**
 * Detects if a string is HTML.
 * @param string $text
 * @return bool
 */
function is_html($text) {
  return $text != strip_tags($text);
}


/**
 * Normalizes break tags and trims any from the end.
 * @param string $text
 * @return string
 */
function trim_break_tags($text) {
  $text = str_replace(array('<br />', '<br/>', '<br>', '<BR />', '<BR/>', '<BR>'), '<br>', $text);
  $text = trim($text);
  while (endsWith($text, '<br>')) {
    $text = trim(left($text, strlen($text) - 6));
  }
  return $text;
}


////////////////////////////////////////////////////////////////////////////////
// Functions for converting variables into a string representation.

/**
 * Convert a variable to a string, usually for output to the browser.
 * A bit nicer than PHP's default var_dump(), var_export() or serialize().
 * 
 * @param mixed $value
 * @return string
 */
function var_to_string($value, $indent = 0, $objects = array(), $html = FALSE) {
  if (is_null($value)) {
    return 'NULL';
  }
  elseif (is_bool($value)) {
    return $value ? 'TRUE' : 'FALSE';
  }
  elseif (is_string($value)) {
    return "'" . htmlspecialchars(addslashes($value)) . "'";
  }
  elseif (is_array($value)) {
    return array_to_string($value, $indent, $objects, $html);
  }
  elseif (is_object($value)) {
    if (in_array($value, $objects, TRUE)) {
      return "((Circular Reference))";
    }
    else {
      $objects[] = $value;
      if ($value instanceof Query) {
        return dbg_sql($value);
      }
      else {
        return object_to_string($value, $indent, $objects, $html);
      }
    }
  }
  else {
    // int or float:
    return (string) $value;
  }
}

/**
 * Indents a flat JSON string to make it more human-readable.
 *
 * @param string $json The original JSON string to process.
 * @return string Indented version of the original JSON string.
 */
function format_json($json) {
    $result      = '';
    $pos         = 0;
    $strLen      = strlen($json);
    $indentStr   = '  ';
    $newLine     = "\n";
    $prevChar    = '';
    $outOfQuotes = TRUE;

    for ($i=0; $i<=$strLen; $i++) {

        // Grab the next character in the string.
        $char = substr($json, $i, 1);

        // Are we inside a quoted string?
        if ($char == '"' && $prevChar != '\\') {
            $outOfQuotes = !$outOfQuotes;
        
        // If this character is the end of an element, 
        // output a new line and indent the next line.
        }
        elseif (($char == '}' || $char == ']') && $outOfQuotes) {
            $result .= $newLine;
            $pos --;
            for ($j=0; $j<$pos; $j++) {
                $result .= $indentStr;
            }
        }
        
        // Add the character to the result string.
        $result .= $char;

        // If the last character was the beginning of an element, 
        // output a new line and indent the next line.
        if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
            $result .= $newLine;
            if ($char == '{' || $char == '[') {
                $pos ++;
            }
            
            for ($j = 0; $j < $pos; $j++) {
                $result .= $indentStr;
            }
        }
        
        $prevChar = $char;
    }

    return $result;
}
