<?php
    ob_start();
?>

<?php include('partials/menu.php'); ?>


<div class="container" style="font-family: 'Poppins', sans-serif;margin-bottom:50px;">
        <h1 style="margin-top:75px;margin-bottom:50px;">Shto administrator</h1>


        <?php 
            if(isset($_SESSION['add'])) //Checking whether the SEssion is Set of Not
            {
                echo $_SESSION['add']; //Display the SEssion Message if SEt
                unset($_SESSION['add']); //Remove Session Message
            }
        ?>

        <form action="" method="POST">

            <table class="table table-hover">
                <tr>
                    <td>Emri i plotë: </td>
                    <td>
                        <input type="text" class="form-control" name="full_name" placeholder="Shkruaj emrin dhe mbiemrin">
                    </td>
                </tr>

                <tr>
                    <td>Emri i përdoruesit: </td>
                    <td>
                        <input type="text" class="form-control" name="username" placeholder="Emri i përdoruesit">
                    </td>
                </tr>

                <tr>
                    <td>Fjalëkalimi: </td>
                    <td>
                        <input type="password" class="form-control" name="password" placeholder="Fjalëkalimi">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit"  name="submit" value="Shto administrator" class="btn btn-success">
                    </td>
                </tr>

            </table>

        </form>


    </div>
</div>

<?php include('partials/footer.php'); ?>


<?php 
    //Process the Value from Form and Save it in Database

    //Check whether the submit button is clicked or not

    if(isset($_POST['submit']))
    {
        // Button Clicked
        //echo "Button Clicked";

        //1. Get the Data from form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //Password Encryption with MD5

        //2. SQL Query to Save the data into database
        $sql = "INSERT INTO tbl_admin SET 
            full_name='$full_name',
            username='$username',
            password='$password'
        ";
 
        //3. Executing Query and Saving Data into Datbase
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        //4. Check whether the (Query is Executed) data is inserted or not and display appropriate message
        if($res==TRUE)
        {
            //Data Inserted
            //echo "Data Inserted";
            //Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='alert alert-success' role='alert'>Administratori është shtuar me sukses.</div>";
            //Redirect Page to Manage Admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //FAiled to Insert DAta
            //echo "Faile to Insert Data";
            //Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='alert alert-danger' role='alert'>Dështoi në shtimin e administratorit.</div>";
            //Redirect Page to Add Admin
            header("location:".SITEURL.'admin/add-admin.php');
        }

    }
    
?>