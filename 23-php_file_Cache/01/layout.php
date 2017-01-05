<!-- templates/layout.php -->
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title ?></title>
    </head>
    <body>
	要点：ob_start();开启缓存；文件部分暂时输出到缓存；<br>
	$content = ob_get_clean(); 清除缓存并保存到变量$content中。<br>
基于这两个函数可以实现基于文件的缓存。可以实现带“继承”的模板系统。
<hr>
        <?php echo $content ?>
    </body>
</html>