var xmlHttp;
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
		var parent=document.getElementById('vv');
		var n_img=document.createElement("img");
		var f_img=document.getElementsByClassName('identi_pic')[0];
		parent.replaceChild(n_img,f_img);
		//document.getElementsByName('identi_pic')[0].src=xmlHttp.responseText;
		//document.getElementById('vv').appendChild(img);
		n_img.src=xmlHttp.responseText;
		n_img.setAttribute('class', 'identi_pic');
		n_img.setAttribute('onclick','identi()');
			//document.getElementsByClassName('validate')[0].innerHTML=xmlHttp.responseText;
		}
}
function identi(){
	var url="../../php/viewer/identi.php";
	url=url+"?sid="+Math.random();
	xmlHttp=GetXmlHttpRequest();
	if (xmlHttp==null)
  	{
  	alert("Browser does not support HTTP Request");
  	return;
  	}
  	xmlHttp.onreadystatechange=statechange;
  	xmlHttp.open("GET",url,true);
	xmlHttp.send(); 
}