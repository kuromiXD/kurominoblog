/*var xmlHttp;
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
		n_img.src=xmlHttp.responseText;
		n_img.setAttribute('class', 'identi_pic');
		n_img.setAttribute('onclick','identi()');
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
}*/
function identi(){

  	var url="../../php/viewer/identi.php";
	url=url+"?sid="+Math.random();
    $.getJSON(url,function(result){
    	var img=$("<img/>");
    	$(".identi_pic").eq(0).replaceWith(img);
    	img.addClass("identi_pic");
    	img.attr("src",result);
    	img.click(identi);
    });
}
  $(".identi_pic").eq(0).click(identi);
