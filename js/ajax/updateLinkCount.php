<?php

include("../../connect.php");

if(isset($_POST["linkIdPostVar"])){
    $var = $_POST["linkIdPostVar"] ;
    $sql = "update sites set clicks = clicks+1 where id = '$var' " ;
    $result = $conn->query($sql) ;
}
else {
    echo "No link passed to page" ;
}

?>