<?php 
if(isset($_GET['v'])){
	$v=$_GET['v'];
	$patt = '/^[\x4E00-\x9FA5\xf900-\xfa2d\w]{1,8}$/u';
	if(!preg_match_all($patt, $v)){

    	echo "<p class='validate_p_1'>",'用户名由1-8位汉字,英文字母,数字或下划线组成！',"</p>";
    }else{

    	echo "<p class='validate_p_2'>",'填写符合规则',"</p>";
    }
}else{
	$p=$_GET['p'];
	$patt='/^[a-zA-Z0-9]{6,12}$/';
	if(!preg_match_all($patt, $p)){

    	echo "<p class='validate_p_1'>",'密码由6-12位英文字母或数字组成！',"</p>";
    }else{

    	echo "<p class='validate_p_2'>",'填写符合规则',"</p>";
    }
}


   

 ?>