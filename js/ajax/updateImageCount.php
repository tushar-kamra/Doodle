<?php

include("../../connect.php");

if(isset($_POST["imageUrlPostVar"])){
    $var = $_POST["imageUrlPostVar"] ;
    $sql = "update images set clicks = clicks+1 where imageUrl = '$var' " ;
    $result = $conn->query($sql) ;
}
else {
    echo "No link passed to page" ;
}

?>