<?php
/**
 * [mConn 创建连接blog数据库资源]
 * @conn [mysqli] [连接好数据的资源变量]
 */
function mConn(){
	static $conn=null;
	if($conn===null){
		$sql_init=require(blog.'/lib/config.php');
		$conn=mysqli_connect($sql_init['host'],$sql_init['user'],$sql_init['password'],$sql_init['database']);
		if(!$conn){
			die('Could not connect: ' . mysql_error());
			return false;
		}
		mysqli_query($conn,'set names utf8');
	   }    
	return $conn;
}
/**
 * [do_sql 执行传递过来的sql语句]
 * @sql  [string] $sql [数据库操作语句]
 * @mysqli_query(mConn(),&sql) [mixed]      [返回执行后得到的各种值]
 */
function do_query($sql){
     $rs=mysqli_query(mConn(),$sql);
     if($rs===false){
     	do_logs($sql."\n".mysql_error());
     	return $rs;
     }
     else{
     	do_logs($sql);
     	return $rs;
     }
}

function do_logs($sql){
	date_default_timezone_set('PRC');
	$filename= 'D:/wamp64/www/blog/logs/'.date('Ymd',time()).'.txt';
	$log='-----------------------------------'."\n".date('Y/m/d H:i:s',time())."\n".$sql."\n".
	'-----------------------------------'."\n";
	file_put_contents($filename, $log,FILE_APPEND);
}
/**
 * get_rows:得到查询的多行数据
 * @$sql  [string] $sql [将要操作的sql语句]
 * @$array [数组]      [返回查到的数组信息]
 */
function get_rows($sql){
	$rows=do_query($sql);
    if(!$rows){
    	die('Could not get rows of data from datebase: ' . mysql_error());
    }
    else{
        $array=array();
        while($row=mysqli_fetch_assoc($rows)){
        	$array[]=$row;
        }
    }
    return $array;
}

/**
 * get_row:得到查询的一行数据
 * @$sql  [string] $sql [将要操作的sql语句]
 * @mysqli_fetch_assoc($rows) or false [数组orfalse]      [根据查询到的结果返回一行数据或返回false]
 */
function get_row($sql){
	$rows=do_query($sql);
	if(!$rows){
		die('Could not get rows of data from datebase: ' . mysql_error());
	}
	else{
		return mysqli_fetch_assoc($rows);
	}
}
/**
 * get_one：得到查询的单元数据
 * @$sql  [string] $sql [将要操作的sql语句]
 * @$row[0] [string]    [返回查到的单个数据]
 */
function get_one($sql){
	$rows=do_query($sql);
    if(!$rows){
		die('Could not get rows of data from datebase: ' . mysql_error());
	}
	else{
		$row=mysqli_fetch_row($rows);
		return $row[0];
	}
}

/**
 * [do_sql 拼接sql语句并执行]
 * @param  [type] $table [操作的数据表]
 * @param  [type] $data  [更改的数据数组]
 * @param  string $act   [操作的行为(insert or set)]
 * @param  string $where [sql语句约束条件]
 * @return [type]        [返回一个资源型变量]
 */
function do_sql($table,$data,$act='insert',$where='0'){
	if($act=='insert'){
		$sql='insert into '.$table.' (';
		$sql.=implode(',',array_keys($data)).") value ('";
		$sql.=implode("','",array_values($data))."')";
		return do_query($sql);
	}
	else if($act=='update'){
		$sql='update '.$table.' set ';
		foreach ($data as $key => $value) {
			$sql.=$key."='".$value."',";
		}
		$sql=rtrim($sql,',');
		$sql.='where '.$where;
		return do_query($sql);
	}
}
/**
 * [getlastid 得到最后一次insert操作产生的id]
 * @return [type] [返回的id]
 */
function getlastid(){
	$last_id=mysqli_insert_id(mConn());
	return $last_id; 
}

function getexist($table,$data,$f){
	if(gettype($data)=='string'){
	$sql='select 1 from '.$table.' where '.$f.'='."'$data'";
	$a=get_one($sql);
	return $a;
	}
	else{
	$sql='select 1 from '.$table.' where '.$f.'='.$data;
	$a=get_one($sql);
	return $a;
	}
}

 ?>

