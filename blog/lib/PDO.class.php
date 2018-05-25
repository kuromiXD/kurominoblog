<?php
//require"./init.php";
class MYSQL
{   
    static private $PDO_instance;
    private $PDO_connect;

    /**
     * [getInstance 创建单例对象]
     * @return [object] [MYSQL类对象]
     */
    static function getInstance()
    {
    	if(!self::$PDO_instance instanceof self){
    		self::$PDO_instance = new self();
    	}
    	return self::$PDO_instance;
    }


	/**
	 * [__construct 构造方法建立数据库连接] 
	 */
	public function __construct()
	{	
		$conf_array=require(blog."/lib/config.php");
		try {
			$this->PDO_connect=new PDO('mysql:dbname=blog;host=localhost', $conf_array['user'], $conf_array['password'],array(
    PDO::ATTR_PERSISTENT => true));
		} catch(PDOException $e) {
			echo "<script>alert('数据库连接失败！')</script>";
			exit();
			//die('数据库连接失败'.$e->getMessage());
		}
		$this->PDO_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	/**
	 * [PDO_query 进行query查询]
	 * @param [string] $sqlstr [sql语句]
	 */
	public function PDO_query($sqlstr)
	{
    	try {
    		$PDOstatement=$this->PDO_connect->query($sqlstr);
    		if(!$PDOstatement) {
    			throw new PDOException('查询失败');
    		}
    	} catch(PDOException $e) {
    		echo "<script>alert('".$e->getMessage()."')</script>";
    		exit();
    		//die('查询失败'.$e->getMessage());
    	}
    	$this->make_logs($sqlstr);
    	return $PDOstatement;
	}

	/**
	 * [PDO_get_rows 进行query查询得到多行数据]
	 * @param [string] $sqlstr [sql语句]
	 */
	public function PDO_get_rows($sqlstr)
	{
		try {
			$PDOstatement=$this->PDO_connect->prepare($sqlstr);
			if(!$PDOstatement->execute()) {
				throw new  PDOException('查询失败');
			}
			$rows=$PDOstatement->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) { 
			echo "<script>alert('".$e->getMessage()."')</script>";
			exit();
		}
		$this->make_logs($sqlstr);
		return $rows;
	}

	/**
	 * [PDO_get_row 进行query查询得到一行数据]
	 * @param [string] $sqlstr [sql语句]
	 */
	public function PDO_get_row($sqlstr)
	{
		try {
			$PDOstatement=$this->PDO_connect->prepare($sqlstr);
			if(!$PDOstatement->execute()) {
				throw new PDOException('查询失败');
			}
			$row=$PDOstatement->fetch(PDO::FETCH_ASSOC);
		} catch(PDOException $e) { 
			echo "<script>alert('".$e->getMessage()."')</script>";
			exit();
		}
		$this->make_logs($sqlstr);
		return $row;
	}

	/**
	 * [PDO_get_rows_one 进行query查询得到多行数据中的某一列数据]
	 * @param [type]  $sqlstr [sql语句]
	 * @param integer $index  [默认此列为第一个字段]
	 */
	public function PDO_get_rows_column($sqlstr, $index=0)
	{
		try {
			$PDOstatement=$this->PDO_connect->prepare($sqlstr);
			if(!$PDOstatement->execute()) {
				throw new PDOException('查询失败');
			}
			$result=$PDOstatement->fetchALL(PDO::FETCH_COLUMN, $index);
		} catch(PDOException $e) { 
			echo "<script>alert('".$e->getMessage()."')</script>";
			exit();
		}
		$this->make_logs($sqlstr);
		return $result;
		/*
		$i=0;
		try {
			$PDOstatement=$this->PDO_connect->prepare($sqlstr);
			if(!$PDOstatement->execute()) {
				throw PDOException('查询失败');
			}
			while($result=$PDOstatement->fetchColumn($index)) {
			$array[$i]=$result;
			$i++;
			}
		} catch(PDOException $e) { 
			echo "<script>alert('".$e->getMessage()."')</script>";
			exit();
		}
		$this->make_logs($sqlstr);
		return $array;
		*/
	}

	/**
	 * [PDO_get_rows_one 进行query查询得到一个数据]
	 * @param [type]  $sqlstr [sql语句]
	 * @param integer $index  [默认此列为第一个字段]
	 */
	public function PDO_get_one($sqlstr, $index=0)
	{
		try {
			$PDOstatement=$this->PDO_connect->prepare($sqlstr);
			if(!$PDOstatement->execute()) {
				throw new PDOException('查询失败');
			}
			$result=$PDOstatement->fetchColumn($index);
		} catch(PDOException $e) {
			echo "<script>alert('".$e->getMessage()."')</script>";
			exit();
		}
		$this->make_logs($sqlstr);
		return $result;
	}

	/**
	 * [PDO_get_lastInsertId 得到最后一条插入数据产生的ID]
	 */
	public function PDO_get_lastInsertId()
	{
		try {
			$last_InsertId=$this->PDO_connect->lastInsertId();
		} catch(PDOException $e) {
			die('查询失败'.$e->getMessage());
		}
		return $last_InsertId;
	}


	/**
	 * [PDO_prepare_query 预处理sql语句查询]
	 * @param [type] $sqlstr [sql语句]
	 */
	public function PDO_prepare_query($sqlstr)
	{
		try {
			$PDOstatement=$this->PDO_connect->prepare($sqlstr);
			$result=$PDOstatement->execute();
			if(!$result) {
				throw new PDOException('查询失败');
			}
		} catch(PDOException $e) {
			echo "<script>alert('".$e->getMessage()."')</script>";
			exit();
		}
		$this->make_logs($sqlstr);
		return $result;
	}


	public function PDO_makedo_sqlstr($table, $data, $act='insert', $where='0')
	{
		if ($act=='insert') {
			$sqlstr='insert into '.$table.' (';
			$sqlstr.=implode(',',array_keys($data)).") values ('";
			$sqlstr.=implode("','",array_values($data))."')";
		} else {
			$sqlstr='update '.$table.' set ';
			foreach ($data as $key => $value) {
				$sqlstr.=$key."='".$value."',";
			}
			$sqlstr=rtrim($sql, ',');
			$sqlstr.=' where '.$where;
		}
		try {
			$PDOstatement=$this->PDO_connect->prepare($sqlstr);
			$result=$PDOstatement->execute();
			if(!$result) {
				throw new PDOException('查询失败');
			}
		} catch(PDOException $e) {
			echo "<script>alert('".$e->getMessage()."')</script>";
			exit();
		}
		$this->make_logs($sqlstr);
	}

	private function make_logs($sql)
	{
		$filename= 'D:/wamp64/www/blog/logs/'.date('Ymd',time()).'.txt';
		$log=date('Y/m/d H:i:s',time()).$sql."-----------------------------------\n";
		file_put_contents($filename, $log,FILE_APPEND);
	}

}



$mysql=MYSQL::getInstance();
//var_dump($mysql->PDO_get_rows(' select title from article   '));