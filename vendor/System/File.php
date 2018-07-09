<?php 

namespace System;

/**
 * 
 */
class File 
{
	/**
	* Directory Separator
	*
	* @const string
	*/

	const DS = DIRECTORY_SEPARATOR;
	
	/**
	*Root Path
	*
	* @var string
	*/
	private $root;

	/**
	* constractor
	*
	* @param string $root
	*/
	
	public function __construct($root)
	{
		$this->root = $root;
	}

	/**
	* determine wether the given file path exists
	*
	*@param string $file
	*@return bool
	*/
	public function exists($file){
		return file_exists($file);
	}

	/**
	* Require The given file 
	*
	*@param string $file
	*@return void
	*/
	public function require($file){
		require $file;

	}

	/**
	* generate full path to the given path in vendor folder
	*
	*@param string $path
	*@return string
	*/
	public function toVendor($path){
		return $this->to('vendor/' . $path);
	}

	/**
	* generate full path to the given path
	*
	*@param string $path
	*@return string
	*/
	public function to($path){
		return $this->root . static::DS . str_replace(['/','\\'], static::DS, $path);
	}

}