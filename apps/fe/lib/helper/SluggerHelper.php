<?php


/**
 * Slugify title, replacing whitespace and a few other characters with dashes.
 *
 * Limits the output to alphanumeric characters, underscore (_) and dash (-).
 * Whitespace becomes a dash.
 *
 *
 * @param string $title The title to be sanitized.
 * @param string $raw_title Optional. Not used.
 * @param string $context Optional. The operation for which the string is sanitized.
 * @return string The sanitized title.
 */
function slugify($title, $raw_title = '', $context = 'display') {
        $title = strip_tags($title);
        // Preserve escaped octets.
        $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
        // Remove percent signs that are not part of an octet.
        $title = str_replace('%', '', $title);
        // Restore octets.
        $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);
        if (seems_utf8($title)) {
                if (function_exists('mb_strtolower')) {
                        $title = mb_strtolower($title, 'UTF-8');
                }
                $title = utf8_uri_encode($title, 200);
        }
        $title = strtolower($title);
        $title = preg_replace('/&.+?;/', '', $title); // kill entities
        $title = str_replace('.', '-', $title);
        if ( 'save' == $context ) {
                // nbsp, ndash and mdash
                $title = str_replace( array( '%c2%a0', '%e2%80%93', '%e2%80%94' ), '-', $title );
                // iexcl and iquest
                $title = str_replace( array( '%c2%a1', '%c2%bf' ), '', $title );
                // angle quotes
                $title = str_replace( array( '%c2%ab', '%c2%bb', '%e2%80%b9', '%e2%80%ba' ), '', $title );
                // curly quotes
                $title = str_replace( array( '%e2%80%98', '%e2%80%99', '%e2%80%9c', '%e2%80%9d' ), '', $title );
                // copy, reg, deg, hellip and trade
                $title = str_replace( array( '%c2%a9', '%c2%ae', '%c2%b0', '%e2%80%a6', '%e2%84%a2' ), '', $title );
        }
        $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
        $title = preg_replace('/\s+/', '-', $title);
        $title = preg_replace('|-+|', '-', $title);
        $title = trim($title, '-');
        return $title;
}


/**
 * Encode the Unicode values to be used in the URI.
 *
 * @param string $utf8_string
 * @param int $length Max length of the string
 * @return string String with Unicode encoded for URI.
 */
function utf8_uri_encode( $utf8_string, $length = 0 ) {
        $unicode = '';
        $values = array();
        $num_octets = 1;
        $unicode_length = 0;
        $string_length = strlen( $utf8_string );
        for ($i = 0; $i < $string_length; $i++ ) {
                $value = ord( $utf8_string[ $i ] );
                if ( $value < 128 ) {
                        if ( $length && ( $unicode_length >= $length ) )
                                break;
                        $unicode .= chr($value);
                        $unicode_length++;
                } else {
                        if ( count( $values ) == 0 ) $num_octets = ( $value < 224 ) ? 2 : 3;
                        $values[] = $value;
                        if ( $length && ( $unicode_length + ($num_octets * 3) ) > $length )
                                break;
                        if ( count( $values ) == $num_octets ) {
                                if ($num_octets == 3) {
                                        $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]) . '%' . dechex($values[2]);
                                        $unicode_length += 9;
                                } else {
                                        $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]);
                                        $unicode_length += 6;
                                }
                                $values = array();
                                $num_octets = 1;
                        }
                }
        }
        return $unicode;
}

/**
 * Checks to see if a string is utf8 encoded.
 *
 * NOTE: This function checks for 5-Byte sequences, UTF8
 *       has Bytes Sequences with a maximum length of 4.
 *
 * @author bmorel at ssi dot fr (modified)
 *
 * @param string $str The string to be checked
 * @return bool True if $str fits a UTF-8 model, false otherwise.
 */
function seems_utf8($str) {
        $length = strlen($str);
        for ($i=0; $i < $length; $i++) {
                $c = ord($str[$i]);
                if ($c < 0x80) $n = 0; # 0bbbbbbb
                elseif (($c & 0xE0) == 0xC0) $n=1; # 110bbbbb
                elseif (($c & 0xF0) == 0xE0) $n=2; # 1110bbbb
                elseif (($c & 0xF8) == 0xF0) $n=3; # 11110bbb
                elseif (($c & 0xFC) == 0xF8) $n=4; # 111110bb
                elseif (($c & 0xFE) == 0xFC) $n=5; # 1111110b
                else return false; # Does not match any model
                for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
                        if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
                                return false;
                }
        }
        return true;
}

?>