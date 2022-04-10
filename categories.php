<?php include('partials-front/menu.php'); ?>

<!-- Seksioni i kategorive fillon ketu -->
<h2 class="text-center">Eksploroni ushqime</h2>
    <div class="container"> 
        <div class="row">
            <div class="col-sm">
                <?php 
                    // Shfaq të gjitha kategoritë që janë aktive
                    // Query SQL
                    $sql = "SELECT * FROM tbl_category WHERE active='Po'";
                    // Ekzekutoni pyetjen
                    $res = mysqli_query($conn, $sql);
                    // Rreshtat e numërimit
                    $count = mysqli_num_rows($res);
                    // Kontrolloni nëse kategoritë janë në dispozicion ose jo
                    if($count>0)
                    {
                        // Kategoritë në dispozicion
                        while($row=mysqli_fetch_assoc($res))
                        {
                            // Merrni vlerat
                            $id = $row['id'];
                            $title = $row['title'];
                            $image_name = $row['image_name'];
                ?>
                    <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                        <div class="box-3 float-container">
                                <?php 
                                    if($image_name==""){
                                                echo "<div class='error'>Imazhi nuk u gjet</div>"; // Imazhi nuk është i disponueshëm
                                    }
                                    else{ // Imazhi në dispozicion
                                ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" style="object-fit: cover;width: 100%;height: 200px;" class="img-thumbnail">
                            <button class="btn btn-success mt-2">
                                <?php echo $title; ?>
                            </button>
                            <?php } ?>
                        </div>
                    </a>
                    <?php } }
                        else{
                            echo "<div class='error'>Kategoria nuk u gjet.</div>"; // Kategoritë nuk janë në dispozicion 
                        } 
                    ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
<!--  Seksioni i kategorive perfundon ketu -->


<?php include('partials-front/footer.php'); ?>