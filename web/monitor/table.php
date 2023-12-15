<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Table - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> 
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion p-0" style="background-color: #2C3E50;">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="../index/index.html">
                    <div class="sidebar-brand-icon rotate-n-15"><i class='fas fa-file-alt'></i></div>
                    <div class="sidebar-brand-text mx-3"><span>Informasi <br> Data </span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="../index/index.html"><i class="fas fa-tachometer-alt"></i><span class="mx-2">Menu Utama</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="monitor.php"><i class="fas fa-table"></i><span class="mx-2">Monitoring</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content"> 
                <nav class="navbar navbar-light navbar-expand shadow mb-4 topbar static-top" style="background-color: #2C3E50;">
                    <p class="me-5 text text-center w-100 text-light">INFORMASI</p>
                </nav>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Informasi Sensor Data</h3>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 fw-bold">Info</p>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jam</th>
                                            <th>Suhu</th>
                                            <th>Status Pakan</th>
                                            <th>Status Minum</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $konek = mysqli_connect("localhost","root","","monitor");
                                        $sql = mysqli_query($konek,"SELECT * FROM data ORDER BY jam DESC LIMIT 10") or die(mysqli_error($konek));
                                        if(mysqli_num_rows($sql)>0){
                                            while($data = mysqli_fetch_assoc($sql)){
                                                echo '
                                                <tr>
                                                    <td>'.$data['tanggal'].'</td>
                                                    <td>'.$data['jam'].'</td>
                                                    <td>'.$data['suhu'].'</td>
                                                    <td>'.$data['statuspakan'].'</td>
                                                    <td>'.$data['statusminum'].'</td>
                                                </tr>
                                                ';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
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
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>