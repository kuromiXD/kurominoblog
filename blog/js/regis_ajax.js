/*var xmlHttp;
var obj;
function GetXmlHttpRequest(){
	if(window.XMLHttpRequest){
		xmlHttp=new XMLHttpRequest();
		return xmlHttp;
	}
	else{
		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		return xmlHttp;
	}
}


function statechange(){
	if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
		obj.innerHTML=xmlHttp.responseText;
			//document.getElementsByClassName('validate')[0].innerHTML=xmlHttp.responseText;
		}
}

function validate(str,object,flag){
	var url='../../php/viewer/regis_validate.php';
	obj=object;
	if(str==''){
		obj.innerHTML="<p class='validate_p_1'>请输入内容</p>";
		//document.getElementsByClassName('validate')[0].innerHTML="<p class='validate_p_1'>请输入内容</p>";
		return;
	}
	if(str.indexOf('#')>0||str.indexOf('&')>0||str.indexOf('?')>0){
    	obj.innerHTML="<p class='validate_p_1'>不能输入#、&、?等符号</p>";
    	return;
	}
	xmlHttp=GetXmlHttpRequest();
	if (xmlHttp==null)
  	{
  	alert("Browser does not support HTTP Request");
  	return;
  	} 
  	if(flag==1){
  		url=url+"?v="+str;
  	}else{
  		url=url+"?p="+str;
  	}
  	
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=statechange;
	xmlHttp.open("GET",url,true);
	xmlHttp.send();	
}
<input type="password" name="password" class="login_input" placeholder="6-12位英文字母,数字" onkeyup="validate(this.value,document.getElementsByClassName('validate')[1],2)">
<input type="text" name="username" class="login_input" placeholder="1-12位汉字,英文字母,数字或下划线组成" onkeyup="validate(this.value,document.getElementsByClassName('validate')[0],1)">
*/
var post_url='../../php/viewer/regis_validate.php';
$(document).ready(function(){

	$("#username").keyup(function(){
		var a=$('#username').serializeArray();
		var b=JSON.stringify(a);
		$.ajax({
				url:post_url,
				data:{"username":b},
				type:'post',
				dataType:'json',
				success:function(data){
					$(".validate").eq(0).html(data.result);
					if(data.success==0){
						$("#username").css("border-color","red");
					} else {
						$("#username").css("border-color","green");
					}
				}
		});
	});

	$("#password").keyup(function(){
		var a=$('#password').serializeArray();
		var b=JSON.stringify(a);
		$.ajax({
				url:post_url,
				data:{"password":b},
				type:'post',
				dataType:'json',
				success:function(data){
					$(".validate").eq(1).html(data.result);
					if(data.success==0){
						$("#password").css("border-color","red");
					} else {
						$("#password").css("border-color","green");
					}
				}
		});
	});

});