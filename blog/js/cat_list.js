

var a=$('.list_button');
var b=$('.list_input1');
var c=$('.list_input2');
b.each(function(){
    $(this).css("display","none");
});

c.each(function(){
    $(this).css("display","none");
});

for (var i = 0; i < a.length; i++) {
    (
        function(i){
            a.eq(i).click(function(){
                b.css("display","none");
                c.css("display","none");
                a.css("display","");
                b.eq(i).css("display","");
                c.eq(i).css("display","");
                a.eq(i).css("display","none");
            })
        }   
    )(i)
}