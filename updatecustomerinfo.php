<form method="post">
   <div>
    <input type="submit" name="back" value="Return main Page">
   </div>
</form>

<?php
session_start();

$username = $_GET['username'];

if (isset($_SESSION['User']))
{  //the user with account can fill in and create new auction 
require_once ('db.php');
require_once ('vendor/autoload.php');

$sql = "SELECT * FROM Customer WHERE Username = '$username'";

$result = mysqli_query($conn, $sql);

foreach($result as $customer){
    echo "<form method='post'>";
    echo "<p><label for='id'><b>Customer ID:</b></label>";
    echo "<input type='text' name='id' required value='".$customer["Customer_ID"]."' readonly='true'></p>";
    echo "<p><label for='customerName'><b>Customer Name:</b></label>";
    echo "<input type='text' name='customerName' required value='".$customer["Customer_Name"]."'></p>";
    echo "<p><label for='address'><b>Address:</b></label>";
    echo "<input type='text' name='address' required value='".$customer["Address"]."'></p>";
    echo "<p><label for='latitude'><b>Latitude:</b></label>";
    echo "<input type='text' name='latitude' required value='".$customer["Latitude"]."'></p>";
    echo "<p><label for='longitude'><b>Longitude:</b></label>";
    echo "<input type='number' name='longitude' required value='".$customer["Longitude"]."'></p>";
    echo "<p><label for='username'><b>USername:</b></label>";
    echo "<input type='text' name='username' required value='".$customer["Username"]."'></p>";
    echo "<p><label for='password'><b>Password:</b></label>";
    echo "<input type='password' name='password' required value='".$customer["Password"]."'></p>";
    echo "<p><input type='submit' name='update' value='update'></p>";
    echo "</form>";
}

if (isset($_POST['update'])) {
    $customer_id = $_POST['id'];
    $customerName = $_POST['customerName'];
    $addres = $_POST['address'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "UPDATE `lazada`.`customer`
            SET
                `Customer_Name` = '$customerName',
                `Address` = '$addres',
                `Latitude` = '$latitude',
                `Longitude` = '$longitude',
                `Username` = '$username',
                `Password` = '$password'
            WHERE `Customer_ID` = '$customer_id';";

    mysqli_query($conn, $sql);

    header("Location: updatecustomerinfo.php?username=".$username);
}

if (isset($_POST['back'])){
  $criteria = 'all';
  header("Location: productview.php?criteria=".$criteria);
}
}
else {
  header('Location: login.php');
  echo 'You have to login first';
}
?>