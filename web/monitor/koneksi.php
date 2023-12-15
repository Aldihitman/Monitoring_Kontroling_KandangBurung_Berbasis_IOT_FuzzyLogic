<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "monitor";

$konek = mysqli_connect($server,$username,$password,$database);
if($konek == TRUE){
    echo "TERHUBUNG";
}
else{
    echo"GAGAL TERHUBUNG";
}
?>