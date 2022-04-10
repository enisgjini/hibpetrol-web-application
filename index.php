<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HIB</title>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Bootstrap Table -->
    <link href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.19.1/dist/extensions/print/bootstrap-table-print.min.js"></script>
</head>

<body>
    <?php require('partials-front/menu.php'); ?>

    <!-- Seksioni i kërkimit të ushqimit fillon këtu -->
    <section class="food-search text-center">
        <div class="container">
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Kërko ushqime" required>
                <input type="submit" name="submit" value="Kërko" class="btn btn-success btn-lg">
            </form>
        </div>
    </section>
    <!-- Seksioni i kërkimit të ushqimit përfundon këtu -->
    <?php
    if (isset($_SESSION['order'])) {
        echo $_SESSION['order'];
        unset($_SESSION['order']);
    }
    ?>
    <!-- Seksioni i kategorive fillon këtu -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Eksploroni kategori të ndryshme ushqimore</h2>
            <?php
            // Krijo Query SQL për të shfaqur kategoritë nga baza e të dhënave
            $sql = "SELECT * FROM tbl_category WHERE active='Po' AND featured='Po' ORDER BY id ASC LIMIT 6"; 
            //Execute the Query
            $res = mysqli_query($conn, $sql);
            // Count rows to check whether the category is available or not
            $count = mysqli_num_rows($res);

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {

                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
            ?>
                    <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                        <div class="box-3 float-container">
                            <?php
                            if ($image_name == "") {
                                echo "<div class='error'>Imazhi nuk është i disponueshëm</div>";
                            } else {
                            ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" style="object-fit: cover;
  width: 100%;
  height: 200px;" class="img-thumbnail">
                            <?php
                            }
                            ?>


                            <button class="btn btn-success mt-2">
                                <?php echo $title; ?>
                            </button>

                        </div>
                    </a>

            <?php
                }
            } else {
                //Categories not Available
                echo "<div class='error'>Kategoria nuk u shtua.</div>";
            }
            ?>


            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Menuja jonë e ushqimit</h2>

            <?php

            //Getting Foods from Database that are active and featured
            //SQL Query
            $sql2 = "SELECT * FROM tbl_food WHERE active='Po' AND featured='Po' LIMIT 6";

            //Execute the Query
            $res2 = mysqli_query($conn, $sql2);

            //Count Rows
            $count2 = mysqli_num_rows($res2);

            //CHeck whether food available or not
            if ($count2 > 0) {
                //Food Available
                while ($row = mysqli_fetch_assoc($res2)) {
                    //Get all the values
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
            ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                            //Check whether image available or not
                            if ($image_name == "") {
                                //Image not Available
                                echo "<div class='error'>Imazhi nuk është i disponueshëm</div>";
                            } else {
                                //Image Available
                            ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" style="object-fit: cover;
  width: 100%;
  height: 200px;">
                            <?php
                            }
                            ?>

                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="food-price">$<?php echo $price; ?></p>
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
                //Food Not Available 
                echo "<div class='error'>Ushqimi nuk është në dispozicion.</div>";
            }

            ?>





            <div class="clearfix"></div>



        </div>

        <p class="text-center mt-5">
            <a href="foods.php" class="btn btn-success">Shihni të gjitha ushqimet</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->


    <?php include('partials-front/footer.php'); ?>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>


</html>