<?php

if (!function_exists('pre')) {
	/**
	*visualiza the fiven variable in borwser
	*
	*@param mixed $var
	*@return void
	*/
	function pre($var)
	{
		echo "<pre>";
		print_r($var);
		echo "</pre>";
	}
}