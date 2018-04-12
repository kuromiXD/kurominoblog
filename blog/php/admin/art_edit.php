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
if(empty($_POST)){
	$sql="select art_id,title,category.cat_id,cat_name,content,tag from article left join category 
	on category.cat_id=article.cat_id where art_id='$art_id'";
	$row=$mysql->get_row($sql);
	$sql2='select cat_id,cat_name from category ';
	$rows=$mysql->get_rows($sql2);
	require(blog."/html/admin/art_edit.html");
}
else{
	if($mysql->getexist('article',$art_id,'art_id')==0){
		$addr=$_SERVER['HTTP_REFERER'];
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=$addr\">";
    	echo "<script>alert('这篇文章不存在！');</script>";
		exit();
    }
	$row['title']=htmlentities(trim($_POST['title']));
	if($row['title']===''){
		$addr=$_SERVER['HTTP_REFERER'];
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=$addr\">";
		echo "<script>alert('文章标题不能为空！');</script>";
		exit();
	}
	$row['content']=htmlentities(trim($_POST['content']));
	if($row['content']===''){
		$addr=$_SERVER['HTTP_REFERER'];
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=$addr\">";
		echo "<script>alert('文章内容不能为空！');</script>";
		exit();
	}
	$row['cat_id']=$_POST['cat_id'];
	$x=$_POST['pre_cat_id'];
	$row['tag']=$_POST['tag'];
		if(!empty($_FILES['picture']['name'])&&$_FILES['picture']['error']==0){
		$picture_dir=$obj3->create_dir().'/'.$obj2->make_shufflestr().getextension($_FILES['picture']['name']);
		if(move_uploaded_file($_FILES['picture']['tmp_name'],blog.$picture_dir)){
			$row['picture_dir']=$picture_dir;
			$obj1=new Makethumb($picture_dir);
			$row['thumb']=$obj1->make_thumb();
		}
	}
    if(!$mysql->do_sql('article',$row,'update','art_id='.$art_id)){
    	$addr=$_SERVER['HTTP_REFERER'];
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=$addr\">";
    	echo "<script>alert('修改文章失败！');</script>";
		exit();
    }
    else{
        $sql_edit_tag1="delete from tag where art_id='$art_id'";
        $mysql->do_query($sql_edit_tag1);
        $sql_edit_tag2="insert into tag (art_id,content) values ";
        $tag_array=explode(' ', $row['tag']);
		foreach($tag_array as $tag){
			$sql_edit_tag2.="(".$art_id.","."'$tag'"."),";
		}
		$sql_edit_tag3=rtrim($sql_edit_tag2,',');
		$mysql->do_query($sql_edit_tag3);
        if($row['cat_id']!=$x){

           $sqlz="update category set art_num=art_num+1 where cat_id='$row[cat_id]'";
           $sqlj="update category set art_num=art_num-1 where cat_id='$x'";
           
           $mysql->do_query($sqlz);
           $mysql->do_query($sqlj);
        }
       // echo "<script>alert('$row[cat_id]');</script>";
    	//echo "<script>alert('$x');</script>";
		$addr=$_SERVER['HTTP_REFERER'];
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=$addr\">";
		echo "<script>alert('修改文章成功！');</script>";
    }
}


 ?>