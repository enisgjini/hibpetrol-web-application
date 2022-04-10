<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include('partials-front/menu.php'); ?>
    <!-- Seksioni i kërkimit të ushqimit fillon këtu -->
    <section class="food-search text-center">
        <div class="container">
            <?php
                // Merrni fjalen e kërkimit
                $search = $_POST['search'];
            ?>
            <h2>
                <a href="#" style="text-decoration:none;" class="text-white">
                    Ushqimet në kërkimin tuaj
                    "<?php echo $search; ?>"
                </a>
            </h2>
        </div>
    </section>
    <!-- Seksioni i kërkimit të ushqimit përfundon këtu -->

    <!-- Seksioni i menysë së ushqimit fillon këtu -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Menuja e ushqimit</h2>
            <?php
                // Query sql për të marrë ushqime bazuar në fjalën e kërkimit
                $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
                // Ekzekutoni pyetjen
                $res = mysqli_query($conn, $sql);
                // Rreshtat e numërimit
                $count = mysqli_num_rows($res);
                // Kontrolloni nëse ushqimi në dispozicion të jo
                if ($count>0) {
                    // Ushqimi në dispozicion
                    while ($row=mysqli_fetch_assoc($res)) {
                        // Merrni detajet
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name']; ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                    // Kontrolloni nëse emri i imazhit është i disponueshëm ose jo
                                    if ($image_name=="") {
                                        // Imazhi nuk është i disponueshëm
                                        echo "<div class='error'>Imazhi nuk është i disponueshëm.</div>";
                                    } else {
                                        // imazh në dispozicion?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza"
                                    class="img-thumbnail">
                                    <?php
                                    } ?>

                            </div>
                        
                        <div class="food-menu-desc">
                            <h4>
                                <?php echo $title; ?>
                            </h4>
                            <p class="food-price">
                                <?php echo $price; ?> €
                            </p>
                            <p class="food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>
                            <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-success">Porositë tani</a>
                </div>
            </div>
            <?php
                    }
                } else {
                    // Ushqimi nuk është i disponueshëm
                    echo "<div class='error'>Ushqimi nuk u gjet.</div>";
                }
            ?>
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Seksioni i menusë së ushqimit përfundon këtu -->
    <?php include('partials-front/footer.php'); ?>
</body>

</html>