<!DOCTYPE html>
<html lang="en">

<head>
    <title>HIB - Administratori</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <style>
        .col-sm {
            width: 18%;
            background-color: #069C54;
            margin: 1%;
            padding: 2%;
            float: left;
        }
    </style>
</head>

<body>
    <?php include('partials/menu.php'); ?>
    <div class="container" style="font-family: 'Poppins', sans-serif;">
        <nav>
            <div class="nav nav-pills nav-fill border border-dark p-2 rounded-3 " id="nav-tab" role="tablist">
                <button class="nav-link active fs-5 text-dark bg-transparent" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><i class="bi bi-house" style="font-size: 15px;"></i> Paneli i administratorit</button>
                <div class="vl" style="border-left: 2px solid black;height: 50px;"></div>
                <button class="nav-link fs-5 text-dark bg-transparent" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <i class="fa-solid fa-circle-info" style="font-size: 15px;"></i> Info</button>
            </div>
        </nav>
        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        ?>
        <div class="tab-content mt-2" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="row">
                    <div class="col-sm" style="border:1px solid transparent;color:white;border-radius:9px;">
                        <?php
                        $sql = "SELECT * FROM tbl_category";
                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($res);
                        ?>
                        <h1><?php echo $count; ?></h1>
                        <br />
                        Kategoritë e ushqimit
                    </div>
                    <div class="col-sm" style="border:1px solid transparent;color:white;border-radius:9px;">
                        <?php
                        $sql2 = "SELECT * FROM tbl_food";
                        $res2 = mysqli_query($conn, $sql2);
                        $count2 = mysqli_num_rows($res2);
                        ?>
                        <h1><?php echo $count2; ?></h1>
                        <br />
                        Ushqime
                    </div>
                    <div class="col-sm" style="border:1px solid transparent;color:white;border-radius:9px;">
                        <?php
                        $sql3 = "SELECT * FROM tbl_order";
                        $res3 = mysqli_query($conn, $sql3);
                        $count3 = mysqli_num_rows($res3);
                        ?>
                        <h1><?php echo $count3; ?></h1>
                        <br />
                        Totali i porosive
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm" style="border:1px solid transparent;color:white;border-radius:9px;">
                        <?php
                        $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";
                        $res4 = mysqli_query($conn, $sql4);
                        $row4 = mysqli_fetch_assoc($res4);
                        $total_revenue = $row4['Total'];
                        ?>
                        <h1><?php echo $total_revenue; ?> €</h1>
                        <br />
                        Të ardhura të gjeneruara
                    </div>
                    <div class="col-sm" style="border:1px solid transparent;color:white;border-radius:9px;">
                        <?php
                        $sql6 = "SELECT * FROM tbl_order WHERE status = 'Ordered'";
                        $res6 = mysqli_query($conn, $sql6);
                        $count6 = mysqli_num_rows($res6);
                        ?>
                        <h1><?php echo $count6; ?></h1>
                        <br />
                        Porositë në pritje
                    </div>
                    <div class="col-sm" style="border:1px solid transparent;color:white;border-radius:9px;">
                        <?php
                        $sql7 = "SELECT * FROM tbl_order WHERE status = 'On Delivery'";
                        $res7 = mysqli_query($conn, $sql7);
                        $count7 = mysqli_num_rows($res7);
                        ?>
                        <h1><?php echo $count7; ?></h1>
                        <br />
                        Porositë në dergim
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm" style="border:1px solid transparent;color:white;border-radius:9px;">
                        <?php
                        $sql7 = "SELECT * FROM tbl_order WHERE status = 'Cancelled'";
                        $res7 = mysqli_query($conn, $sql7);
                        $count7 = mysqli_num_rows($res7);
                        ?>
                        <h1><?php echo $count7; ?></h1>
                        <br />
                        Porositë e anuluara
                    </div>
                    <div class="col-sm" style="border:1px solid transparent;color:white;border-radius:9px;">
                        <?php
                        $sql8 = "SELECT * FROM tbl_admin";
                        $res8 = mysqli_query($conn, $sql8);
                        $count8 = mysqli_num_rows($res8);
                        ?>
                        <h1>
                            <?php echo $count8; ?>
                        </h1>
                        <br />
                        Administrator i sistemit
                    </div>
                </div>
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
    <div class="clearfix"></div>
    <?php include('partials/footer.php') ?>
</body>

</html>