<?php

use Illuminate\Support\Facades\Date;

if (! function_exists('carbonToThaiDate')) {
	function carbonToThaiDate($date, $format = 'D MMM YYYY')
	{
		return $date->locale('th_TH')->isoFormat($format);
	}
}

if (! function_exists('mysqlDateToThaiDate')) {
	function mysqlDateToThaiDate($date)
	{
		return Date::parse($date)->locale('th_TH')->isoFormat('D MMM YYYY');
	}
}

if (! function_exists('thaiFormatToMysqlFormat')) {
	function thaiFormatToMysqlFormat($thaiDate)
	{
		return Date::createFromFormat('d/m/Y', $thaiDate)->format('Y-m-d');
	}
}

if (! function_exists('mysqlFormatToThaiFormat')) {
	function mysqlFormatToThaiFormat($mysqlDate)
	{
		return Date::parse($mysqlDate)->format('d/m/Y');
	}
}