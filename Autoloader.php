<?php
/*class AutoLoader {
	public static $class_map = array(
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
	}
}
spl_autoload_register("AutoLoader::load", true, true);*/

class Autoloader {

	public static $class_file_map = array();

	public static $include_dirs = array(ROOT_PATH);
	public static $exclude_dirs = array();

	public static $map_file = "class_map.php";

	/**
	 * 
	 */
	public static function init() {

		$new_class_file_map = array();
		$old_class_file_map = array();

		$new_class_file_map = self::scanDirs(self::$include_dirs, self::$exclude_dirs);

		$diff = array_diff_assoc($new_class_file_map, $old_class_file_map);
		$need_update = !empty($diff);
		if ($need_update) {
			self::genMapFile($new_class_file_map);
			self::$class_file_map = $new_class_file_map;
		}
		return true;
	}

	/**
	 *
	 */
	public static function load($class_name) {
		$class_path = self::$class_file_map[$class_name];
		if (file_exists($class_path)) {
			require_once($class_path);
		}
		return true;
	}

	/**
	 *
	 */
	public static function genMapFile($new_class_file_map) {
		$buf = "<?php\n\$conf['class_map'] = array(\n";
		foreach($new_class_file_map as $class => $file)
		{
			$file = str_replace(ROOT_PATH, '', $file);
			$buf .= "\t'". $class . "' => ROOT_PATH . '" . $file . "',\n";
		}
		$buf .= ");\n";
		file_put_contents(CONF_PATH . self::$map_file, $buf);
	}

	/**
	 * 
	 */
	public static function scanDirs($include_dirs, $exclude_dirs) {
		$tmp = array();
		foreach($include_dirs as $dir) {
			$tmp = array_merge($tmp, self::scanDir($dir));
		}
		return $tmp;
	} 

	/**
	 * 
	 */
	public static function scanDir($dir) {
		$data = array();
		if (is_dir($dir)) {
		    if ($dh = opendir($dir)) {
		        while (($file_name = readdir($dh)) !== false) {

		        	if ($file_name == '.')  continue;
		        	if ($file_name == '..') continue;
		        	
		        	$file_type  = filetype($dir . $file_name);
		        	$file_path  = $dir . $file_name;

		        	switch ($file_type) {
		        		case 'dir':
		        			$tmp_data = self::scanDir($file_path . DIRECTORY_SEPARATOR);
		        			$data = array_merge($data, $tmp_data);
		        			break;
		        		case 'file':
				        	if (!preg_match('/.php$/mi', $file_name)) break;
		        			$class_name = self::getClassNameFromFile($file_path);
		        			if (empty($class_name)) break;
	        				$data[$class_name] = $file_path;
		        			break;
		        		default:
		        			break;
		        	}
		        }
		        closedir($dh);
		    }
		}
		return $data;
	}

	/**
	 * 
	 */
	public static function getClassNameFromFile($file_name) {
		$params = array(
			'content' => file_get_contents($file_name),
			'pattern' => "/^class\s*([a-zA-z]*)\s*/mi",
			'match'	  => array(),
		);
		preg_match($params['pattern'], $params['content'], $params['match']);
		return !empty($params['match'][1]) ? $params['match'][1] : "";
	}

}
spl_autoload_register('Autoloader::load', true, true);