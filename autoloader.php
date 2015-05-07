<?php
class AutoLoader {
/*	public static $class_map = array(
		BASE_PATH => array(
			'c' => 'config_manager.php',
		),
	);
	static public  function load($class_name)
	{
		$class_name = strtolower($class_name);
		//如果有配置项，直接读配置项
		if(isset(self::$class_map[BASE_PATH][$class_name]))
		{
			require_once BASE_PATH . self::$class_map[BASE_PATH][$class_name];
			return true;
		}
		$file_map = C::get("class_map.$class_name", false);
		if(!empty($file_map) && is_string($file_map))
		{
			require_once $file_map;
			return true;
		}
		return false;
	}*/
}