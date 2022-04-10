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

    <?php
    //CHeck whether id is set or not
    if (isset($_GET['id'])) {
        //Get all the details
        $id = $_GET['id'];
        //SQL Query to Get the Selected Food
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
        //execute the Query
        $res2 = mysqli_query($conn, $sql2);
        //Get the value based on query executed
        $row2 = mysqli_fetch_assoc($res2);
        //Get the Individual Values of Selected Food
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    } else {
        //Redirect to Manage Food
        header('location:' . SITEURL . 'admin/manage-food.php');
    }
    ?>


    <div class="container" style="font-family: 'Poppins', sans-serif;margin-bottom:50px;">
        <nav>
            <div class="nav nav-pills nav-fill border border-dark p-2 rounded-3 " id="nav-tab" role="tablist">
                <button class="nav-link active fs-5 text-dark bg-transparent" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fa-solid fa-bowl-food" style="font-size: 15px;"></i> Artikuj ushqimorë</button>
                <div class="vl" style="border-left: 2px solid black;height: 50px;"></div>
                <button class="nav-link fs-5 text-dark bg-transparent" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <i class="fa-solid fa-circle-info" style="font-size: 15px;"></i> Info</button>
            </div>
        </nav>
        <div class="tab-content mt-2" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">


                <form action="" method="POST" enctype="multipart/form-data">

                    <table class="table table-bordered mt-3">

                        <tr>
                            <td>Titull: </td>
                            <td>
                                <input type="text" class="form-control" name="title" value="<?php echo $title; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td>Përshkrimi: </td>
                            <td>
                                <textarea name="description" class="form-control" cols="30" rows="10"><?php echo $description; ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td>Çmimi: </td>
                            <td>
                                <input type="number" class="form-control" name="price" value="<?php echo $price; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td>Imazhi aktual: </td>
                            <td>
                                <?php
                                if ($current_image == "") {
                                    //Image not Available
                                    echo "<div class='error'>Image not Available.</div>";
                                } else {
                                    //Image Available

                                ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                                <?php
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td>Zgjidhni imazhin e ri: </td>
                            <td>
                                <input type="file" class="form-control" name="image">
                            </td>
                        </tr>

                        <tr>
                            <td>Kategoria: </td>
                            <td>
                                <select name="category" class="form-select">

                                    <?php
                                    //Query to Get ACtive Categories
                                    $sql = "SELECT * FROM tbl_category WHERE active='Po'";
                                    //Execute the Query
                                    $res = mysqli_query($conn, $sql);
                                    //Count Rows
                                    $count = mysqli_num_rows($res);
                                    //Check whether category available or not
                                    if ($count > 0) {
                                        //CAtegory Available
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $category_title = $row['title'];
                                            $category_id = $row['id'];
                                            //echo "<option value='$category_id'>$category_title</option>";

                                    ?>
                                            <option <?php if ($current_category == $category_id) {
                                                        echo "selected";
                                                    } ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                    <?php
                                        }
                                    } else {
                                        //CAtegory Not Available
                                        echo "<option value='0'>Kategoria nuk është e disponueshme.</option>";
                                    }
                                    ?>

                                </select>
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
                            <td>Active: </td>
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
                                <input type="hidden" name="id" class="form-control" value="<?php echo $id; ?>">
                                <input type="hidden" name="current_image" class="form-control" value="<?php echo $current_image; ?>">

                                <input type="submit" name="submit" value="Përditëso ushqimin" class="btn btn-success">
                            </td>
                        </tr>

                    </table>

                </form>

                <?php
                if (isset($_POST['submit'])) {
                    //echo "Button Clicked";
                    //1. Get all the details from the form
                    $id = $_POST['id'];
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $current_image = $_POST['current_image'];
                    $category = $_POST['category'];
                    $featured = $_POST['featured'];
                    $active = $_POST['active'];
                    //2. Upload the image if selected
                    //CHeck whether upload button is clicked or not
                    if (isset($_FILES['image']['name'])) {
                        //Upload BUtton Clicked
                        $image_name = $_FILES['image']['name']; //New Image NAme
                        //CHeck whether th file is available or not
                        if ($image_name != "") {
                            //IMage is Available
                            //A. Uploading New Image
                            //REname the Image
                            $ext = end(explode('.', $image_name)); //Gets the extension of the image
                            $image_name = "Food-Name-" . rand(0000, 9999) . '.' . $ext; //THis will be renamed image
                            //Get the Source Path and DEstination PAth
                            $src_path = $_FILES['image']['tmp_name']; //Source Path
                            $dest_path = "../images/food/" . $image_name; //DEstination Path
                            //Upload the image
                            $upload = move_uploaded_file($src_path, $dest_path);
                            /// CHeck whether the image is uploaded or not
                            if ($upload == false) {
                                //FAiled to Upload
                                $_SESSION['upload'] = "<div class='error'>Dështoi në ngarkimin e imazhit të ri.</div>";
                                //REdirect to Manage Food
                                header('location:' . SITEURL . 'admin/manage-food.php');
                                //Stop the Process
                                die();
                            }
                            //3. Remove the image if new image is uploaded and current image exists
                            //B. Remove current Image if Available
                            if ($current_image != "") {
                                //Current Image is Available
                                //REmove the image
                                $remove_path = "../images/food/" . $current_image;
                                $remove = unlink($remove_path);
                                //Check whether the image is removed or not
                                if ($remove == false) {
                                    //failed to remove current image
                                    $_SESSION['remove-failed'] = "<div class='error'>Dështoi në heqjen e imazhit aktual.</div>";
                                    //redirect to manage food
                                    header('location:' . SITEURL . 'admin/manage-food.php');
                                    //stop the process
                                    die();
                                }
                            }
                        } else {
                            $image_name = $current_image; //Default Image when Image is Not Selected

                        }
                    } else {
                        $image_name = $current_image; //Default Image when Button is not Clicked

                    }
                    //4. Update the Food in Database
                    $sql3 = "UPDATE tbl_food SET 
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";
                    //Execute the SQL Query
                    $res3 = mysqli_query($conn, $sql3);
                    //CHeck whether the query is executed or not
                    if ($res3 == true) {
                        //Query Exectued and Food Updated
                        $_SESSION['update'] = "<div class='success'>Ushqimi u përditësua me sukses.</div>";
                        header('location:' . SITEURL . 'admin/manage-food.php');
                    } else {
                        //Failed to Update Food
                        $_SESSION['update'] = "<div class='error'>Dështoi në përditësimin e ushqimit.</div>";
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