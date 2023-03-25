<?php

if (! function_exists('get_custom_class')) {
	function get_custom_class($prefix, $class)
	{
		$objClass = $prefix . ucfirst($class);
        return get_class(new $objClass());
	}
}
