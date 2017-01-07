<?php

//fgetcsv从csv文件读出。
$row = 1;
$handle = fopen("contacts.csv","r");
while ($data = fgetcsv($handle, 1000, ",")) {
    $num = count($data);
    //echo "<p> $num fields in line $row: <br> ";
    $row++;
	
	$item="";
    for ($c=0; $c < $num; $c++) {
        //echo $data[$c] . ", ";
		$item .= "'".$data[$c]."',";
    }
	$sql="insert into order(id,date,name,price,quantity) values(".$item.");";
	echo $sql .'<br>';
}
fclose($handle);

echo '<hr>got.';