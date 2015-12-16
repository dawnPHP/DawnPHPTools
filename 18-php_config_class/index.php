<a href='get.php' target="_blank">get</a> | 
<a href='set.php' target="_blank">set</a>
<hr>

<pre>
//config.php
return array(
	'name'=>'wjl',
	'sex'=>'male'
); 


</pre>
<hr>

<?php 
include('Config.class.php');
//get
$c=new Config();
echo $c->get('name');
echo $c->get('height');


echo '<hr>';//set 
$c->set('name','jimmy2');
echo $c->get('name');

?>