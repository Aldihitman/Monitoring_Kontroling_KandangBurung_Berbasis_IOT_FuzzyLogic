<?php
include('koneksi.php');


//Data jam dan tanggal
date_default_timezone_set('Asia/Jakarta');
$jam = date('H:i:s');
$tanggal = date('d-m-y');
//Data pengiriman data sensor menggunakan get
$suhu = $_GET['suhu'];
$kelembapan = $_GET['kelembapan'];
$pakan = $_GET['pakan'];
$minum = $_GET['minum'];

if ($pakan > 5){
    $statuspakan = "Aktif";
}
else{
    $statuspakan = "Tidak Aktif";
}

if ($minum > 5){
    $statusminum = "Aktif";
}
else{
    $statusminum = "Tidak Aktif";
}

$input = mysqli_query($konek, 'INSERT INTO data (tanggal,jam,suhu,kelembapan,pakan,minum,statuspakan,statusminum)VALUES("'.$tanggal.'","'.$jam.'","'.$suhu.'","'.$kelembapan.'","'.$pakan.'","'.$minum.'","'.$statuspakan.'","'.$statusminum.'")');

if($input == TRUE){
    echo "Berhasil Input Data";
}
else{
    echo "Gagal Input Data";
}
?>



