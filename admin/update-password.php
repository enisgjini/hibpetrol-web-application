<?php include('partials/menu.php'); ?>
<div>
    <div class="container" style="font-family: 'Poppins', sans-serif;margin-bottom:50px;">
        <h1 style="margin-top:75px;margin-bottom:50px;">Ndrysho fjalekalimin</h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Launch demo modal
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ndrysho fjalekalimin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php
                        if (isset($_GET['id'])) {
                            $id = $_GET['id'];
                        }
                        ?>
                        <form action="" method="POST">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="current_password" placeholder="Fjalëkalimi aktual">
                                <label for="floatingInput">Fjalëkalimi aktual:</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="new_password" placeholder="Fjalëkalim i ri">
                                <label for="floatingInput">Fjalëkalim i ri:</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="confirm_password" placeholder="Konfirmo fjalëkalimin">
                                <label for="floatingInput">Konfirmo fjalëkalimin:</label>
                            </div>

                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Ndrysho fjalekalimin" class="btn btn-success">
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <?php

        //CHeck whether the Submit Button is Clicked on Not
        if (isset($_POST['submit'])) {
            //echo "CLicked";

            //1. Get the DAta from Form
            $id = $_POST['id'];
            $current_password = md5($_POST['current_password']);
            $new_password = md5($_POST['new_password']);
            $confirm_password = md5($_POST['confirm_password']);


            //2. Check whether the user with current ID and Current Password Exists or Not
            $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

            //Execute the Query
            $res = mysqli_query($conn, $sql);

            if ($res == true) {
                //CHeck whether data is available or not
                $count = mysqli_num_rows($res);

                if ($count == 1) {
                    //User Exists and Password Can be CHanged
                    //echo "User FOund";

                    //Check whether the new password and confirm match or not
                    if ($new_password == $confirm_password) {
                        //Update the Password
                        $sql2 = "UPDATE tbl_admin SET 
                                password='$new_password' 
                                WHERE id=$id
                            ";

                        //Ekzekutoni pyetjen
                        $res2 = mysqli_query($conn, $sql2);

                        //Kontrolloni nëse pyetja e ekzekutuar apo jo
                        if ($res2 == true) {
                            //Shfaq mesazhin e suksesit
                            //Redirect për të menaxhuar faqen e admin me mesazhin e suksesit
                            $_SESSION['change-pwd'] = "<div class='success'>Fjalëkalimi ndryshoi me sukses. </div>";
                            //Redirect përdoruesin
                            header('location:' . SITEURL . 'admin/manage-admin.php');
                        } else {
                            //Mesazhi i gabimit të ekranit
                            //Redirect për të menaxhuar faqen e admin me mesazh gabimi
                            $_SESSION['change-pwd'] = "<div class='error'>Dështoi në ndryshimin e fjalëkalimit. </div>";
                            //Redirect përdoruesin
                            header('location:' . SITEURL . 'admin/manage-admin.php');
                        }
                    } else {
                        // përcjellim për të menaxhuar faqen admin me mesazh gabimi
                        $_SESSION['pwd-not-match'] = "<div class='error'>Fjalëkalimi nuk ka patch. </div>";
                        // përcjellim përdoriminr
                        header('location:' . SITEURL . 'admin/manage-admin.php');
                    }
                } else {
                    //Përdoruesi nuk ekziston mesazh i caktuar dhe përcjellim
                    $_SESSION['user-not-found'] = "<div class='error'>Përdoruesi nuk u gjet.</div>";
                    //Redirect the User
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                }
            }

            //3. Kontrolloni nëse fjalëkalimi i ri dhe konfirmoni ndeshje fjalëkalimin ose jo

            //4. Ndryshoni fjalëkalimin nëse të gjitha më lart është e vërtetë
        }

        ?>
    </div>
    </

    <?php include('partials/footer.php'); ?>