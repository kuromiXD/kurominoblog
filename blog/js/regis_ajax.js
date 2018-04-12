var xmlHttp;
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

