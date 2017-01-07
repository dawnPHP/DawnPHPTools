<?php 

//fputcsv写入文件。
$list = array(
	"1,2016/1/5,香烟,10,50",
	"2,2016/2/18,香烟2,20,30",
	"3,2016/7/23,香烟3,30,20",
	"4,2016/12/9,香烟4,40,10",
);

$file = fopen("contacts.csv","w");

foreach ($list as $line){
  fputcsv($file,split(',',$line));
}

fclose($file);

echo 'ok';