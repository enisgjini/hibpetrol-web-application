<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Food Order System</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>



    <style>
    .dark-mode {
        background-color: #1D2521;
        color: #C7D1CC;
    }
    </style>
</head>

<body style="font-family: 'Poppins', sans-serif;">
    <!-- Seksioni Navbar fillon këtu -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow">
        <div class="container">
            <a class="navbar-brand" href="<?php echo SITEURL; ?>">HIB</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITEURL; ?>">Ballina</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITEURL; ?>categories.php">Kategoritë</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITEURL; ?>foods.php">Ushqimet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kontakti</a>
                    </li>
                    
                </ul>
                <form class="d-flex">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="https://www.facebook.com/hibpetrol/" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://www.instagram.com/hibpetrolofficial/" >
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </nav>
    <!-- Seksioni Navbar përfundon këtu -->
</body>

</html>