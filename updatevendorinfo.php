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

$sql = "SELECT * FROM Vendor WHERE Username = '$username'";

$result = mysqli_query($conn, $sql);

foreach($result as $vendor){
    echo "<form method='post'>";
    echo "<p><label for='id'><b>Vendor ID:</b></label>";
    echo "<input type='text' name='id' required value='".$vendor["Vendor_ID"]."' readonly='true'></p>";
    echo "<p><label for='vendorName'><b>Vendor Name:</b></label>";
    echo "<input type='text' name='vendorName' required value='".$vendor["Vendor_Name"]."'></p>";
    echo "<p><label for='address'><b>Address:</b></label>";
    echo "<input type='text' name='address' required value='".$vendor["Address"]."'></p>";
    echo "<p><label for='latitude'><b>Latitude:</b></label>";
    echo "<input type='text' name='latitude' required value='".$vendor["Latitude"]."'></p>";
    echo "<p><label for='longitude'><b>Longitude:</b></label>";
    echo "<input type='number' name='longitude' required value='".$vendor["Longitude"]."'></p>";
    echo "<p><label for='username'><b>USername:</b></label>";
    echo "<input type='text' name='username' required value='".$vendor["Username"]."'></p>";
    echo "<p><label for='password'><b>Password:</b></label>";
    echo "<input type='password' name='password' required value='".$vendor["Password"]."'></p>";
    echo "<p><input type='submit' name='update' value='update'></p>";
    echo "</form>";
}

if (isset($_POST['update'])) {
    $vendor_id = $_POST['id'];
    $vendorName = $_POST['vendorName'];
    $addres = $_POST['address'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "UPDATE `lazada`.`vendor`
            SET
                `Vendor_Name` = '$vendorName',
                `Address` = '$addres',
                `Latitude` = '$latitude',
                `Longitude` = '$longitude',
                `Username` = '$username',
                `Password` = '$password'
            WHERE `Vendor_ID` = '$vendor_id';";

    mysqli_query($conn, $sql);

    header("Location: updatevendorinfo.php?username=".$username);
}

if (isset($_POST['back'])){
  header("Location: vendorview.php");
}

if(isset($_POST['create'])){

  $name = $_POST['name'];
  $price = $_POST['price'];
  $description = $_POST['description'];
  $vendor_id = $_POST['vendor_id'];
  $hub_id = $_POST['hub_id'];

  $res = $collection->insertOne([
    'hub_id' => (int)$hub_id,
    'vendor_id' => (int)$vendor_id,
    'name' => (float)$name,
    'price' => $price,
    'description' => $description
  ]);

  if ($_SESSION['db_user'] == 'lazadavendor') {
    header("Location: vendorview.php");
  }

  if ($_SESSION['db_user'] == 'lazadashipper') {
    header("Location: productview.php");
  }

  if ($_SESSION['db_user'] == 'signinnup') {
    header("Location: productview.php");
  }
}
}
else {
  header('Location: login.php');
  echo 'You have to login first';
}
?>