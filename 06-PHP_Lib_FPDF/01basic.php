<?php
#引入库
require('Fpdf17/fpdf.php');

#实例化对象
$pdf = new FPDF();
//$pdf = new FPDF('L','in','Letter');//初始化时定义页面方向（横向L、纵向P，默认纵向）、度量单位（点pt、毫米mm、厘米cm和英尺in，默认为毫米）、页面大小（A3/A4/A5、信封Letter、公文Legal，默认A4）

#增加一页
$pdf->AddPage();
#设置字体
$pdf->SetFont('Arial','B',16);
#靠左对齐，除了前三个参数，其余都可默认。
$pdf->Cell(10,10,'Hello World! Dawn~',0,0,"L");
#设置起始坐标
$pdf->SetX(90);
#设置右对齐
$pdf->Cell(90,10,'Powered by FPDF.',1,0,'R');


#第二页
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,30,'More info: Fpdf17/tutorial/tuto1.htm');
/*
Cell(float w[, float h[, string txt[, mixed border[, int lin[, string align[, int fill[, mixed link]]]]]]])
分别可以设置单元宽度w、高度h、所包含的文本txt
可选参数：边框border,换行控制ln、文本对齐方式align、单元格填充fill、文本的url
*/
$pdf->SetX(100);
$pdf->SetFont('Arial','B',30);
$pdf->Cell(100,20,'Github.com',1,0,'C',0,'http://github.com');



$pdf->Output();
//-------------------------------------------


?>