<?php  
   
    $servername ='localhost';
    $username ='root';
    $password ='root';
    $database ='bd_proj26-grp1-cobra';
   
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
   
?>