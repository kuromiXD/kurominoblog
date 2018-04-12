<?php
class Makepage{
	public $art_count;
	public $page_limit;
	public $page_curr;
	public $page_max;
	function __construct($art_count, $page_limit, $page_curr){
		$this->art_count=$art_count;
		$this->page_limit=$page_limit;
		$this->page_curr=$page_curr;
	}
	function make_page(){
	//得到最大页数
	$page_max=ceil($this->art_count/$this->page_limit);
	//得到显示页数的最小页数
	$page_min=max($this->page_curr-2,1);
	//得到显示页数的最大页数
	$page_max=min($page_min+4,$page_max);
	$this->page_max=$page_max;
	//根据最大页数确认最小页数
	$page_min=max($page_max-4,1);
	$page=array();
	for($i=$page_min;$i<=$page_max;$i++){
		$_GET['page']=$i;
		$page[$i]=http_build_query($_GET);
	}
	return $page;
	} 

}



  ?>

