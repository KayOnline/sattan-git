<?php
/*
$arr = array(
	"name" 	  => "Kay",
	"age"     => 27, 
	"address" => array(
		"city"   => "GZ",
		"street" => "yueken Road."
	)
);

function array_change_key_case_recursive($arr, $case = CASE_UPPER) {
	$tmp = array_map(function($item) use ($case) {
		return is_array($item) ? array_change_key_case_recursive($item, $case) : $item;
	}, $arr);
	return array_change_key_case($tmp, $case);
}

var_dump(array_change_key_case_recursive($arr, CASE_LOWER));
*/

/*
function getPastTimestamp($offset) {
	$time = $offset . ' days';
	$now  = date_time_set(date_create("NOW"), 00, 00, 00);
	$past = date_sub($now, date_interval_create_from_date_string($time));
	return date_timestamp_get($past);
}
var_dump(getPastTimestamp(11));
var_dump(getPastTimestamp(1));
*/

/*
$spec_info = "";
$spec_name = unserialize('a:3:{i:26;s:12:"鼠标类型";i:1;s:6:"颜色";i:25;s:6:"背光";}');
$spec_goods_spec = unserialize('a:3:{i:80;s:12:"蓝牙鼠标";i:1;s:6:"白色";i:78;s:6:"蓝光";}');
$spec_info = serialize(array_combine($spec_name, $spec_goods_spec));
var_dump($spec_info);
*/

/*
$a = array(
	array(
		'id' => 11,
		'name' => 'aaa'
	),
	array(
		'id' => 12,
		'name' => 'bbb'
	)
);
$b = array(
	array(
		'id' => 11,
		'address' => 'ccc'
	),
	array(
		'id' => 12,
		'address' => 'ddd'
	)
);
foreach ($a as $key => $value) {
	$abc[$value['id']] = $value;
}
foreach ($b as $item) {
	$a_item = $abc[$item['id']];
	$b['ext'] =>
	#$sss[] = array_merge($abc[$item['id']], $item);
}
var_dump($sss);
*/

/*
$sweet = array('a' => 'apple', 'b' => 'banana');
$fruits = array('sweet' => $sweet, 'sour' => 'lemon');

function test_print($item, $key)
{
    echo "$key holds $item\n";
}

array_walk_recursive($fruits, 'test_print');
*/

/*$numbers = range(1, 20);
shuffle($numbers);
foreach ($numbers as $number) {
    echo "$number ";
}*/




require_once __DIR__ . "/init.php";

$dir = TPL_PATH;
echo $dir;
$tmpDir = rtrim($dir, '/\\') . DIRECTORY_SEPARATOR;
echo $tmpDir;
var_dump(is_dir($tmpDir));

var_dump(file_exists(TPL_PATH . 'index.tpl'));
