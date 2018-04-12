<?php
/**
 * Mysql类,实现连接mysql数据库，执行sql语句，等到查询结果等数据库操作
 */
  class Mysql
  {
	public $conn;
	//构造函数：一旦实例化类mysql就自动连接数据库
	public function __construct(){
		$conf_array=require(blog."/lib/config.php");
		try {
			if(!$this->conn=new mysqli($conf_array['host'],$conf_array['user'],$conf_array['password'],$conf_array['database'])){
				throw new Exception("数据库连接失败", 1);
			}

		} catch(Exception $e) {
			echo $e->getMessage()."<br/>";
			die('Connect Error (' . mysqli_connect_errno() . ') '
        	. mysqli_connect_error());
		}
		$this->conn->query('set names utf8');
		
	}
	//记录进行过query的sql语句
	public function do_logs($sql){
		$filename= 'D:/wamp64/www/blog/logs/'.date('Ymd',time()).'.txt';
		$log=date('Y/m/d H:i:s',time()).$sql."-----------------------------------\n";
		file_put_contents($filename, $log,FILE_APPEND);
	}
	//通过query执行sql语句
	public function do_query($sql){
		if(!$result=$this->conn->query($sql)){
			printf("Error: %s\n", $this->conn->error);
			exit();
		}
		else{
			$this->do_logs($sql);
			return $result;
		}
	}
	//得到多行查询结果
	public function get_rows($sql){
		$array_rows=[];
		if($rows=$this->do_query($sql)){
			while($row=$rows->fetch_assoc()){
			$array_rows[]=$row;
			}
			return $array_rows;
		}
		else{
			echo "<script>alert('查询出错')</script>";
		}

	}
	//得到一行查询结果
	public function get_row($sql){
		$row=$this->do_query($sql);
		if($res=$row->fetch_assoc()){
			return $res;
		}
		else{
			echo "<script>alert('查询出错')</script>";
		}
	}
	//得到一个数据
	public function get_one($sql){
		$one=$this->do_query($sql);
		if($res=$one->fetch_row()){
			return $res[0];
		}
		else{
			echo "<script>alert('查询出错')</script>";
		}
	}
	//拼接sql语句，执行update或insert操作
	public function do_sql($table, $data, $act='insert', $where='0'){
		if ($act=='insert') {
			$sql='insert into '.$table.' (';
			$sql.=implode(',',array_keys($data)).") values ('";
			$sql.=implode("','",array_values($data))."')";
			$this->do_query($sql);
			return true;
		}
		else{
			$sql='update '.$table.' set ';
			foreach ($data as $key => $value) {
				$sql.=$key."='".$value."',";
			}
			$sql=rtrim($sql,',');
			$sql.=' where '.$where;
			$this->do_query($sql);
			return true;
		}

	}
	//得到上一次insert操作产生的id
	public function getlastid(){
		return $this->conn->insert_id;
	}
	//得到某样数据是否存在
	public function getexist($table,$data,$f){
		if(gettype($data)=='string'){
			$sql='select count(*) from '.$table.' where '.$f."='".$data."'";
			return $this->get_one($sql);
		}
		else{
			$sql='select 1 from '.$table.' where '.$f."=".$data;
			return $this->get_one($sql);
		}
	}
	

} 

$mysql=new Mysql();
 ?>