<form method="post">
   <div>
    <input type="submit" name="back" value="Return main Page">
   </div>
</form>

<?php
session_start();

$id= $_GET['id'];

if (isset($_SESSION['User']))
{  //the user with account can fill in and create new auction 
require_once ('db.php');
require_once ('vendor/autoload.php');

$sql = "SELECT * FROM lazada.order WHERE `Order_ID` = ".$id."";

$res = mysqli_query($conn, $sql);

echo '<p>Hello World</p>';

foreach ($res as $order) {
    echo "<form method='post'>";
    echo "<p><label for='id'><b>Order ID:</b></label>";
    echo "<input type='number' name='id' required value='".$order["Order_ID"]."' readonly='true'></p>";
    echo "<p><label for='productName'><b>Product Name:</b></label>";
    echo "<input type='text' name='productName' required value='".$order["Product_name"]."' readonly='true'></p>";
    echo "<p><label for='price'><b>Price:</b></label>";
    echo "<input type='number' name='price' required value='".$order["Price"]."' readonly='true'></p>";
    echo "<p><label for=''><b>Current Status:</b></label>";
    echo "<input type='text' name='' required value='".$order["Status"]."' readonly='true'></p>";
    echo "<p><label for=''><b>Update Status:</b></label>";
    echo "<select name='status' id='status'>";
    echo "<option value='Ready'>Ready</option>";
    echo "<option value='Shipped'>Shipped</option>";
    echo "<option value='Cancelled'>Cancelled</option>";
    echo "</select></br>";
    echo "<p><label for='customerName'><b>Customer Name:</b></label>";
    echo "<input type='text' name='customerName' required value='".$order["Customer_Name"]."' readonly='true'></p>";
    echo "<p><label for='phone'><b>Phone:</b></label>";
    echo "<input type='text' name='phone' required value='".$order["Customer_Phone"]."' readonly='true'></p>";
    echo "<p><label for='address'><b>Address:</b></label>";
    echo "<input type='text' name='address' required value='".$order["Address"]."' readonly='true'></p>";
    echo "<p><input type='submit' name='update' value='update'></p>";
    echo "</form>";
}

if (isset($_POST['update'])) {
    $order_id = $_POST['id'];
    $status = $_POST['status'];

    $sql = "UPDATE `lazada`.`order`
            SET
                `Status` = '$status'
            WHERE `Order_ID` = '$order_id';";

    $res = mysqli_query($conn, $sql);

    header("Location: updateorder.php?id=".$id);
}

if (isset($_POST['back'])){
  header("Location: shipperview.php");
}
}
else {
  header('Location: login.php');
  echo 'You have to login first';
}
?>