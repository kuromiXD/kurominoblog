<?php
   if (@$_COOKIE['username']!='admin') {
    	echo "<script>alert('非管理员禁止入内！')</script>";
    	echo "<meta http-equiv='refresh' content='0;url=../../index.php'>";
    	exit();
    }
require("../../lib/init.php");
require(blog."/lib/mysql.class.php");
require(blog."/lib/function.php");
require(blog."/lib/Makethumb.class.php");
require(blog."/lib/Createdir.class.php");
	class _Makeshufflestr implements Makeshufflestr{
		function make_shufflestr($strnum=6){
			$str=str_shuffle('QWERTYUIOPASDFGHJKLZXCVBNM1234567890mnbvcxzlkjhgfdsapoiuytrewq');
	    	$str=substr($str,0,$strnum);
	    	return $str;
		}
	}
	class _Createdir implements Createdir{
		function create_dir(){
			$upload_path="./upload/".date("Y/m/d");
			$r_upload_path=blog.$upload_path;
			if(is_dir($r_upload_path)||mkdir($r_upload_path,0777,true)){
				return $upload_path;
			}
			else{
				return false;
			}
		}
	}
	$obj2=new _Makeshufflestr();
	$obj3=new _Createdir();
    if($_COOKIE['secretnumber']!=md5($_COOKIE['username'].$_COOKIE['secret']))
    {
    	echo "<script>alert('你无权访问！')</script>";
    	echo "<meta http-equiv='refresh' content='0;url=../../index.php'>";
    	exit();
    }
if(empty($_POST)){
	require(blog."/html/admin/cat_add.html"); 
}
else{
	$cat['cat_name']=htmlentities(trim($_POST['category']));
	if($mysql->getexist('category',$cat['cat_name'],'cat_name')!=0){
	echo "<script>alert('栏目名已存在!');</script>";
	echo '<meta http-equiv="refresh" content="0;url=cat_add.php">';
	exit();
	}
    if(empty($cat['cat_name'])){
    echo "<script>alert('栏目名不能为空!');</script>";
	echo '<meta http-equiv="refresh" content="0;url=cat_add.php">';
	exit();
    }
	if(!$mysql->do_sql('category',$cat)) {
	echo "<script>alert('栏目名添加失败!');</script>";
	echo '<meta http-equiv="refresh" content="0;url=cat_add.php">';
	exit();
	} else {
	echo "<script>alert('添加成功!');</script>";
	echo '<meta http-equiv="refresh" content="0;url=cat_add.php">';
	}
}
 ?>
