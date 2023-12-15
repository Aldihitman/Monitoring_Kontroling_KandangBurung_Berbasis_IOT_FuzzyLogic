<?php
    include_once('koneksi.php');

    $command = $_GET['command'];

    // Kirim perintah ke Arduino
    if ($command === 'on') {
        // Kirim perintah ke Arduino untuk nyalakan servo pakan
        file_get_contents('http://192.168.43.122/pakan?command=on');

        // Kirim perintah ke Arduino untuk nyalakan Pompa
        file_get_contents('http://192.168.43.122/minum?command=on');
    } else if ($command === 'off') {
        // Kirim perintah ke Arduino untuk matikan pakan
        file_get_contents('http://192.168.43.122/pakan?command=off');

        // Kirim perintah ke Arduino untuk matikan Pompa
        file_get_contents('http://192.168.43.122/minum?command=off');
    }

    // Redirect kembali ke halaman utama
    header('Location: monitor.php');
?>
