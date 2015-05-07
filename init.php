<?php
//定义路径变量
define('ROOT_PATH', __DIR__ . "/");
define('BASE_PATH', ROOT_PATH . "base/");
define('COMM_PATH', ROOT_PATH . "common/");
define('INTERFACE_PATH',ROOT_PATH . "interface/");
define('LIB_PATH', ROOT_PATH . "lib/");
define('CONF_PATH', ROOT_PATH . "conf/");
define('WORKER_PATH', ROOT_PATH . "worker/");
define('LOG_PATH', "/data/weblog/business/");
define('XHPROF_PATH',LIB_PATH . "xhprof/");
define('STATIC_PATH',ROOT_PATH.'static/');
define('TPL_PATH',ROOT_PATH.'static/tpl/');

// 类加载器
require_once __DIR__. "/autoloader.php";

// DWOO模版
require_once 'phar://lib/dwoo.phar';

// 公共函数
//require_once COMM_PATH .'func.php';

//环境初始化
//Env::registerFunc(ENV_FUNC_UNPACK,array('ReqManager','unpackHttp'));
//Env::registerFunc(ENV_FUNC_SHUTDOWN,array('proxy','shutdownHandler'));
//Env::registerFunc(ENV_FUNC_ERRORHANDLE,array('Log', 'phperr'));


