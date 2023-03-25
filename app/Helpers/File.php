<?php

if (! function_exists('getImageFileWithBlank')) {
	function getImageFileWithBlank($file)
	{
		if (empty($file)) {
			return asset('images/no-image.jpg');
		}

	    if (filter_var($file, FILTER_VALIDATE_URL)) { 
	        return $file;
	    }
	    
	    return asset('storage/' . $file);
	}
}

if (! function_exists('getImageFileWithDefault')) {
	function getImageFileWithDefault($defaultFile, $file)
	{
		if (! empty($file)) {
			return asset('storage/' . $file);
		}

	    if (filter_var($defaultFile, FILTER_VALIDATE_URL)) { 
	        return $defaultFile;
	    }
	    
	    return asset('storage/' . $defaultFile);
	}
}