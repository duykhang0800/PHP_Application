<?php
//require_once ('db.php');
// php code to Update data from mysql database Table

if ($_SESSION['User'] == 'admin'){
  require_once 'db.php';
  require_once 'vendor/autoload.php';

   if (isset($_POST['back'])){
    header("Location: shipperview.php");
    }

    /*
if(isset($_POST['update']))
{
    
   $hostname = "localhost";
   $username = "root";
   $password = "15042001";
   $databaseName = "lazada";
   
   $connect = mysqli_connect($hostname, $username, $password, $databaseName); */

   // get values form input text and number
   
   $Order_ID = $_POST['Order_ID'];
   $Product_name = $_POST['Product_name'];
   $Price = $_POST['Price'];
   $Status = $_POST['Status'];
   $Customer_Name = $_POST['Customer_Name'];
   $Customer_Phone = $_POST['Customer_Phone'];
   $Phone = $_POST['Phone'];
   $Address = $_POST['Address'];

  
           
   // mysql query to Update data
   $query = "UPDATE `lazada.order` SET 
            `Product_name`='".$Product_name."',
            `Price`='".$Price."',
            `Status`='".$Status."',
            `Customer_Name`='".$Customer_Name."',
            `Customer_Phone`='".$Customer_Phone."',
            `Phone`='".$Phone."',
            `Address`='".$Address."'
            WHERE `Order_ID` = $Order_ID";
   
   $result = mysqli_query($connect, $query);
   
   if($result)
   {
       echo 'Data Updated';
   }else{
       echo 'Data Not Updated';
   }
   mysqli_close($connect);
}
}

?>

<!DOCTYPE html>

<html>

    <head>

        <title> SHIPPER UPDATE ORDER </title>

        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </head>

    <body>

        <form action="shipperupdateorder.php" method="post">

            ID To Update: <input type="text" name="Order_ID" required><br><br>

            Product name:<input type="text" name="Product_name" required><br><br>

            Price:<input type="text" name="Price" required><br><br>

            Status:<input type="text" name="Status" required><br><br>

            Customer Name:<input type="text" name="Customer_Name" required><br><br>

            Customer Phone:<input type="text" name="Customer_Phone" required><br><br>

            Phone:<input type="text" name="Phone" required><br><br>

            Address:<input type="text" name="Address" required><br><br>

            <input type="submit" name="update" value="Update Order">

        </form>

    </body>


</html>
