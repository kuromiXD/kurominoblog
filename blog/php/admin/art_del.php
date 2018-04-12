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
$art_id=$_GET['art_id'];
$sql3="delete from tag where art_id='$art_id'";
$mysql->do_query($sql3);
$sql4="delete from comment where art_id='$art_id'";
$mysql->do_query($sql4);
$sql='delete from article where art_id ='.$art_id;
$sql1='select cat_id from article where art_id='.$art_id;
$cat_id=$mysql->get_one($sql1);
if(!$mysql->do_query($sql)){
  echo '<meta http-equiv="refresh" content="0;url=art_list.php">';
  echo "<script>alert('删除失败!')</script>";
  exit();
}
else{
	$sql2='update category set art_num=art_num-1 where cat_id='.$cat_id;
    $mysql->do_query($sql2);
	header('Location: ./art_list.php');
}
 ?>