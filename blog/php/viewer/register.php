<?php
require("../../lib/init.php");
require(blog."/lib/mysql.php");
require(blog."/lib/function.php");
require(blog."/lib/Makeshufflestr.class.php");
require(blog."/lib/Secret.class.php");
class _Makeshufflestr implements Makeshufflestr{
		function make_shufflestr($strnum=6){
			$str=str_shuffle('QWERTYUIOPASDFGHJKLZXCVBNM1234567890mnbvcxzlkjhgfdsapoiuytrewq');
	    	$str=substr($str,0,$strnum);
	    	return $str;
		}
	}
	$obj=new _Makeshufflestr();
if(empty($_POST)){
	require("../../html/viewer/register.html");
}
else{
	$user_info['username']=trim($_POST['username']);
	$user_info['password']=trim($_POST['password']);
	if($user_info['username']==''){
		echo "<script>alert('用户名不能为空！')</script>";
		echo '<meta http-equiv="refresh" content="0;url=register.php">';
		exit();
	}
	$patt = '/^[\x4E00-\x9FA5\xf900-\xfa2d\w]{1,8}$/u'; 
    if(!preg_match_all($patt, $user_info['username'])){
    	echo "<script>alert('用户名不符合规则！')</script>";
		echo '<meta http-equiv="refresh" content="0;url=register.php">';
		exit();
    }
	if($user_info['password']==''){
		echo "<script>alert('密码不能为空！')</script>";
		echo '<meta http-equiv="refresh" content="0;url=register.php">';
		exit();
	}
	$patt='/^[a-zA-Z0-9]{6,12}$/';
	if(!preg_match_all($patt, $user_info['password'])){
    	echo "<script>alert('密码不符合规则！')</script>";
		echo '<meta http-equiv="refresh" content="0;url=register.php">';
		exit();
    }
	if(getexist('user',$user_info['username'],'username')!=0){
		echo "<script>alert('该用户名已存在！')</script>";
		echo '<meta http-equiv="refresh" content="0;url=register.php">';
		exit();
	}
	$user_info['md5']=$obj->make_shufflestr();
	$user_info['password']=md5($user_info['password'].$user_info['md5']);

	if(!do_sql('user',$user_info)){
		echo "<script>alert('注册失败！');</script>";
		echo '<meta http-equiv="refresh" content="0;url=register.php">';
		exit();
	}
	else{
		$obj1=new Secret($user_info['username']);
		setcookie("username",$user_info['username'],0,'/');
		setcookie('secretnumber',$obj1->__sercet($obj),0,'/');
		setcookie("islogin",1,0,'/');
		echo "<script>alert('注册成功！');</script>";
		echo '<meta http-equiv="refresh" content="0;url=../../index.php">';
	}

}



 ?>