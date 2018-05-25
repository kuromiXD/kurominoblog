<?php 
/*if(isset($_GET['v'])){
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
}*/
function getJson($resultno)
{
    $json_result=array();
    $result='';
    $success='';
    switch ($resultno) {
        case 1:
            $result="<p class='validate_p_1'>".'未填写用户名'."</p>";
            $success=0;
            break;
        case 2:
            $result="<p class='validate_p_1'>".'未填写密码'."</p>";
            $success=0;
            break;
        case 3:
            $result="<p class='validate_p_1'>".'错误，用户名由1-8位汉字,英文字母,数字或下划线组成！'."</p>";
            $success=0;
            break;
        case 4:
            $result="<p class='validate_p_1'>".'密码由6-12位英文字母或数字组成！'."</p>";
            $success=0;
            break;
        default:
            $result="<p class='validate_p_2'>".'填写符合规则'."</p>";
            $success=1;
            break;
    }
    $json_result['result']=$result;
    $json_result['success']=$success;
    return json_encode($json_result);
}

if(isset($_POST['username'])){
    $empty=0;
    $patt = '/^[\x4E00-\x9FA5\xf900-\xfa2d\w]{1,8}$/u';
    $json_input=json_decode($_POST['username'],true);

    if($json_input[0]['value']==""){
        echo getJson(1);
        $empty=1;
    }

    if($empty!=1){
        if(!preg_match_all($patt, $json_input[0]['value'])){
            echo getJson(3);
        }else{
            echo getJson(0);
        }
    }
    
}

if(isset($_POST['password'])){
    $success=0;
    $empty=0;
    $patt='/^[a-zA-Z0-9]{6,12}$/';
    $json_input=json_decode($_POST['password'],true);

    if($json_input[0]['value']==""){
        echo getJson(2);
        $empty=1;
    }

    if($empty!=1){
        if(!preg_match_all($patt, $json_input[0]['value'])){
            echo getJson(4);
        }else{
            echo getJson(0);
        }
    }
    
}
   

 ?>