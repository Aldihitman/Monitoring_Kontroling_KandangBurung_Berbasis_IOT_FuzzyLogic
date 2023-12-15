<?php
$konek = mysqli_connect("localhost","root","","monitor");
$pakan= mysqli_query($konek,"SELECT pakan FROM data ORDER BY jam DESC LIMIT 1");
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
        <canvas id="pakan"></canvas>
    </center>
    <script>
        <?php while($row = mysqli_fetch_array($pakan)) {
                            $jrk = $row['pakan'];                            
                            if ($jrk < 100) {
                                $warna = "'#ff4444'";
                            }elseif ( $jrk >= 50 && $jrk < 75) {
                                $warna = "'#ffbb33'";
                            }elseif ( $jrk >= 25  && $jrk < 50 ) {
                                $warna = "'#00C851'";
                            }else {
                            $warna = "'#33b5e5'";
                            }?>
        var ctx = document.getElementById("pakan").getContext('2d');
        var mychart = new Chart(ctx, {
            type : 'doughnut',
            data : {
                labels : [],
                datasets: [
                    {
                        label: 'Pakan',
                        data: [<?php echo $jrk; echo ','; echo 100-$jrk;?>],
                        backgroundColor:[<?php echo $warna; ?>],
                        borderWidth: 2
        <?php 	} ?>
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