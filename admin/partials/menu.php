<?php
include('../config/constants.php');
include('login-check.php');
?>
<!DOCTYPE html>
<html lang="sq">

<head>
    <!-- Title of web-app -->
    <title>HIB</title>

    <!-- Meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/style4.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a1927a49ea.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

</head>

<body style="font-family: 'Poppins', sans-serif">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                </ul>
                <div>
                    <form class="d-flex justify-content-end">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <li class="nav-item">
                                    <a class="btn btn-success btn-sm" id="sidebarCollapse" >
                                        <i class="fas fa-align-left"></i>
                                        Ndrysho shiritin anësor
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-success btn-sm" href="logout.php">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                        Shkyqu
                                    </a>
                                </li>
                            </div>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <img src="../images/logo.png" alt="" width="100%">
            </div>
            <hr class="dropdown-divider">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link mt-2" href="index.php">
                        <i class="bi bi-house text-white"></i>
                        Paneli
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mt-2" href="manage-category.php">
                        <i class="fa-solid fa-list"></i>
                        Kategoritë ushqimore
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mt-2" href="manage-food.php">
                        <i class="fa-solid fa-bowl-food"></i>
                        Artikuj ushqimorë
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mt-2" href="manage-order.php">
                        <i class="fa-solid fa-location-dot"></i>
                        Seksioni i porosive
                    </a>
                </li>
                <li lass="nav-item">
                    <a class="nav-link mt-2" href="manage-admin.php">
                        <i class="fa-solid fa-user-shield"></i>
                        Menagjo admin-ët
                    </a>
                </li>

            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <!-- jQuery CDN - Slim version (=without AJAX) -->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
            </script>
            <!-- Popper.JS -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous">
            </script>
            <!-- Bootstrap JS -->
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
            </script>

            <script type="text/javascript">
                $(document).ready(function() {
                    $('#sidebarCollapse').on('click', function() {
                        $('#sidebar').toggleClass('active');
                    });
                });
            </script>
</body>

</html>