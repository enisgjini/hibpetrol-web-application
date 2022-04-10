<?php include('partials/menu.php'); ?>


<?php
//1. Merrni ID të administratorit të përzgjedhur
$id = $_GET['id'];

//2. Krijo Query SQL për të marrë detajet
$sql = "SELECT * FROM tbl_admin WHERE id=$id";

//Ekzekutoni pyetjen
$res = mysqli_query($conn, $sql);

//Kontrolloni nëse pyetja është ekzekutuar apo jo
if ($res == true) {
    // Kontrolloni nëse të dhënat janë në dispozicion ose jo
    $count = mysqli_num_rows($res);
    //Kontrolloni nëse kemi të dhëna admin ose jo
    if ($count == 1) {
        // Merrni detajet
        //echo "admin në dispozicion";
        $row = mysqli_fetch_assoc($res);

        $full_name = $row['full_name'];
        $username = $row['username'];
    } else {
        //Redirect për të menaxhuar faqen admin
        header('location:' . SITEURL . 'admin/manage-admin.php');
    }
}

?>





















<a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">
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


<?php include('partials/footer.php'); ?>