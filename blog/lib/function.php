
<?php
function getextension($filename){
	return strrchr($filename,'.');
}
function make_identi_code($obj){
	$img=imagecreate(60,40);
	$backcolor=imagecolorallocate($img,rand(0,255),rand(0,255),rand(0,255));
	$red=imagecolorallocate($img,rand(0,255),rand(0,255),rand(0,255));
	$line=imagecolorallocate($img,rand(0,255),rand(0,255),rand(0,255));
	imagefill($img,0,0,$backcolor);
	$GLOBALS['shuff_string']  =$obj->make_shufflestr(4);
	session_start();
	if(isset($_SESSION['identi_code'])){
		unlink("../../image/".$_SESSION['identi_code'].".png");
	}
    $_SESSION['identi_code']=$GLOBALS['shuff_string'];
	imagestring($img,5,15,10,$GLOBALS['shuff_string'],$red);
	for($i=0;$i<35;$i++){
		do {
			$randomx1=rand(0,60);
			$randomy1=rand(0,40);
			$randomx2=rand(0,60);
			$randomy2=rand(0,40);
			//echo $randomx1,"<br/>",$randomy1,"<br/>",$randomx2,"<br/>",$randomy2,"<br/>";
		} while (abs($randomx1-$randomx2)>11||abs($randomy1-$randomy2)>8);
		imageline($img,$randomx1,$randomy1,$randomx2,$randomy2,$line);
	}
	$identi_code_src='../../image/'.$GLOBALS['shuff_string'].'.png';
	imagepng($img,$identi_code_src);
	imagedestroy($img);
  	return $identi_code_src;
} 

 ?>
