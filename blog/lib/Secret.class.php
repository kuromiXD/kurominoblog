<?php 
class Secret{
	public $str1;
	function __construct($str1){
		$this->str1=$str1;
	}
	function __sercet($obj){
		$str2=$obj->make_shufflestr();
		setcookie('secret',$str2,0,'/');
		return md5($this->str1.$str2);
	}
	
}



 ?>