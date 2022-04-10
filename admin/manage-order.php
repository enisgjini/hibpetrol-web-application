<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HIB</title>
    
</head>

<body>
    <?php include('partials/menu.php'); ?>

    <div class="container" style="font-family: 'Poppins', sans-serif;margin-bottom:50px;flex: 1;">
        <nav>
            <div class="nav nav-pills nav-fill border border-dark p-2 rounded-3 " id="nav-tab" role="tablist">
                <button class="nav-link active fs-5 text-dark bg-transparent" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fa-solid fa-location-dot" style="font-size: 15px;"></i> Menaxho porosinë e ushqimit</button>
                <div class="vl" style="border-left: 2px solid black;height: 50px;"></div>
                <button class="nav-link fs-5 text-dark bg-transparent" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <i class="fa-solid fa-circle-info" style="font-size: 15px;"></i> Info</button>
            </div>
        </nav>
        <div class="tab-content mt-2" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3 mb-3">
                    <button class="btn btn-success" onclick="printDiv()"><i class="fa-solid fa-print"></i> Printo tabelën</button>
                </div>
                <?php
                if (isset($_SESSION['update'])) {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
                ?>
                <div id="printableTable">
                    <table class="table table-hover table-bordered">
                        <tr class="table table-light">
                            <th width="5%">#</th>
                            <th width="10%">Data e porosisë</th>
                            <th width="10%">Ushqimi</th>
                            <th width="5%">Çmim</th>
                            <th width="5%">Sasia</th>
                            <th width="6%">Totali</th>
                            <th width="8%">Statusi</th>
                            <th width="10%">Konsumator</th>
                            <th width="10%">Kontakti</th>
                            <th width="15%">Email</th>
                            <th width="10%">Adresë</th>
                            <th>Veprime</th>
                        </tr>

                        <?php
                        
                        $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; 
                        
                        $res = mysqli_query($conn, $sql);
                        
                        $count = mysqli_num_rows($res);

                        $sn = 1; 

                        if ($count > 0) {
                            
                            while ($row = mysqli_fetch_assoc($res)) {
                                
                                $id = $row['id'];
                                $food = $row['food'];
                                $price = $row['price'];
                                $qty = $row['qty'];
                                $total = $row['total'];
                                $order_date = $row['order_date'];
                                $status = $row['status'];
                                $customer_name = $row['customer_name'];
                                $customer_contact = $row['customer_contact'];
                                $customer_email = $row['customer_email'];
                                $customer_address = $row['customer_address'];

                        ?>


                                <tr>
                                    <td><?php echo $sn++; ?> </td>
                                    <td><?php echo $order_date; ?></td>
                                    <td><?php echo $food; ?></td>
                                    <td><?php echo $price . ' €'; ?></td>
                                    <td><?php echo $qty; ?></td>
                                    <td><?php echo $total . ' €'; ?></td>


                                    <td>
                                        <?php
                                        

                                        if ($status == "Porositur") {
                                            echo "<label style='color: blue;'>$status</label>";
                                        } elseif ($status == "Në dërgim") {
                                            echo "<label style='color: orange;'>$status</label>";
                                        } elseif ($status == "Dorëzuar") {
                                            echo "<label style='color: green;'><b>$status</b></label>";
                                        } elseif ($status == "Anuluar") {
                                            echo "<label style='color: red;'>$status</label>";
                                        }
                                        ?>
                                    </td>

                                    <td><?php echo $customer_name; ?></td>
                                    <td><?php echo $customer_contact; ?></td>
                                    <td><?php echo $customer_email; ?></td>
                                    <td><?php echo $customer_address; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn btn-success">Përditso porosinë</a>
                                    </td>
                                </tr>

                        <?php

                            }
                        } else {
                            
                            echo "<tr><td colspan='12' class='error'>Porositë nuk janë të disponueshme</td></tr>";
                        }
                        ?>
                    </table>
                    <iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank" marginheight="40"></iframe>
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

        <!-- <?php include('partials/footer.php'); ?> -->
</body>

</html>

<script>
    function printDiv() {
        window.frames["print_frame"].document.body.innerHTML = document.getElementById("printableTable").innerHTML;
        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();
    }
</script>