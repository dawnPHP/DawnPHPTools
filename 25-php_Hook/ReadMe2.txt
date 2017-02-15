插件机制，可后台设置是否启用
http://baijunyao.com/article/85



1.
├─plugin // 插件目录
│  ├─plugin1 // 插件1
│  │  ├─config.php // 插件1的配置项
│  │  ├─index.php // 插件1的程序处理内容
│  ├─plugin2
│  │  ├─config.php
│  │  ├─index.php
│  ├─plugin3
│  │  ├─config.php
│  │  ├─index.php
│  ├─mylog   //插件名字不一样也可以，但是内部结构必须有至少如下2个文件
│  │  ├─config.php
│  │  ├─index.php
│  ├─...
│  ├─...
├─index.php // 业务逻辑


2.
插件配置项代码：
<?php 
 return array (
  'status' => 1, // 定义状态 1表示开启  0表示关闭
  'title' => '发送短信', // 插件的名称
);

插件的内容：
<?php
 
 
Hook::add('plugin1',function(){
    echo '发送短信的内容<br />';
});

3.业务逻辑 /index.php 
<?php
 
class Test{
    public function index(){
        // 用户注册成功
             
        // 获取全部插件
        $pluginList=scandir('./plugin/');
        // 循环插件 // 排除. ..
        foreach ($pluginList as $k => $v) {
             
            if ($v=='.' || $v=='..') {
                unset($pluginList[$k]);
            }
        }
        echo "简易后台管理<hr>";
        // 插件管理
        foreach ($pluginList as $k => $v) {
            // 获取配置项
            $config=include './plugin/'.$v.'/config.php';
            $word=$config['status']==1 ? '点击关闭' : '点击开启';
            echo $config['title'].'<a href="./index.php?change='.$v.'">'.$word.'</a><br />';
        }
        echo '<hr>';
        // 输出插件内容
        foreach ($pluginList as $k => $v) {
            // 获取配置项
            $config=include './plugin/'.$v.'/config.php';
            if ($config['status']==1) {
                include './plugin/'.$v.'/index.php';
                // 运行插件
                Hook::run($v);
            }
        }
 
        // 前往网站首页
    }
}
 
// 插件类
class Hook{
    // 注册添加插件
    public static function add($name,$func){
        $GLOBALS['hookList'][$name][]=$func;
    }
 
    // 执行插件
    public static function run($name,$params=null){
        foreach ($GLOBALS['hookList'][$name] as $k => $v) {
            call_user_func($v,$params);
        }
    }
}
 
// 更改插件状态
if (isset($_GET['change'])) {
    // 获取到配置项
    $config=include './plugin/plugin'.substr($_GET['change'],-1).'/config.php';
    // 如果是开启 那就关闭 如果是关闭 则开启
    $config['status']=$config['status']==1 ? 0: 1;
    // 将更改后的配置项写入到文件中
    $str="<?php \r\n return ".var_export($config,true).';';
    file_put_contents('./plugin/'.$_GET['change'].'/config.php', $str);
    header('Location:./');
}
 
$test=new Test();
$test->index();



没错；这就是插件的思想；
当然这只是一个超级简单的示例；
完整的插件机制要包括插件的类型、数据库、审核等等；

如果使用过wordpress或者国内的discuz；
你就会发现一个好的程序并不仅仅是自身多么优秀；
而且重要的就是设计的扩展性有多好；能多方便的让大家去扩展它的功能；

想对插件深入研究的话；建议去阅读wordpress、discuz的源代码；