<?php include('../config/constants.php'); ?>
<html>

<head>
    <title> HIB - Kyqja e administratorit </title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css">
</head>

<body class="align">
    <div class="grid align__item">
        <div class="register">
            <img src="../images/logo.png" alt="" width="100%">
            <?php
            if (isset($_SESSION['login'])) {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            if (isset($_SESSION['no-login-message'])) {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
            ?>
            <h4 class="mb-2">Identifikohu</h4>
            <form action="" method="POST" class="text-center">
                <div class="form__field">
                    <input type="text" name="username" placeholder="Emri i përdoruesit">
                </div>
                <div class="form__field">
                    <input type="password" name="password" placeholder="••••••••••••">
                </div>
                <div class="form__field"></div>
                <input type="submit" name="submit" value="Login">
            </form>
        </div>
        <?php
        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password = md5($_POST['password']);
            $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                $_SESSION['login'] = "<div class='alert alert-success' role='alert'>U kyqet me sukses</div>";
                $_SESSION['user'] = $username;
                header('location:' . SITEURL . 'admin/');
            } else {
                $_SESSION['login'] = "<script>alert('Emri i përdoruesit ose fjalëkalimi nuk përputhej.');</script>";
                header('location:' . SITEURL . 'admin/login.php');
            }
        }
        ?>
    </div>
</body>

</html>