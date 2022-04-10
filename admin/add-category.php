<?php
ob_start();
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<?php include('partials/menu.php'); ?>

<div class="container" style="font-family: 'Poppins', sans-serif;margin-bottom:50px;">
    <nav>
        <div class="nav nav-pills nav-fill border border-dark p-2 rounded-3 " id="nav-tab" role="tablist">
            <button class="nav-link active fs-5 text-dark bg-transparent" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fa-solid fa-plus-circle" style="font-size: 15px;"></i> Shto kategori</button>
            <div class="vl" style="border-left: 2px solid black;height: 50px;"></div>
            <button class="nav-link fs-5 text-dark bg-transparent" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                <i class="fa-solid fa-circle-info" style="font-size: 15px;"></i> Info</button>
        </div>
    </nav>
    <div class="tab-content mt-3" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

            <?php

            if (isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if (isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

            ?>


            <!-- Add CAtegory Form Starts -->
            <form action="" method="POST" enctype="multipart/form-data">

                <table class="table table-bordered">
                    <tr>
                        <td>Titull: </td>
                        <td>
                            <input type="text" class="form-control" name="title" placeholder="Titulli i kategorisë">
                        </td>
                    </tr>

                    <tr>
                        <td>Zgjidhni imazhin: </td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td>I paraqitur: </td>
                        <td>
                            <input class="form-check-input" type="radio" name="featured" value="Po"> Po
                            <input class="form-check-input" type="radio" name="featured" value="Jo"> Jo
                        </td>
                    </tr>

                    <tr>
                        <td>Aktive: </td>
                        <td>
                            <input class="form-check-input" type="radio" name="active" value="Po"> Po
                            <input class="form-check-input" type="radio" name="active" value="Jo"> Jo
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3">
                            <button type="submit" name="submit" value="" class="btn btn-success"><i class="fa-solid fa-circle-plus"></i> Shto kategorinë </button>
                        </td>
                    </tr>

                </table>

            </form>
            <!-- Add CAtegory Form Ends -->

            <?php

            //CHeck whether the Submit Button is Clicked or Not
            if (isset($_POST['submit'])) {
                //echo "Clicked";

                //1. Get the Value from CAtegory Form
                $title = $_POST['title'];

                //For Radio input, we need to check whether the button is selected or not
                if (isset($_POST['featured'])) {
                    //Get the VAlue from form
                    $featured = $_POST['featured'];
                } else {
                    //SEt the Default VAlue
                    $featured = "Jo";
                }

                if (isset($_POST['active'])) {
                    $active = $_POST['active'];
                } else {
                    $active = "Jo";
                }

                //Check whether the image is selected or not and set the value for image name accoridingly
                //print_r($_FILES['image']);

                //die();//Break the Code Here

                if (isset($_FILES['image']['name'])) {
                    //Upload the Image
                    //To upload image we need image name, source path and destination path
                    $image_name = $_FILES['image']['name'];

                    // Upload the Image only if image is selected
                    if ($image_name != "") {

                        //Auto Rename our Image
                        //Get the Extension of our image (jpg, png, gif, etc) e.g. "specialfood1.jpg"
                        // Duhet me shiku ↓
                        //$ext = end(explode('.', $image_name));

                        //Rename the Image
                        // Duhet me shiku ↓
                        //$image_name = "Food_Category_".rand(000, 999).'.'.//$ext; // e.g. Food_Category_834.jpg


                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/" . $image_name;

                        //Finally Upload the Image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Check whether the image is uploaded or not
                        //And if the image is not uploaded then we will stop the process and redirect with error message
                        if ($upload == false) {
                            //SEt message
                            $_SESSION['upload'] = "<div class='alert alert-danger' role='alert'>Dështoi në ngarkimin e imazhit. </div>";
                            //Redirect to Add CAtegory Page
                            header('location:' . SITEURL . 'admin/add-category.php');
                            //STop the Process
                            die();
                        }
                    }
                } else {
                    //Don't Upload Image and set the image_name value as blank
                    $image_name = "";
                }

                // Krijo Query SQL për të futur kategori në bazën e të dhënave
                $sql = "INSERT INTO tbl_category SET 
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                ";

                // Ekzekutoni pyetjen dhe ruani në bazën e të dhënave
                $res = mysqli_query($conn, $sql);

                //4. Check whether the query executed or not and data added or not
                if ($res == true) {
                    //Query Executed and Category Added
                    $_SESSION['add'] = "<div class='alert alert-success' role='alert'>Kategoria është shtuar me sukses.</div>";
                    //Redirect to Manage Category Page
                    header('location:' . SITEURL . 'admin/manage-category.php');
                } else {
                    //Failed to Add CAtegory
                    $_SESSION['add'] = "<div class='alert alert-danger' role='alert'>Dështoi në shtimin e kategorisë.</div>";
                    //Redirect to Manage Category Page
                    header('location:' . SITEURL . 'admin/add-category.php');
                }
            }

            ?>


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