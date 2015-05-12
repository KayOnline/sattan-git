<?php
class Env
{
	public static $current_appversion_no;
	public static $current_appname;
	public static $current_appversion_plat;
	public static $allow_appname;
	public static $disallow_appname;
	public static $deal_map = array();
	public static $class_prefix = "";
	public static $class_suffix = "Task";
	public static $default_class_name = "index";
	public static $default_method_name = "index";
	public static $server_type = "idc";

	private static $init_func_arr = array();
	private static $un_pack = array();
	private static $pack = array();

	public static function init()
	{		
		mb_internal_encoding('utf-8');
		self::$server_type = get_cfg_var('server_type');
		if(self::$server_type == SERVER_TYPE_DEV)
		{
			GenerClassMap::scanAndGener();
			$all_class = C::get('class_map');
			$monitor_before =  function (AopJoinPoint $joinpoint)
			{
				$point = $joinpoint->getPointcut();
				$args = $joinpoint->getArguments();			
				self::$deal_map[$point]['para'] = preg_replace("/\s*/", var_export($args, true));
				self::$deal_map[$point]['name'] = $point;
			};

			$monitor_after =  function (AopJoinPoint $joinpoint)
			{
				$point = $joinpoint->getPointcut();
				$ret = $joinpoint->getReturnedValue();			
				self::$deal_map[$point]['ret'] = preg_replace("/\s*/", var_export($ret, true));
				file_put_contents("/tmp/dao.log", implode("\t", self::$deal_map), FILE_APPEND);
			};
			foreach($all_calss as $tmp_value)
			{
				if(strpos($tmp_value, 'dao') === strlen($tmp_value) - 3)
				{

					aop_add_before($tmp_value . "->*", $monitor_dao);
				}
			}
		}

		foreach(self::$init_func_arr as $key => $value)
		{
			call_user_func_array($value['func'],$value['params']);
		}

		//允许运行的域名黑白名单配置
		$allow_appname = get_cfg_var('allow_appname');
		if(!empty($allow_appname))
		{
			self::$allow_appname = explode(",", $allow_appname);
		}
		$disallow_appname = get_cfg_var('disallow_appname');
		if(!empty($disallow_appname))
		{
			self::$disallow_appname = explode(",", $disallow_appname);
		}

		//Log的一些环境变量初始化
		Log::$writeLogLevel = C::get('log_write_file_level');

		//init evnet listener
		$all_event = C::get('event');
		foreach($all_event as $event_name => $callback_list)
		{
			$callback_list = is_string($callback_list) ? array($callback_list) : $callback_list;
			foreach($callback_list as $callback)
			{
				Event::listen($event_name, $callback);
			}
		}
		
		$all_event = C::get('async_event');
		foreach($all_event as $event_name => $callback_list)
		{
			$callback_list = is_string($callback_list) ? array($callback_list) : $callback_list;
			foreach($callback_list as $callback)
			{
				Event::listen($event_name, $callback);
			}
		}
		require_once BASE_PATH . 'alias.php';
		Log::unshift('server type: '. self::$server_type, '', -1);
	}

	public static function getUnpack()
	{
		return self::$un_pack;
	}

	public static function getPack()
	{
		return self::$pack;
	}

	public static function registerFunc()
	{
		$all_params = func_get_args();
		$type = $all_params[0];
		$func_name = $all_params[1];
		$params = array_slice($all_params,2);
		switch($type)
		{
			case ENV_FUNC_INIT:
				self::$init_func_arr[] = array('func' => $func_name,'params' => $params);
				break;
			case ENV_FUNC_UNPACK:
				self::$un_pack = $func_name;
				break;
			case ENV_FUNC_PACK:
				self::$pack = $func_name;
				break;
			case ENV_FUNC_SHUTDOWN:
				register_shutdown_function($func_name);
				break;
			case ENV_FUNC_ERRORHANDLE:
				set_error_handler($func_name);
				break;

		}
	}

	public static function setReqContext($current_appname, $current_appversion_no = 1, $current_appversion_plat = "")
	{
		self::$current_appname = $current_appname;
		self::$current_appversion_no = $current_appversion_no;
		return true;
	}

	//预留的var_dump函数
	public static function var_dump_debug()
	{

	}
}