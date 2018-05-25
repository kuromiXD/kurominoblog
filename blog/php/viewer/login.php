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
    static $shuff_string;
    $url_identi_code=make_identi_code($obj);
	require("../../html/viewer/login.html");
	
}
else{
	session_start();
	$user_info['username']=trim($_POST['username']);
	$user_info['password']=trim($_POST['password']);
	$ic=trim($_POST['identi_code']);
	if($user_info['username']==''){
		echo "<script>alert('用户名不能为空！')</script>";
		echo '<meta http-equiv="refresh" content="0;url=login.php">';
		exit();
	}
	setcookie('preusername',$user_info['username'],0,'');
	if($user_info['password']==''){
		echo "<script>alert('密码不能为空！')</script>";
		echo '<meta http-equiv="refresh" content="0;url=login.php">';
		exit();
	}
	if($ic==''){
		echo "<script>alert('未输入验证码！')</script>";
		echo '<meta http-equiv="refresh" content="0;url=login.php">';
		exit();
	}
	if(getexist('user',$user_info['username'],'username')==0){
		echo "<script>alert('该用户名不存在！')</script>"; 
		echo '<meta http-equiv="refresh" content="0;url=login.php">';
		exit();
	}
	if($ic!=strtolower($_SESSION['identi_code'])){
		echo "<script>alert('验证码错误！')</script>"; 
		echo '<meta http-equiv="refresh" content="0;url=login.php">';
		exit();
	}
	$sql="select md5 from user where username='$user_info[username]'";
	$md5=get_one($sql);
	$password=md5($user_info['password'].$md5);
    if(getexist('user',$password,'password')==0){
    	echo "<script>alert('密码错误！')</script>";
	 	echo '<meta http-equiv="refresh" content="0;url=login.php">';
		exit();
    }
    else{
    	setcookie('preusername','',time()-1,'/');
    	$obj1=new Secret($user_info['username']);
    	setcookie('username',$user_info['username'],0,'/');
    	setcookie('secretnumber',$obj1->__sercet($obj),0,'/');
    	setcookie('islogin',1,0,'/');
    	echo "<script>alert('登录成功！即将跳转首页......')</script>";
    	echo '<meta http-equiv="refresh" content="0;url=../../index.php">';
    }

}


 ?>