<?php 

namespace System;

/**
 * 
 */
class Session 
{
	private $app;
	
	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function set($key,$value)
	{
		echo $key . '=>' . $value;
	}
}