<?php

/**
 * $seperator use for strstr()
 */
if (! function_exists('replaceStrToChar')) {
	function replaceStrToChar($str, $replacedChr, $type = false)
	{
		if (empty($str)) return '';
		if ($type) {
			switch ($type) {
				case 'email':
					$arEmail = explode('@', $str);
					$str = $arEmail[0];
					$webEmail = $arEmail[1];
					break;
			}
		}

		$res = '';

		$len = mb_strlen($str);
		$i   = 0;
		while ($i <= $len) {
			$res .= $replacedChr;
		    $i++;
		}

		if (!empty($webEmail)) $res .= '@' . $webEmail;

		return $res;
	}
}

if (! function_exists('convertStrToSlug')) {
	function convertStrToSlug($string)
	{
	    return preg_replace('/[^A-Za-z0-9ก-๙\-]/u', '-', str_replace('&', '-and-', $string));
	}
}

if (! function_exists('removeFileExt')) {
	function removeFileExt($file)
	{
		return preg_replace('/\.[^.\s]{3,4}$/', '', $file);
	}
}

if (! function_exists('sanitizeFileName')) {
	function sanitizeFileName($fileName)
	{
		return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
	}
}