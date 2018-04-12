<?php
    require("./lib/init.php");
    require(blog."/lib/PDO.class.php");
    require(blog."/lib/Makepage.class.php");
    $sql1="select cat_id,cat_name from category";
    $cat=$mysql->PDO_get_rows($sql1);
    if(empty($_GET['cat_id'])){
        $sql="select count(*) from article";
        $art_count=$mysql->PDO_get_one($sql);
        if(empty($_GET['page'])){
            $page_curr=1;
        }
        else{
           $page_curr=$_GET['page']; 
        }
        $makepage=new Makepage($art_count,3,$page_curr);
        $page=$makepage->make_page();
        $page_curr=$makepage->page_curr;
        $max_page=$makepage->page_max;
        //$page=makepage($art_count,3,$page_curr);
        $startrow=($page_curr-1)*3;
    	 $sql2="select art_id,title,content,last_modify_time,comment,thumb,tag,category.cat_id,cat_name from article inner join category on article.cat_id=category.cat_id order by art_id desc limit $startrow,3";
    	 $art=$mysql->PDO_get_rows($sql2);
         
    }
    else{
    	$n=$mysql->PDO_get_one("select 1 from article where cat_id='$_GET[cat_id]'");
    	if($n==false){
    		echo "<script>alert('抱歉！该栏目下暂时没有文章。')</script>";
    		echo '<meta http-equiv="refresh" content="0;url=index.php">';

    	}
    	else{
        $sql="select count(*) from article where cat_id=".$_GET['cat_id'];
        $art_count=$mysql->PDO_get_one($sql);
        if(empty($_GET['page'])){
            $page_curr=1;
        }
        else{
           $page_curr=$_GET['page']; 
        }
        $makepage=new Makepage($art_count,3,$page_curr);
        $page=$makepage->make_page();
        $page_curr=$makepage->page_curr;
        $max_page=$makepage->page_max;
        //$page=makepage($art_count,3,$page_curr);
        $startrow=($page_curr-1)*3;
		$sql2="select art_id,title,content,last_modify_time,comment,thumb,tag,category.cat_id,cat_name from article inner join category on article.cat_id=category.cat_id where article.cat_id=".$_GET['cat_id']." order by art_id desc limit $startrow,3";
		$art=$mysql->PDO_get_rows($sql2);
    	}
    		
    }
    
    		
    	
	require(blog."/html/viewer/index.html");
    
 ?>