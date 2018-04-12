var a=document.getElementsByClassName('list_button');
var b=document.getElementsByClassName('list_input1');
var c=document.getElementsByClassName('list_input2');
for(var x=0;x<b.length;x++){
	b[x].style.display="none";

}
for(var y=0;y<c.length;y++){
    c[y].style.display="none";
}
 for (var i = 0; i < a.length; i++) {
        (function(i) {
            a[i].onclick = function() {
                b[i].style.display="";
                c[i].style.display="";
                a[i].style.display="none";
            }
        })(i)
    }