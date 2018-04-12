<?php
require("../../lib/init.php");
require(blog."/lib/mysql.class.php");
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
$article_id=$_GET['art_id'];
if(!is_numeric($article_id)){
    echo "<script>alert('文章不存在!')</script>";
    echo "<meta http-equiv=\"refresh\" content=\"0;url=../../index.php\">";
    exit();
}
$addr='art.php?art_id='.$article_id;
$addr1='art.php?art_id='.$article_id.'#pubcomm1';
if(empty($_POST)){
    $sql1="select cat_id,cat_name from category";
    $cat=$mysql->get_rows($sql1);
    $sql2="select art_id,title,content,picture_dir,last_modify_time,comment,tag,category.cat_id,cat_name from article inner join category on article.cat_id=category.cat_id where art_id='$article_id'" ;
    $art=$mysql->get_row($sql2);
    $sql3="select comment.user_id,last_modify_time,content,user.username from comment left join  user on comment.user_id=user.user_id where art_id='$article_id' order by last_modify_time";
    $comm=$mysql->get_rows($sql3);
    require(blog."/html/viewer/art.html");
}
else{
    if($_COOKIE['secretnumber']!=md5($_COOKIE['username'].$_COOKIE['secret'])){
            echo "<script>alert('请先注册或登录！')</script>";
            echo "<meta http-equiv=\"refresh\" content=\"0;url=$addr1\">";
            exit();
    }
    $array['content']=strip_tags(trim($_POST['content']));
    if($array['content']==''){
            echo "<script>alert('留言内容不能为空！')</script>"; 
            echo "<meta http-equiv=\"refresh\" content=\"0;url=$addr1\">";
            exit();
    }
    $array['art_id']=$article_id;
    $sql5="select user_id from user where username='$_COOKIE[username]'";
    $array['user_id']=$mysql->get_one($sql5);
    $mysql->do_sql('comment',$array);
    $sql4="update article set comment =comment+1 where art_id='$article_id'";
    if($mysql->do_query($sql4)){
            echo "<script>alert('留言成功！')</script>";
            echo "<meta http-equiv=\"refresh\" content=\"0;url=$addr1\">";
    }
} 
 ?>