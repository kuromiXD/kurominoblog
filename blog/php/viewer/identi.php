<?php  
require("../../lib/init.php");
require(blog."/lib/function.php");
require(blog."/lib/Makeshufflestr.class.php");
class _Makeshufflestr implements Makeshufflestr{
		function make_shufflestr($strnum=6){
			$str=str_shuffle('QWERTYUIOPASDFGHJKLZXCVBNM1234567890mnbvcxzlkjhgfdsapoiuytrewq');
	    	$str=substr($str,0,$strnum);
	    	return $str;
		}
	}
	$obj=new _Makeshufflestr();
     
     $url_identi_code1=make_identi_code($obj);
     echo $url_identi_code1;

?>