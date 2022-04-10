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
                <button class="nav-link active fs-5 text-dark bg-transparent" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fa-solid fa-pen-to-square" style="font-size: 15px;"></i> Përditëso porosinë</button>
                <div class="vl" style="border-left: 2px solid black;height: 50px;"></div>
                <button class="nav-link fs-5 text-dark bg-transparent" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <i class="fa-solid fa-circle-info" style="font-size: 15px;"></i> Info</button>
            </div>
        </nav>

        <div class="tab-content mt-2" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <?php

                //CHeck whether id is set or not
                if (isset($_GET['id'])) {
                    //GEt the Order Details
                    $id = $_GET['id'];

                    //Get all other details based on this id
                    //SQL Query to get the order details
                    $sql = "SELECT * FROM tbl_order WHERE id=$id";
                    //Execute Query
                    $res = mysqli_query($conn, $sql);
                    //Count Rows
                    $count = mysqli_num_rows($res);

                    if ($count == 1) {
                        //Detail Availble
                        $row = mysqli_fetch_assoc($res);

                        $food = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $status = $row['status'];
                        $customer_name = $row['customer_name'];
                        $customer_contact = $row['customer_contact'];
                        $customer_email = $row['customer_email'];
                        $customer_address = $row['customer_address'];
                    } else {
                        //DEtail not Available/
                        //Redirect to Manage Order
                        header('location:' . SITEURL . 'admin/manage-order.php');
                    }
                } else {
                    //REdirect to Manage ORder PAge
                    header('location:' . SITEURL . 'admin/manage-order.php');
                }

                ?>

                <form action="" method="POST">

                    <table class="table table-bordered mt-3">
                        <tr>
                            <td>Emri i ushqimit</td>
                            <td><?php echo $food; ?> </td>
                        </tr>

                        <tr>
                            <td>Qmimi</td>
                            <td>
                                <?php echo $price; ?> €
                            </td>
                        </tr>

                        <tr>
                            <td>Sasia</td>
                            <td>
                                <input type="number" name="qty" value="<?php echo $qty; ?>" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td>Statusi</td>
                            <td>
                                <select name="status" class="form-select">
                                    <option <?php if ($status == "Porositur") {
                                                echo "selected";
                                            } ?> value="Porositur">Porositur
                                    </option>
                                    <option <?php if ($status == "Në dërgim") {
                                                echo "selected";
                                            } ?> value="Në dërgim">Në
                                        dërgim</option>
                                    <option <?php if ($status == "Dorëzuar") {
                                                echo "selected";
                                            } ?> value="Dorëzuar">Dorëzuar
                                    </option>
                                    <option <?php if ($status == "Anuluar") {
                                                echo "selected";
                                            } ?> value="Anuluar">Anuluar
                                    </option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>Emri i klientit: </td>
                            <td>
                                <input type="text" name="customer_name" value="<?php echo $customer_name; ?>" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td>Kontakt i klientit: </td>
                            <td>
                                <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td>Email i klientit: </td>
                            <td>
                                <input type="text" name="customer_email" value="<?php echo $customer_email; ?>" class="form-control">
                            </td>
                        </tr>

                        <tr>
                            <td>Adresa e Klientit: </td>
                            <td>
                                <textarea name="customer_address" cols="30" rows="5" class="form-control"><?php echo $customer_address; ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="hidden" name="price" value="<?php echo $price; ?>">

                                <input type="submit" name="submit" value="Përditso porosinë" class="btn btn-success">
                            </td>
                        </tr>
                    </table>

                </form>


                <?php
                //CHeck whether Update Button is Clicked or Not
                if (isset($_POST['submit'])) {
                    //echo "Clicked";
                    //Get All the Values from Form
                    $id = $_POST['id'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty;

                    $status = $_POST['status'];

                    $customer_name = $_POST['customer_name'];
                    $customer_contact = $_POST['customer_contact'];
                    $customer_email = $_POST['customer_email'];
                    $customer_address = $_POST['customer_address'];

                    //Update the Values
                    $sql2 = "UPDATE tbl_order SET 
                    qty = $qty,
                    total = $total,
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'
                    WHERE id=$id
                ";

                    //Execute the Query
                    $res2 = mysqli_query($conn, $sql2);

                    //CHeck whether update or not
                    //And REdirect to Manage Order with Message
                    if ($res2 == true) {
                        //Updated
                        $_SESSION['update'] = "<div class='success'>Order Updated Successfully.</div>";
                        header('location:' . SITEURL . 'admin/manage-order.php');
                    } else {
                        //Failed to Update
                        $_SESSION['update'] = "<div class='error'>Failed to Update Order.</div>";
                        header('location:' . SITEURL . 'admin/manage-order.php');
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