<?php

$konek = mysqli_connect("localhost","root","","monitor");
$suhu= mysqli_query($konek,"SELECT suhu FROM data ORDER BY jam  LIMIT 10");
$jam = mysqli_query($konek,"SELECT jam FROM data ORDER BY jam ASC LIMIT 10");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belajar Grafik</title>
    <script type="text/javascript" src="assets/js/Chart.js"></script>
</head>
<body>
    <center>
        <canvas id="suhu"></canvas>
    </center>
    <script>
        var ctx = document.getElementById("suhu").getContext('2d');
        var mychart = new Chart(ctx, {
            type : 'line',
            data : {
                labels : [<?php while($row = mysqli_fetch_array($jam)) {echo'"'.$row['jam'].'",';}?>],
                datasets: [
                    {
                        label: 'SUHU',
                        data: [<?php while($row = mysqli_fetch_array($suhu)) {echo'"'.$row['suhu'].'",';}?>],
                        backgroundColor:['#33b5e5'],
                        borderWidth: 2
                    }
                ]
            },
            Option: {
                scales:{
                    yAxes:[
                        {
                            ticks: {
                                beginAtZero:true
                            }
                        }
                    ]
                }
            }
        })
    </script>
</body>
</html>