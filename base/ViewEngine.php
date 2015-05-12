<?php
class ViewEngine {

	public static $engine;
	
	public static function init() {
		self::$engine = new Dwoo\Core();
		self::$engine->setTemplateDir(TPL_PATH);
		self::$engine->setCompileDir(TPL_PATH . 'compiled');
		self::$engine->setCacheDir(TPL_PATH . 'cache');
	}


}