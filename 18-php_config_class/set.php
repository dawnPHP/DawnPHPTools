<?php
$arr=array(
	'name'=>'wjl',
	'sex'=>'male',
	'height'=>'180'
);

array2config($arr);


	//数组写入配制文件
	function array2config($arr){
		$str='<?php'.PHP_EOL.
				'return ' . var_export($arr,TRUE).';';
		file_put_contents('config.php', $str);
	}
?>