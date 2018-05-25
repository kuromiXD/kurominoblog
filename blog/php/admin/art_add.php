<?php
   if (@$_COOKIE['username']!='admin'||!isset($_COOKIE['secretnumber'])) {
    	echo "<script>alert('非管理员禁止入内！')</script>";
    	echo "<meta http-equiv='refresh' content='0;url=../../index.php'>";
    	exit();
    }
require("../../lib/init.php");
require(blog."/lib/article.class.php");
require(blog."/lib/function.php");
require(blog."/lib/Makethumb.class.php");
require(blog."/lib/Createdir.class.php");
	class _Makeshufflestr implements Makeshufflestr
	{
		function make_shufflestr($strnum=6)
		{
			$str=str_shuffle('QWERTYUIOPASDFGHJKLZXCVBNM1234567890mnbvcxzlkjhgfdsapoiuytrewq');
	    	$str=substr($str,0,$strnum);
	    	return $str;
		}
	}
	class _Createdir implements Createdir
	{
		function create_dir()
		{
			$upload_path="./upload/".date("Y/m/d");
			$r_upload_path=blog.$upload_path;
			if (is_dir($r_upload_path)||mkdir($r_upload_path,0777,true)) {
				return $upload_path;
			} else {
				return false;
			}
		}
	}
	$obj2=new _Makeshufflestr();
	$obj3=new _Createdir();
    if ($_COOKIE['secretnumber']!=md5($_COOKIE['username'].$_COOKIE['secret'])) {
    	echo "<script>alert('你无权访问！')</script>";
    	echo "<meta http-equiv='refresh' content='0;url=../../index.php'>";
    	exit();
    }

$cat=$mysql->PDO_get_rows('select cat_id,cat_name from category');
if (empty($_POST)) {
	require(blog."/html/admin/art_add.html");
}
else {
	$art[':title']=htmlentities(trim($_POST['title']));
	if ($art[':title']==='') {
		echo "<script>alert('文章标题不能为空！');</script>";
		echo '<meta http-equiv="refresh" content="0;url=art_add.php">';
		exit();
	}
	$art[':content']=htmlentities(trim($_POST['content']));
	if ($art[':content']==='') {
		echo "<script>alert('文章内容不能为空！');</script>";
		echo '<meta http-equiv="refresh" content="0;url=art_add.php">';
		exit();
	}
	if ($mysql->PDO_get_one("select 1 from article where title ='".$art[':title']."'")!=false) {
		echo "<script>alert('文章标题已存在！');</script>";
		echo '<meta http-equiv="refresh" content="0;url=art_add.php">';
		exit();
	}
	$art[':cat_id']=$_POST['cat_id'];
	$art[':tag']=$_POST['tag'];
	if (!empty($_FILES['picture']['name'])&&$_FILES['picture']['error']==0) {
		$picture_dir=$obj3->create_dir().'/'.$obj2->make_shufflestr().getextension($_FILES['picture']['name']);
		if (move_uploaded_file($_FILES['picture']['tmp_name'],blog.$picture_dir)) {
			$art[':picture_dir']=$picture_dir;
			$obj1=new Makethumb($picture_dir);
			$art[':thumb']=$obj1->make_thumb();
		}
	}
	if (!$mysql->PDO_make_art($art, 'insert')) {
		echo "<script>alert('文章添加失败！');</script>";
		echo '<meta http-equiv="refresh" content="0;url=art_add.php">';
		exit();
	} else {
		$last_art_id=$mysql->PDO_get_lastInsertId();
		$sqladd="update category set art_num=art_num+1 where cat_id=".$art[':cat_id'];
	    $mysql->PDO_prepare_query($sqladd);
		$tag_array=explode(' ', $art[':tag']);
		$sql="insert into tag (art_id,content) values ";
		foreach ($tag_array as $tag) {
			$sql.="(".$last_art_id.","."'$tag'"."),";
		}
		$sql1=rtrim($sql,',');
		if (!$mysql->PDO_prepare_query($sql1)) {
			echo "<script>alert('Tag添加失败！');</script>";
			echo '<meta http-equiv="refresh" content="0;url=art_add.php">';
			exit();
		} else {
			echo "<script>alert('添加成功！');</script>";
			echo '<meta http-equiv="refresh" content="0;url=art_add.php">';
		}
	}
}