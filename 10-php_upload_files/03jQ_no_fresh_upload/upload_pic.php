<?php
$tmp_name = $_FILES['img']['tmp_name']; //echo '<pre>';print_r($_FILES);die();
$imgName = $_FILES['img']['name'];
move_uploaded_file($tmp_name, './upload/'.$imgName);
$img = './upload/'.$imgName;


echo '<div id= "pic">' . $img . '</div>';


/*
重点:

1.$_FILE全局超级变量可以接收到POST过来的文件，HTML input的name就是$_FILE['name']
2.接下来可以做很多处理，如判断是不是图片，图片大小....
3.move_uploaded_file($tmp,$location)函数把图片移动到相应的路径中去，$tmp指的是文件的临时
地址，$location指的是文件移动收的相对路径(包含文件名的路径!)
4.想办法在这个处理页面中找一个地方安放一下处理好的图片。
< div id= "pic"><?php echo $img; ?></div>

就这样，我们就可以很轻易的把一个图片异步上传并且立即显示到前台页面中。
*/
?>