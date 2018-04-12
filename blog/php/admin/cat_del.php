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
$catid=$_GET['cat_id'];
$sql1="select art_num from category where cat_id=".$catid;
$n=$mysql->get_one($sql1);
if($n!=0){
	echo '<meta http-equiv="refresh" content="0;url=cat_list.php">';
	echo "<script>alert('栏目下有文章无法删除!')</script>";
	exit();
}
$sql2='delete from category where cat_id ='.$catid;
if(!$mysql->do_query($sql2)){
  echo '<meta http-equiv="refresh" content="0;url=cat_list.php">';
  echo "<script>alert('删除失败!')</script>";
  exit();
}
else{
	header('Location: ./cat_list.php');
}

 ?>
