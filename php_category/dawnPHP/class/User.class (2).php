<?php
class User{
	
	function canRead($a_id){
		if($this->usergroup==3 || Article::getById($a_id)->u_id==$this->uid){
			return true;
		}
		return false;
	}
	function canEdit(){
		return true;
	}
}



/**
session_start();
echo '<pre>';
print_r($_SESSION);
Array
(
    [uid] => 2
    [username] => 王军亮
    [lastlogin] => 1449571811
    [usergroup] => 2
    [lastBrowseTime] => 1449571919
)
*/