<?php

function json_indent($json) {
	$result = '';
	$pos = 0;
	$strLen = strlen($json);
	$indentStr = "\t";
	$newLine = "\n";

	for ($i = 0; $i < $strLen; $i++) {
		// Grab the next character in the string.
		$char = $json[$i];

		// Are we inside a quoted string?
		if ($char == '"') {
			// search for the end of the string (keeping in mind of the escape sequences)
			if (!preg_match('`"(\\\\\\\\|\\\\"|.)*?"`s', $json, $m, null, $i))
				return $json;

			// add extracted string to the result and move ahead
			$result .= $m[0];
			$i += strLen($m[0]) - 1;
			continue;
		}
		else if ($char == '}' || $char == ']') {
			$result .= $newLine;
			$pos --;
			$result .= str_repeat($indentStr, $pos);
		}

		// Add the character to the result string.
		$result .= $char;

		// If the last character was the beginning of an element,
		// output a new line and indent the next line.
		if ($char == ',' || $char == '{' || $char == '[') {
			$result .= $newLine;
			if ($char == '{' || $char == '[') {
				$pos ++;
			}

			$result .= str_repeat($indentStr, $pos);
		}
	}

	return $result;
}

function json_get_error() {
	switch (json_last_error()) {
		case JSON_ERROR_NONE:
		return 'No json errors or object is empty.';
		case JSON_ERROR_DEPTH:
		return 'Maximum stack depth exceeded.';
		case JSON_ERROR_STATE_MISMATCH:
		return 'Underflow or the modes mismatch.';
		case JSON_ERROR_CTRL_CHAR:
		return 'Unexpected control character found.';
		case JSON_ERROR_SYNTAX:
		return 'Syntax error, malformed JSON.';
		case JSON_ERROR_UTF8:
		return 'Malformed UTF-8 characters, possibly incorrectly encoded.';
		default:
		return 'Unknown error.';
	}
}

?>