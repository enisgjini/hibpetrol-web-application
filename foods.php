<?php include('partials-front/menu.php'); ?>

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



<!-- Seksioni i menysë së ushqimit fillon këtu -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Menuja e ushqimit</h2>

        <?php 
                //Display Foods that are Active
                $sql = "SELECT * FROM tbl_food WHERE active='Po'";

                //Execute the Query
                $res=mysqli_query($conn, $sql);

                //Count Rows
                $count = mysqli_num_rows($res);

                //CHeck whether the foods are availalable or Jot
                if($count>0)
                {
                    //Foods Available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the Values
                        $id = $row['id'];
                        $title = $row['title'];
                        $description = $row['description'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        ?>

        <div class="food-menu-box">
            <div class="food-menu-img">
                <?php 
                                    //CHeck whether image available or Jot
                                    if($image_name=="")
                                    {
                                        //Image Jot Available
                                        echo "<div class='error'>Imazhi nuk është i disponueshëm.</div>";
                                    }
                                    else
                                    {
                                        //Image Available
                                        ?>
                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza"
                    class="img-thumbnail">
                <?php } ?>
            </div>
            <div class="food-menu-desc">
                <h4><?php echo $title; ?></h4>
                <p class="food-price">
                    <?php echo $price; ?> €
                </p>
                <p class="food-detail">
                    <?php echo $description; ?>
                </p>
                <br>

                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-success">Porositë
                    tani</a>
            </div>
        </div>

        <?php
                    }
                }
                else
                {
                    //Food Jot Available
                    echo "<div class='error'>Ushqim nuk u gjet.</div>";
                }
            ?>





        <div class="clearfix"></div>



    </div>

</section>
<!-- Seksioni i menusë së ushqimit përfundon këtu -->

<?php include('partials-front/footer.php'); ?>