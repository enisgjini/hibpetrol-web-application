<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <?php include('partials/menu.php'); ?>

    <div class="container" style="font-family: 'Poppins', sans-serif;margin-bottom:50px;">
        <nav>
            <div class="nav nav-pills nav-fill border border-dark p-2 rounded-3 " id="nav-tab" role="tablist">
                <button class="nav-link active fs-5 text-dark bg-transparent" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fa-solid fa-plus-circle" style="font-size: 15px;"></i> Përditso kategorinë</button>
                <div class="vl" style="border-left: 2px solid black;height: 50px;"></div>
                <button class="nav-link fs-5 text-dark bg-transparent" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <i class="fa-solid fa-circle-info" style="font-size: 15px;"></i> Info</button>
            </div>
        </nav>
        <div class="tab-content mt-3" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <?php

                //Check whether the id is set or Jot
                if (isset($_GET['id'])) {
                    //Get the ID and all other details
                    //echo "Getting the Data";
                    $id = $_GET['id'];
                    //Create SQL Query to get all other details
                    $sql = "SELECT * FROM tbl_category WHERE id=$id";

                    //Execute the Query
                    $res = mysqli_query($conn, $sql);

                    //Count the Rows to check whether the id is valid or Jot
                    $count = mysqli_num_rows($res);

                    if ($count == 1) {
                        //Get all the data
                        $row = mysqli_fetch_assoc($res);
                        $title = $row['title'];
                        $current_image = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                    } else {
                        //redirect to manage category with session message
                        $_SESSION['Jo-category-found'] = "<div class='error'>Kategoria nuk u gjet.</div>";
                        header('location:' . SITEURL . 'admin/manage-category.php');
                    }
                } else {
                    //redirect to Manage CAtegory
                    header('location:' . SITEURL . 'admin/manage-category.php');
                }

                ?>

                <form action="" method="POST" enctype="multipart/form-data">

                    <table class="table table-bordered mt-3">
                        <tr>
                            <td>Titull: </td>
                            <td>
                                <input type="text" class="form-control" name="title" value="<?php echo $title; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td>Imazhi aktual: </td>
                            <td>
                                <?php
                                if ($current_image != "") {
                                    //Display the Image
                                ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" class="img-responsive img-rounded"
                   style="max-height: 100px; max-width: 100px;">
                                <?php
                                } else {
                                    //Display Message
                                    echo "<div class='error'>Imazhi nuk është shtuar.</div>";
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Imazhi i ri: </td>
                            <td>
                                <input class="form-control" type="file" name="image">
                            </td>
                        </tr>

                        <tr>
                            <td>I paraqitur: </td>
                            <td>
                                <input <?php if ($featured == "Po") {
                                            echo "checked";
                                        } ?> type="radio" class="form-check-input" name="featured" value="Po"> Po

                                <input <?php if ($featured == "Jo") {
                                            echo "checked";
                                        } ?> type="radio" class="form-check-input" name="featured" value="Jo"> Jo
                            </td>
                        </tr>

                        <tr>
                            <td>Aktive: </td>
                            <td>
                                <input <?php if ($active == "Po") {
                                            echo "checked";
                                        } ?> type="radio" class="form-check-input" name="active" value="Po"> Po

                                <input <?php if ($active == "Jo") {
                                            echo "checked";
                                        } ?> type="radio" class="form-check-input" name="active" value="Jo"> Jo
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="submit" name="submit" value="Përditëso kategorinë" class="btn btn-success">
                            </td>
                        </tr>

                    </table>

                </form>

                <?php

                if (isset($_POST['submit'])) {
                    //echo "Clicked";
                    //1. Get all the values from our form
                    $id = $_POST['id'];
                    $title = $_POST['title'];
                    $current_image = $_POST['current_image'];
                    $featured = $_POST['featured'];
                    $active = $_POST['active'];

                    //2. Updating New Image if selected
                    //Check whether the image is selected or Jot
                    if (isset($_FILES['image']['name'])) {
                        //Get the Image Details
                        $image_name = $_FILES['image']['name'];

                        //Check whether the image is available or Jot
                        if ($image_name != "") {
                            //Image Available

                            //A. UPload the New Image

                            //Auto Rename our Image
                            //Get the Extension of our image (jpg, png, gif, etc) e.g. "specialfood1.jpg"
                            $ext = end(explode('.', $image_name));

                            //Rename the Image
                            $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext; // e.g. Food_Category_834.jpg


                            $source_path = $_FILES['image']['tmp_name'];

                            $destination_path = "../images/category/" . $image_name;

                            //Finally Upload the Image
                            $upload = move_uploaded_file($source_path, $destination_path);

                            //Check whether the image is uploaded or Jot
                            //And if the image is Jot uploaded then we will stop the process and redirect with error message
                            if ($upload == false) {
                                //SEt message
                                $_SESSION['upload'] = "<div class='error'>Dështoi në ngarkimin e imazhit. </div>";
                                //Redirect to Add CAtegory Page
                                header('location:' . SITEURL . 'admin/manage-category.php');
                                //STop the Process
                                die();
                            }

                            //B. Remove the Current Image if available
                            if ($current_image != "") {
                                $remove_path = "../images/category/" . $current_image;

                                $remove = unlink($remove_path);

                                //CHeck whether the image is removed or Jot
                                //If failed to remove then display message and stop the processs
                                if ($remove == false) {
                                    //Failed to remove image
                                    $_SESSION['failed-remove'] = "<div class='error'>Dështoi në heqjen e imazhit aktual.</div>";
                                    header('location:' . SITEURL . 'admin/manage-category.php');
                                    die(); //Stop the Process
                                }
                            }
                        } else {
                            $image_name = $current_image;
                        }
                    } else {
                        $image_name = $current_image;
                    }

                    //3. Përditësoni bazën e të dhënave
                    $sql2 = "UPDATE tbl_category SET 
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active' 
                    WHERE id=$id
                ";

                    //Ekzekutoni pyetjen
                    $res2 = mysqli_query($conn, $sql2);

                    //4. Redirect për të menaxhuar kategorinë me mesazhin
                    // Kontrolloni nëse ekzekutohen apo jo
                    if ($res2 == true) {
                        //Kategoria përditësuar
                        $_SESSION['update'] = "<div class='success'>Kategoria është përditësuar me sukses.</div>";
                        header('location:' . SITEURL . 'admin/manage-category.php');
                    } else {
                        //Dështoi në përditësimin e kategorisë
                        $_SESSION['update'] = "<div class='error'>Dështoi në përditësimin e kategorisë.</div>";
                        header('location:' . SITEURL . 'admin/manage-category.php');
                    }
                }

                ?>
            </div>
            <!-- Another -->
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
    </div>

    <!-- <?php include('partials/footer.php'); ?> -->
</body>

</html>