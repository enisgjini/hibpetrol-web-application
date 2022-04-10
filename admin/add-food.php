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
                <button class="nav-link active fs-5 text-dark bg-transparent" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fa-solid fa-bowl-food" style="font-size: 15px;"></i> Shtoni ushqim</button>
                <div class="vl" style="border-left: 2px solid black;height: 50px;"></div>
                <button class="nav-link fs-5 text-dark bg-transparent" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <i class="fa-solid fa-circle-info" style="font-size: 15px;"></i> Info</button>
            </div>
        </nav>

        <div class="tab-content mt-2" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                <?php
                if (isset($_SESSION['upload'])) {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }
                ?>

                <form action="" method="POST" enctype="multipart/form-data">

                    <table class="table table-bordered mt-3">

                        <tr>
                            <td>Titulli:</td>
                            <td>
                                <input type="text" class="form-control" name="title" placeholder="Titulli i ushqimit">
                            </td>
                        </tr>

                        <tr>
                            <td>Përshkrim: </td>
                            <td>
                                <textarea name="description" class="form-control" cols="30" rows="5" placeholder="Përshkrimi i ushqimit"></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td>Çmim: </td>
                            <td>
                                <input type="text" class="form-control" name="price">
                            </td>
                        </tr>

                        <tr>
                            <td>Zgjidhni imazhin: </td>
                            <td>
                                <input type="file" class="form-control" name="image">
                            </td>
                        </tr>

                        <tr>
                            <td>Kategori: </td>
                            <td>
                                <select name="category" class="form-select">

                                    <?php
                                    //Create PHP Code to display categories from Database
                                    //1. CReate SQL to get all active categories from database
                                    $sql = "SELECT * FROM tbl_category WHERE active='Po'";

                                    //Executing qUery
                                    $res = mysqli_query($conn, $sql);

                                    //Count Rows to check whether we have categories or not
                                    $count = mysqli_num_rows($res);

                                    //IF count is greater than zero, we have categories else we donot have categories
                                    if ($count > 0) {
                                        //WE have categories
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            //get the details of categories
                                            $id = $row['id'];
                                            $title = $row['title'];

                                    ?>

                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                        <?php
                                        }
                                    } else {
                                        //WE do not have category
                                        ?>
                                        <option value="0">Nuk u gjet asnjë kategori</option>
                                    <?php
                                    }


                                    //2. Display on Drpopdown
                                    ?>

                                </select>
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
                            <td colspan="2">
                                <input type="submit" name="submit" value="Shtoni ushqim" class="btn btn-success">
                            </td>
                        </tr>

                    </table>

                </form>


                <?php

                //CHeck whether the button is clicked or not
                if (isset($_POST['submit'])) {
                    //Add the Food in Database
                    //echo "Clicked";

                    //1. Get the DAta from Form
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $category = $_POST['category'];

                    //Check whether radion button for featured and active are checked or not
                    if (isset($_POST['featured'])) {
                        $featured = $_POST['featured'];
                    } else {
                        $featured = "No"; //SEtting the Default Value
                    }

                    if (isset($_POST['active'])) {
                        $active = $_POST['active'];
                    } else {
                        $active = "No"; //Setting Default Value
                    }

                    //2. Upload the Image if selected
                    //Check whether the select image is clicked or not and upload the image only if the image is selected
                    if (isset($_FILES['image']['name'])) {
                        //Get the details of the selected image
                        $image_name = $_FILES['image']['name'];

                        //Check Whether the Image is Selected or not and upload image only if selected
                        if ($image_name != "") {
                            // Image is SElected
                            //A. REnamge the Image
                            //Get the extension of selected image (jpg, png, gif, etc.)
                            $ext = end(explode('.', $image_name));

                            // Create New Name for Image
                            $image_name = "Food-Name-" . rand(0000, 9999) . "." . $ext; //New Image Name May Be "Food-Name-657.jpg"

                            //B. Upload the Image
                            //Get the Src Path and DEstinaton path

                            // Source path is the current location of the image
                            $src = $_FILES['image']['tmp_name'];

                            //Destination Path for the image to be uploaded
                            $dst = "../images/food/" . $image_name;

                            //Finally Uppload the food image
                            $upload = move_uploaded_file($src, $dst);

                            //check whether image uploaded of not
                            if ($upload == false) {
                                //Failed to Upload the image
                                //REdirect to Add Food Page with Error Message
                                $_SESSION['upload'] = "<div class='error'>Dështoi në ngarkimin e imazhit.</div>";
                                header('location:' . SITEURL . 'admin/add-food.php');
                                //STop the process
                                die();
                            }
                        }
                    } else {
                        $image_name = ""; //SEtting DEfault Value as blank
                    }

                    //3. Insert Into Database

                    //Create a SQL Query to Save or Add food
                    // For Numerical we do not need to pass value inside quotes '' But for string value it is compulsory to add quotes ''
                    $sql2 = "INSERT INTO tbl_food SET 
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'
                ";

                    //Execute the Query
                    $res2 = mysqli_query($conn, $sql2);

                    //CHeck whether data inserted or not
                    //4. Redirect with MEssage to Manage Food page
                    if ($res2 == true) {
                        //Data inserted Successfullly
                        $_SESSION['add'] = "<div class='success'>Ushqimi u shtua me sukses.</div>";
                        header('location:' . SITEURL . 'admin/manage-food.php');
                    } else {
                        //FAiled to Insert Data
                        $_SESSION['add'] = "<div class='error'>Nuk arriti të shtojë ushqim.</div>";
                        header('location:' . SITEURL . 'admin/manage-food.php');
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
    </div>

    <!-- <?php include('partials/footer.php'); ?> -->
</body>

</html>