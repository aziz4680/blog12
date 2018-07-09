<?php 

namespace System;

/**
 * 
 */
class Application 
{
	/**
	* Container
	*
	* @var array
	*/
	private $container = [];
	/**
	*Constractor
	*
	* @param \System\File $file
	*/
	
	public function __construct(File $file)
	{
		$this->share('file',$file);
		$this->registerClasses();
		$this->loadHelpers();
		pre($this->file);
	}

	/**
	* Register classes in spl auto load register
	*
	* @return void
	*/
	public function registerClasses()
	{
		spl_autoload_register([$this,'load']);
	}

	/**
	* load class through autoloading
	*
	*@param string $class
	*@return void
	*/
	public function load($class)
	{
		if (strpos($class,'App') === 0) {
			$file = $this->file->to($class .'.php');
		} else {
			// get class from vendor
			$file = $this->file->toVendor($class . '.php');
		}

		if ($this->file->exists($file)) {
			$this->file->require($file);
		}
	}
	/**
	* Load helpers file
	*
	* @return void 
	*/

	private function loadHelpers()
	{
		$this->file->require($this->file->toVendor('helpers.php'));
	}

	/**
	* Share the fiven key|value Through Application
	*
	* @param string $key
	* @param mixed $value
	* @return mixed
	*/

	public function share($key, $value)
	{
		$this->container[$key] = $value;

	}

	/**
	* determine if ther given key is an alias to core class
	*
	*@param string $alias
	*@return bool
	*/
	private function isCoreAlias($alias)
	{
		$coreClasses = $this->coreClasses();
		return isset($coreClasses[$alias]);
	}

	/**
	* Create new object for the core class bases on the given alias
	*
	*@param string $alias
	*@return object
	*/
	private function createNewCoreObject($alias)
	{
		$coreClasses = $this->coreClasses();
		$object = $coreClasses[$alias];
		return new $object($this);
	}


	/**
	* Get shared value dynamically
	*
	*@param string $key
	*@return mixed
	*/
	public function __get($key)
	{
		return $this->get($key);
	}

	/**
	* get shared value
	*
	*@param STRING $KEY
	*@return mixed
	*/
	public function get($key){
		if (!$this->isSharing($key)) {
			if ($this->isCoreAlias($key)) {
				$this->share($key,$this->createNewCoreObject($key));
			} else {
				die($key . ' not found in application container');
			}
			return $this->container[$key];
		}
	}
		
	/**
	* Get all core classes with its aliases
	*
	*@return array
	*/

	 private function coreClasses()
	{
		return [
			'request' => 'System\\Http\\Request',
			'response' => 'System\\Http\\Response',
			'session' => 'System\\Session',
			'cookie' => 'System\\Cookie',
			'load' => 'System\\Loader',
			'html' => 'System\\Html',
			'db' => 'System\\Database',
			'view' => 'System\\View\\ViewFactory', 

		];
	}

	/**
	* determine if the given key is shared through application
	*
	*@param STRING $KEY
	*@return bool
	*/
	public function issharing($key)
	{
		return isset($this->container[$key]);
	}
}