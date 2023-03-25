<?php

if (! function_exists('array_intersect_key_recursive')) {
	function array_intersect_key_recursive($item, $allowed)
	{
		$result = array_intersect_key ( $item, $allowed );
        foreach($result as $key => $value) {
            if (is_array($value)) {
                $result[$key] = $this->array_intersect_key_recursive($value, $allowed[$key]);
            }
        }
        return $result;
	}
}

if (! function_exists('implode_array_keys')) {
    function implode_array_keys($glue, $items)
    {
        return implode($glue, array_keys($items));
    }
}