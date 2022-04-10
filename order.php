<?php
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
</head>

<body>

    <?php include('partials-front/menu.php'); ?>

    <section class="food-search text-center">
        <h2 class="text-center text-white">Plotësoni këtë formular për të konfirmuar porosinë tuaj.</h2>
    </section>
    <?php 
    // CHeck whether food id is set or not
    if(isset($_GET['food_id']))
    {
        //Get the Food id and details of the selected food
        $food_id = $_GET['food_id'];

        //Get the DEtails of the SElected Food
        $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
        //Execute the Query
        $res = mysqli_query($conn, $sql);
        //Count the rows
        $count = mysqli_num_rows($res);
        //CHeck whether the data is available or not
        if($count==1)
        {
            //WE Have DAta
            //GEt the Data from Database
            $row = mysqli_fetch_assoc($res);

            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];
        }
        else
        {
            //Food not Availabe
            //REdirect to Home Page
            header('location:'.SITEURL);
        }
    }
    else
    {
        // Redirect në faqen kryesore
        header('location:'.SITEURL);
    }
?>

    <!-- Seksioni i kërkimit të ushqimit fillon këtu -->
    <form action="" method="POST" class="order">


        <div class="container px-4 mt-5">
            <div class="row gx-5">
                <div class="col">
                    <div class="p-3 border bg-light rounded-2 shadow p-3 mb-5 rounded">
                        <h4>Ushqimi i zgjedhur</h4>
                        <hr>
                        <?php 
    
        // Kontrolloni nëse imazhi është i disponueshëm ose jo
        if($image_name=="")
        {
            // Imazhi nuk është i disponueshëm
            echo "<div class='error'>Imazhi nuk është i disponueshëm.</div>";
        }
        else
        {
            // Imazhi është në dispozicion
            ?>
                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>"
                        style="    object-fit: cover;
    width: 100%;
    height: 500px;">
                        <?php
        }
    
    ?>  
                        <hr>
                        
                        <h4 class="mt-5"><?php echo $title; ?></h4>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price"><?php echo $price; ?> €</p>
                        <input type="hidden" class="form-control" name="price" value="<?php echo $price; ?>">
                    </div>
                </div>
                <div class="col">
                    <div class="p-3 border bg-light rounded-2 shadow p-3 mb-5 rounded">
                        <div class="  mt-2">Emri i plotë</div>
                        <input type="text" name="full-name" placeholder="Emri..." class="form-control mt-2"
                            required>

                        <div class="mt-2">Numri i telefonit</div>
                        <input type="tel" name="contact" placeholder="Nr. i telefonit..." class="form-control mt-2" required>

                        <div class="  mt-2">Email</div>
                        <input type="email" name="email" placeholder="john@gmail.com" class="form-control mt-2"
                            required>

                        <div class="  mt-2">Adresë</div>
                        <textarea name="address" rows="10" placeholder="Adresa..." class="form-control mt-2"
                            required></textarea>
                        <br>
                        <div class="  mt-2">Sasia</div>
                        <input type="number" name="qty" class="form-control mt-2" value="1" required>
                        <br>
                        <input type="submit" name="submit" value="Konfirmoni porosinë" class="btn btn-success">
                    </div>
                </div>
            </div>
        </div>
    </form>
        <?php 
            // Kontrolloni nëse është klikuar ose jo
            if(isset($_POST['submit']))
            {
                // Merrni të gjitha detajet nga forma

                $food = $_POST['food'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];
                $total = $price * $qty; 
                $order_date = date("Y-m-d h:i:sa"); // Data e porosisë
                $status = "Porositur";  // Ordered, On Delivery, Delivered, Cancelled
                $customer_name = $_POST['full-name'];
                $customer_contact = $_POST['contact'];
                $customer_email = $_POST['email'];
                $customer_address = $_POST['address'];
                // Ruaj rendin në bazën e të dhënave
                // Krijo SQL për të ruajtur të dhënat
                $sql2 = "INSERT INTO tbl_order SET 
                    food = '$food',
                    price = $price,
                    qty = $qty,
                    total = $total,
                    order_date = '$order_date',
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'
                ";
                //echo $sql2; die();

                // Ekzekutoni pyetjen
                $res2 = mysqli_query($conn, $sql2);

                // Kontrolloni nëse pyetja ekzekutohet me sukses apo jo
                if($res2==true)
                {
                    // Query ekzekutuar dhe urdhër të ruajtur
                    $_SESSION['order'] = "<div class='modal' tabindex='-1'>
                    <div class='modal-dialog'>
                      <div class='modal-content'>
                        <div class='modal-header'>
                          <h5 class='modal-title'>Modal title</h5>
                          <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                          <p>Modal body text goes here.</p>
                        </div>
                        <div class='modal-footer'>
                          <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                          <button type='button' class='btn btn-primary'>Save changes</button>
                        </div>
                      </div>
                    </div>
                  </div>";
                    header('location:'.SITEURL);
                }
                else
                {
                    // Dështoi në ruajtjen e rendit
                    $_SESSION['order'] = "<div class='error text-center'>Nuk arriti të porosisë ushqim.</div>";
                    header('location:'.SITEURL);
                }

            }
        
        ?>
    </div>
    <!-- Seksioni i kërkimit të ushqimit përfundon këtu -->

    <?php include('partials-front/footer.php'); ?>
</body>

</html>