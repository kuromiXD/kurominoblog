<?php 
require"PDO.class.php";

class article_mysql extends MYSQL
{
	 public $PDO_connect;
	/**
	 * [__construct 构造方法建立数据库连接] 
	 */
	public function __construct()
	{	
		$conf_array=require(blog."/lib/config.php");
		try {
			$this->PDO_connect=new PDO('mysql:dbname=blog;host=localhost', $conf_array['user'], $conf_array['password']);
		} catch(PDOException $e) {
			echo "<script>alert('数据库连接失败！')</script>";
			exit();
			//die('数据库连接失败'.$e->getMessage());
		}
		$this->PDO_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function PDO_make_art($data,$act='insert')
	{
		if ($act=='insert') {
			if (array_key_exists(':picture_dir',$data)) {
				$sqlstr="insert into article (title,content,cat_id,picture_dir,thumb,tag) values (:title,:content,:cat_id,:picture_dir,:thumb,:tag)";
			} else {
				$sqlstr="insert into article (title,content,cat_id,tag) values (:title,:content,:cat_id,:tag)";
			}
			
			try {
				$PDOstatement=$this->PDO_connect->prepare($sqlstr);
				if(!$PDOstatement->execute($data)) {
					throw new PDOException('添加失败');
				}
			} catch (PDOException $e) {
				echo "<script>alert('".$e->getMessage()."')</script>";
				exit();
			}
			$this->make_logs($sqlstr);
			return true;
		} else {
			if (array_key_exists(':picture_dir',$data)) {
				$sqlstr="update article set title=:title,content=:content,cat_id=:cat_id,picture_dir=:picture_dir,thumb=:thumb,tag=:tag";
			} else {
				$sqlstr="update article set title=:title,content=:content,cat_id=:cat_id,tag=:tag";
			}	
			try {
				$PDOstatement=$this->PDO_connect->prepare($sqlstr);
				$PDOstatement->execute($data);
				if(!$PDOstatement->execute($data)) {
					throw new PDOException('更改失败');
				}
			} catch (PDOException $e) {
				echo "<script>alert('".$e->getMessage()."')</script>";
				exit();
			}
			$this->make_logs($sqlstr);
			return true;
		}
	}
}
$mysql=new article_mysql();

