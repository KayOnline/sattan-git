<?php
/**
 * 配置管理器
 */
class C
{
	//公共的配置文件
	public static $conf = array();

	//环境下个性化的配置文件
	public static $profile_conf = array();

	//主要是对于多维数组节省遍历成本
	public static $cache_conf;
	

	/* 
	 *  加载配置，并让配置从可视化的友好变为使用的友好
	 */
	public static function loadConfig()
	{
		//初始化服务器类型
		$server_type = get_cfg_var('server_type');
		$conf_file = CONF_PATH . $server_type. ".php";
		if(file_exists($conf_file) === false)
		{
			Log::err("can not find config file ." .$conf_file);
			return false;
		}
		require_once $conf_file;
		self::$conf = $conf;
		self::$profile_conf = !empty($profile_conf) ? $profile_conf : array();
		return true;
	}

	/**
	 * 读取存储配置
	 *
	 * @param string $key 配置标识
	 *
	 * @return mix/false
	 */

	public static function get($key, $log = true)
	{
		if(empty(self::$conf))
		{
			self::loadConfig();
		}
		//先从cache里读下看有木有
		if(isset(self::$cache_conf[$key]))
		{
			return self::$cache_conf[$key];
		}

		$key_array = explode(".", $key);
		$count_key = count($key_array);
		$find_value = null;
	
		//从个性化的配置变量里读看有木有
		if(!empty(self::$profile_conf))
		{
			foreach($key_array as $conf_key)
			{
				if(isset($find_value[$conf_key]))
				{
					$find_value = $find_value[$conf_key];
					$count_key--;
				}
				else if(isset(self::$profile_conf[$conf_key]))
				{
					$count_key--;
					$find_value = self::$profile_conf[$conf_key];
				}			
			}
		}
		if(isset($find_value) && $count_key == 0)
		{
			self::$cache_conf[$key] = $find_value;
			return $find_value;
		}

		//如果找不到，再从公共的配置变量里读
		$count_key = count($key_array);
		$find_value = null;
		foreach($key_array as $conf_key)
		{
			if(isset($find_value[$conf_key]))
			{
				$find_value = $find_value[$conf_key];
				$count_key--;
			}
			else if(isset(self::$conf[$conf_key]))
			{
				$count_key--;
				$find_value = self::$conf[$conf_key];
			}			
		}

		if(isset($find_value) && $count_key == 0)
		{
			self::$cache_conf[$key] = $find_value;
			return $find_value;
		}
		$log && Log::info("config not defined,key " . $key);
		return false;
		}

	//设置配置文件值
	public static function set($key, $value)
	{
		if(empty(self::$conf))
		{
			self::loadConfig();
		}
		if(strpos($key, ".") !== false)
		{
			$key_array = explode(".", $key);						
			$last_key = end($key_array);
			$ref_value = &self::$conf;
			foreach($key_array as $tmp_key)
			{							
				if($tmp_key != $last_key)
				{
					$ref_value = &$ref_value[$tmp_key];								
				}
			}
			$ref_value[$tmp_key] = $value;
		}
		else
		{
			$conf[$key] = $value;
		}
		return true;
	}
}
