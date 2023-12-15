<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Monitoring</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <script type="text/javascript" src="\assets\js\chart.min.js"></script>
    
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion p-0" style="background-color: #2C3E50;">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="../index/index.html">
                    <div class="sidebar-brand-icon rotate-n-15"><i class='fa fa-unlock-alt'></i></div>
                    <div class="sidebar-brand-text mx-3"><span>Monitoring<br> Kandang</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link active" href="../index/index.html"><i class="fas fa-tachometer-alt"></i><span class="mx-2">Menu Utama</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="table.php"><i class="fas fa-table"></i><span class="mx-2">Table</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column w-100" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expandshadow mb-4 topbar static-top text-white" style="background-color: #2C3E50;">  <p class="me-5 text-center w-100 text-light">MONITOR KANDANG</p>
                </nav>
                <div class="container">
                    <div class="row">
                        <div>
                            <div class="card shadow mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary fw-bold m-0">Suhu Pada Kandang</h6>
                                </div>
                                <div class="card-body">
                                <?php require('dht.php');?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-4">
                            <div class="card shadow mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary fw-bold m-0">Tempat Pakan Burung</h6>
                                </div>
                                <div class="card-body">
                                <?php require('pakan.php');?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-4">
                            <div class="card shadow mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary fw-bold m-0">Tempat Minum Burung</h6>
                                </div>
                                <div class="card-body">
                                <?php require('minum.php');?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-4">
                        <div class="card shadow mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="text-primary fw-bold m-0">Tempat Pakan dan Minum Burung</h6>
                            </div>
                            <div class="card-body">
                                <?php require('pakan.php');?>
                                <?php require('minum.php');?>
                                <button id="btnFeed" class="btn btn-success">Berikan Makan</button>
                                <button id="btnWater" class="btn btn-info">Berikan Air</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="sticky-footer" style="background-color: #2C3E50;">
                <div class="container my-auto">
                    <div class="text-center text-white my-auto copyright"><span>Tugas Akhir Aldi</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script>
        document.getElementById('btnFeed').addEventListener('click', () => {
            sendControlCommand('feed');
        });

        document.getElementById('btnWater').addEventListener('click', () => {
            sendControlCommand('water');
        });

        function sendControlCommand(command) {
            fetch(`control.php?cmd=${command}`)
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                })
                .catch(error => console.error(error));
        }
    </script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
    <script>
        function sendPakanCommand(command) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "send_command.php?command=" + command, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
              
            }
        };
        xhr.send();
    }
    function sendMinumCommand(command) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "send_command.php?command=" + command, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Tambahkan kode jika perlu
                }
            };
            xhr.send();
        }
    </script>
    <?php 
    include_once('koneksi.php');

    $query = "SELECT data_sensor FROM data ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($konek, $query);
    $row = mysqli_fetch_array($result);
    $data_sensor = $row['data_sensor'];

    if ($data_sensor < 26) {
        echo '<div style="text-align:center; padding: 15px; background-color: yellow; font-weight: bold; margin: auto; width: 50%;">Heater On</div>';
        $updateQuery = "UPDATE data SET status='Heater On' WHERE id = (SELECT MAX(id) FROM data)";
        mysqli_query($konek, $updateQuery);
    }
    ?>

</body>

</html>