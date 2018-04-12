<?php
include(blog."/lib/Makeshufflestr.class.php");
class Makethumb implements Makeshufflestr{
	public $source;
	public $sw;
	public $sh;

	function __construct($source, $sw=250, $sh=200){
		$this->source=$source;
		$this->sw=$sw;
		$this->sh=$sh;
	}

	function make_shufflestr($strnum=6){
		$str=str_shuffle('QWERTYUIOPASDFGHJKLZXCVBNM1234567890mnbvcxzlkjhgfdsapoiuytrewq');
	    $str=substr($str,0,$strnum);
	    return $str;
	}

	function make_thumb(){

		$spath=dirname($this->source).'/'.$this->make_shufflestr().'.png';//缩略图的相对路径

		$opath=blog.ltrim($this->source,'.');//原始图的绝对地址
		$sspath=blog.ltrim($spath,'.');//缩略图的绝对地址
		if(!list($bw,$bh,$type) = getimagesize($opath)) {
			return false;
		}
		$map = array(
		1=>'imagecreatefromgif',
		2=>'imagecreatefromjpeg',
		3=>'imagecreatefrompng',
		6=>'imagecreatefromwbmp',
		15=>'imagecreatefromwbmp'
		);
		if( !isset($map[$type]) ) {
		return false;
		}
		$opic=$map[$type]($opath);
		$spic=imagecreatetruecolor($this->sw,$this->sh);
		$white = imagecolorallocate($spic, 255, 255, 255);
		imagefill($spic, 0, 0, $white);
		$rate = min( $this->sw/$bw , $this->sh/$bh );
		$rw = $bw*$rate;
		$rh = $bh*$rate;
		imagecopyresampled ( $spic , $opic , ($this->sw-$rw)/2 , ($this->sh-$rh)/2 , 0 , 0 , $rw , $rh , $bw , $bh );
		imagepng($spic , $sspath);
		imagedestroy($opic);
		imagedestroy($spic);
		return $spath;
	}
	
}

 ?>