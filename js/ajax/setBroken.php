<?php

include("../../connect.php");

if(isset($_POST["src"])){
    $var = $_POST["src"] ;
    $sql = "update images set broken = 1 where imageUrl = '$var' " ;
    $result = $conn->query($sql) ;
}

else {
    echo "No src passed to page" ;
}

?>