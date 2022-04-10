<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <?php include('partials-front/menu.php'); ?>
    <?php 
        //CHeck whether id is passed or not
        if(isset($_GET['category_id']))
        {
            // Kategoria ID është vendosur dhe për të marrë ID
            $category_id = $_GET['category_id'];
            // Merrni kategorinë e kategorisë në bazë të kategorisë ID
            $sql = "SELECT title FROM tbl_category WHERE id=$category_id";
            // Ekzekutoni pyetjen
            $res = mysqli_query($conn, $sql);
            // Merrni vlerën nga baza e të dhënave
            $row = mysqli_fetch_assoc($res);
            // Merrni titullin
            $category_title = $row['title'];
        }
        else
        {
            // Kategoria nuk kalon
            // Redirect në faqen kryesore
            header('location:'.SITEURL);
        }
    ?>
    <!-- Seksioni i kërkimit të ushqimit fillon këtu -->
    <section class="food-search text-center">
        <div class="container">
            <h2>
                <a href="#" class="text-white" style='"'>Ushqimet në "<?php echo $category_title; ?>"</a>
            </h2>
        </div>
    </section>
    <!-- Seksioni i kërkimit të ushqimit përfundon këtu -->



    <!-- Seksioni i menysë së ushqimit fillon këtu -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Menu e ushqimit</h2>
            <?php 
                // Krijo pyetjen SQL për të marrë ushqime të bazuara në kategorinë e zgjedhur
                $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

                // Ekzekutoni pyetjen
                $res2 = mysqli_query($conn, $sql2);

                // Numëroni rreshtat
                $count2 = mysqli_num_rows($res2);

                // Kontrolloni nëse ushqimi është i disponueshëm ose jo
                if($count2>0) 
                {   
                    while($row2=mysqli_fetch_assoc($res2)) // Ushqimi është në dispozicion
                    {
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $description = $row2['description'];
                        $image_name = $row2['image_name'];
                        ?>
            <div class="food-menu-box">
                <div class="food-menu-img">
                    <?php 
                        if($image_name==""){
                            echo "<div class='error'>Imazhi nuk është i disponueshëm.</div>";  // Imazhi nuk është i disponueshëm
                        }
                        else { ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" class="img-thumbnail">
                        <?php } ?>
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
                    <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-success">
                        Porosit tani
                    </a>
                </div>
            </div>
            <?php } }
                else {
                    echo "<div class='error'>Ushqimi nuk është në dispozicion.</div>"; // Ushqimi nuk është në dispozicion
                }
            ?>
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Seksioni i menusë së ushqimit përfundon këtu -->

    <!-- Footer -->
    <?php include('partials-front/footer.php'); ?>
</body>

</html>