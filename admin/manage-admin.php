<?php
ob_start();
?>
<?php include('partials/menu.php'); ?>


<div class="container" style="font-family: 'Poppins', sans-serif;margin-bottom:50px;flex: 1;">
    <nav>
        <div class="nav nav-pills nav-fill border border-dark p-2 rounded-3 " id="nav-tab" role="tablist">
            <button class="nav-link active fs-5 text-dark bg-transparent" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fa-solid fa-user-shield" style="font-size: 15px;"></i> Administratorët</button>
            <div class="vl" style="border-left: 2px solid black;height: 50px;"></div>
            <button class="nav-link fs-5 text-dark bg-transparent" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                <i class="fa-solid fa-circle-info" style="font-size: 15px;"></i> Info</button>
        </div>
    </nav>
    <div class="tab-content mt-2" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3 mb-3">

                <a href="add-admin.php" class="btn btn-success ">
                    <i class="fa-solid fa-circle-plus"></i> Shto administrator</a>

            </div>
            <?php
            if (isset($_SESSION['add'])) {
                echo $_SESSION['add']; //Displaying Session Message
                unset($_SESSION['add']); //REmoving Session Messsssssage
            }

            if (isset($_SESSION['delete'])) {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            if (isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

            if (isset($_SESSION['user-not-found'])) {
                echo $_SESSION['user-not-found'];
                unset($_SESSION['user-not-found']);
            }

            if (isset($_SESSION['pwd-not-match'])) {
                echo $_SESSION['pwd-not-match'];
                unset($_SESSION['pwd-not-match']);
            }

            if (isset($_SESSION['change-pwd'])) {
                echo $_SESSION['change-pwd'];
                unset($_SESSION['change-pwd']);
            }

            ?>






            <table class="table table-bordered">
                <tr class="table table-light">
                    <th>S.N.</th>
                    <th>Emri i plotë</th>
                    <th>Emri i përdoruesit</th>
                    <th>Veprime</th>
                </tr>


                <?php
                //Query to Get all Admin
                $sql = "SELECT * FROM tbl_admin";
                //Execute the Query
                $res = mysqli_query($conn, $sql);

                //CHeck whether the Query is Executed of Not
                if ($res == TRUE) {
                    // Count Rows to CHeck whether we have data in database or not
                    $count = mysqli_num_rows($res); // Function to get all the rows in database

                    $sn = 1; //Create a Variable and Assign the value

                    //CHeck the num of rows
                    if ($count > 0) {
                        //WE HAve data in database
                        while ($rows = mysqli_fetch_assoc($res)) {
                            //Using While loop to get all the data from database.
                            //And while loop will run as long as we have data in database

                            //Get individual DAta
                            $id = $rows['id'];
                            $full_name = $rows['full_name'];
                            $username = $rows['username'];

                            //Display the Values in our Table
                ?>

                            <tr>
                                <td><?php echo $sn++; ?>. </td>
                                <td><?php echo $full_name; ?></td>
                                <td><?php echo $username; ?></td>
                                <td>

                                    <a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Ndrysho fjalëkalimin
                                    </a>

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
                                                            <input type="password" class="form-control" name="current_password" placeholder="Fjalëkalimi aktual" id="fa" required oninvalid="this.setCustomValidity('Ju lutemi plotësoni këtë fushë')" oninput="this.setCustomValidity('')">
                                                            <label for="floatingInput">Fjalëkalimi aktual</label>
                                                        </div>

                                                        <div class="form-floating mb-3">
                                                            <input type="password" class="form-control" name="new_password" placeholder="Fjalëkalim i ri" id="fr" required oninvalid="this.setCustomValidity('Ju lutemi plotësoni këtë fushë')" oninput="this.setCustomValidity('')">
                                                            <label for="floatingInput">Fjalëkalim i ri</label>
                                                        </div>

                                                        <div class="form-floating mb-3">
                                                            <input type="password" class="form-control" name="confirm_password" placeholder="Konfirmo fjalëkalimin" id="kf" required oninvalid="this.setCustomValidity('Ju lutemi plotësoni këtë fushë')" oninput="this.setCustomValidity('')">
                                                            <label for="floatingInput">Konfirmo fjalëkalimin</label>
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
                                                    $sql2 = "UPDATE tbl_admin SET password='$new_password' WHERE id=$id";

                                                    //Ekzekutoni pyetjen
                                                    $res2 = mysqli_query($conn, $sql2);

                                                    //Kontrolloni nëse pyetja e ekzekutuar apo jo
                                                    if ($res2 == true) {
                                                        //Shfaq mesazhin e suksesit
                                                        //Redirect për të menaxhuar faqen e admin me mesazhin e suksesit
                                                        $_SESSION['change-pwd'] = "<div class='alert alert-success' role='alert'>Fjalëkalimi ndryshoi me sukses. </div>";
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
                                            }
                                        }

                                        //3. Kontrolloni nëse fjalëkalimi i ri dhe konfirmoni ndeshje fjalëkalimin ose jo

                                        //4. Ndryshoni fjalëkalimin nëse të gjitha më lart është e vërtetë
                                    }

                                    ?>



<a type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal1">
    Përditëso administratorin
</a>

<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Përditëso administratorin</h5>
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
                        <input type="text" class="form-control" name="full_name" value="<?php echo $full_name; ?>" onfocus="this.value=''" placeholder="Fjalëkalimi aktual" id="fa" required oninvalid="this.setCustomValidity('Ju lutemi plotësoni këtë fushë')" oninput="this.setCustomValidity('')">
                        <label for="floatingInput">Emri i plotë</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>" onfocus="this.value=''" placeholder="Emri i përdoruesit" id="fr" required oninvalid="this.setCustomValidity('Ju lutemi plotësoni këtë fushë')" oninput="this.setCustomValidity('')">
                        <label for="floatingInput">Fjalëkalim i ri:</label>
                    </div>


                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Përditëso administratorin" class="btn btn-success">

                </form>
            </div>
        </div>
    </div>
</div>



<?php

//Kontrolloni nëse butoni i dorëzimit është klikuar ose jo
if (isset($_POST['submit'])) {
    //Echo "Button klikuar";
    //Merrni të gjitha vlerat nga forma për t'u përditësuar
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];

    //Krijo një pyetje SQL për të përditësuar admin
    $sql = "UPDATE tbl_admin SET
        full_name = '$full_name',
        username = '$username' 
        WHERE id='$id'
        ";

    //Ekzekutoni pyetjen
    $res = mysqli_query($conn, $sql);

    //Kontrolloni nëse pyetja ekzekutohet me sukses ose jo
    if ($res == true) {
        //Query ekzekutuar dhe admin përditësuar
        $_SESSION['update'] = "<div class='success'>Administratori u përditësua me sukses.</div>";
        //Redirect to Manage Admin Page
        header('location:' . SITEURL . 'admin/manage-admin.php');
    } else {
        //Dështoi në përditësimin e administratorit
        $_SESSION['update'] = "<div class='error'>Dështoi në fshirjen e administratorit.</div>";
        //Redirect për të menaxhuar faqen admin
        header('location:' . SITEURL . 'admin/manage-admin.php');
    }
}

?>


                                    <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn btn-danger">Fshij administratorin</a>
                                </td>
                            </tr>

                <?php

                        }
                    } else {
                        //We Do not Have Data in Database
                    }
                }

                ?>



            </table>

        </div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum sem turpis, nec ornare mauris viverra nec. Praesent fringilla massa in aliquet egestas. Duis consequat aliquet mauris nec interdum. Pellentesque eget ante a sem fermentum mattis non interdum magna. Sed at laoreet magna. Integer enim tortor, tempus id commodo eget, iaculis vulputate velit. Etiam at elit auctor nulla ornare dignissim. Nulla id commodo neque. Suspendisse auctor ex tempor, cursus lorem vel, lobortis mi. Ut sed erat ac enim pharetra suscipit. Donec ac nulla volutpat, efficitur lorem non, facilisis nisi. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce eget lectus in augue efficitur congue a nec lacus.

                Sed feugiat ligula eu lacinia viverra. Integer convallis tortor elit, in ullamcorper risus porta ac. Nunc porttitor consequat massa sed lacinia. Vestibulum vel volutpat turpis. Aliquam porttitor enim ac lorem rutrum, ut ullamcorper justo aliquet. Curabitur non diam ornare, porttitor est ac, lobortis nisl. Integer egestas risus eros. Integer sollicitudin ullamcorper dapibus. Duis luctus euismod velit nec ultricies.

                Aenean scelerisque et ligula vel faucibus. In blandit diam nisi, ac sollicitudin urna tincidunt quis. Mauris et pharetra quam, et vehicula elit. Aenean fringilla, massa id ultricies viverra, lectus arcu efficitur risus, non volutpat neque risus et elit. Morbi a congue metus. Nulla et sapien sit amet risus convallis gravida sed sit amet purus. Fusce egestas lorem ut urna tempor, eget lobortis nunc consectetur.

                Suspendisse vitae finibus est. Nam in nulla quam. Fusce scelerisque faucibus orci ut facilisis. Etiam id tincidunt ante. Etiam tempor volutpat risus, eu dignissim urna vehicula ut. In hac habitasse platea dictumst. Nam sem ipsum, laoreet eu ex eu, consequat blandit lectus. Sed vulputate in ligula a feugiat. Nulla efficitur quam ac libero scelerisque aliquam.

                Duis sodales, orci in consequat rhoncus, sem nulla eleifend ex, a euismod sapien magna eget est. Nulla est arcu, ultrices sit amet auctor vitae, dictum nec dui. Nam rhoncus erat libero, ut aliquam tortor molestie at. Pellentesque id libero lectus. Morbi vulputate dui sit amet quam hendrerit, egestas mattis justo iaculis. Sed ut lorem congue, tristique massa eu, ultricies ipsum. Curabitur accumsan efficitur nisi, nec eleifend massa maximus a. Morbi at felis pellentesque, viverra risus vel, lacinia odio. Aenean feugiat ac sapien eu commodo. Proin sed nulla eget massa feugiat auctor. Ut dictum, libero ac viverra mattis, felis quam scelerisque ex, ut laoreet massa neque ac massa.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum sem turpis, nec ornare mauris viverra nec. Praesent fringilla massa in aliquet egestas. Duis consequat aliquet mauris nec interdum. Pellentesque eget ante a sem fermentum mattis non interdum magna. Sed at laoreet magna. Integer enim tortor, tempus id commodo eget, iaculis vulputate velit. Etiam at elit auctor nulla ornare dignissim. Nulla id commodo neque. Suspendisse auctor ex tempor, cursus lorem vel, lobortis mi. Ut sed erat ac enim pharetra suscipit. Donec ac nulla volutpat, efficitur lorem non, facilisis nisi. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Fusce eget lectus in augue efficitur congue a nec lacus.

                Sed feugiat ligula eu lacinia viverra. Integer convallis tortor elit, in ullamcorper risus porta ac. Nunc porttitor consequat massa sed lacinia. Vestibulum vel volutpat turpis. Aliquam porttitor enim ac lorem rutrum, ut ullamcorper justo aliquet. Curabitur non diam ornare, porttitor est ac, lobortis nisl. Integer egestas risus eros. Integer sollicitudin ullamcorper dapibus. Duis luctus euismod velit nec ultricies.

                Aenean scelerisque et ligula vel faucibus. In blandit diam nisi, ac sollicitudin urna tincidunt quis. Mauris et pharetra quam, et vehicula elit. Aenean fringilla, massa id ultricies viverra, lectus arcu efficitur risus, non volutpat neque risus et elit. Morbi a congue metus. Nulla et sapien sit amet risus convallis gravida sed sit amet purus. Fusce egestas lorem ut urna tempor, eget lobortis nunc consectetur.

                Suspendisse vitae finibus est. Nam in nulla quam. Fusce scelerisque faucibus orci ut facilisis. Etiam id tincidunt ante. Etiam tempor volutpat risus, eu dignissim urna vehicula ut. In hac habitasse platea dictumst. Nam sem ipsum, laoreet eu ex eu, consequat blandit lectus. Sed vulputate in ligula a feugiat. Nulla efficitur quam ac libero scelerisque aliquam.

                Duis sodales, orci in consequat rhoncus, sem nulla eleifend ex, a euismod sapien magna eget est. Nulla est arcu, ultrices sit amet auctor vitae, dictum nec dui. Nam rhoncus erat libero, ut aliquam tortor molestie at. Pellentesque id libero lectus. Morbi vulputate dui sit amet quam hendrerit, egestas mattis justo iaculis. Sed ut lorem congue, tristique massa eu, ultricies ipsum. Curabitur accumsan efficitur nisi, nec eleifend massa maximus a. Morbi at felis pellentesque, viverra risus vel, lacinia odio. Aenean feugiat ac sapien eu commodo. Proin sed nulla eget massa feugiat auctor. Ut dictum, libero ac viverra mattis, felis quam scelerisque ex, ut laoreet massa neque ac massa.</p>
        </div>
    </div>
    <!-- Main Content Setion Ends -->

    <!-- <?php include('partials/footer.php'); ?> -->