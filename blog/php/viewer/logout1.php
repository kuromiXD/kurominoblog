<?php 
setcookie('username','',time()-1,'/');
setcookie('islogin','',time()-1,'/');
setcookie('secretnumber','',time()-1,'/');
setcookie('secret','',time()-1,'/');
header("location:../../index.php");
 ?>