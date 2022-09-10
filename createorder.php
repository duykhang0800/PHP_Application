<form method="post">
   <div>
    <input type="submit" name="back" value="Return main Page">
   </div>
</form>

<?php
session_start();

$id= $_GET['id'];

echo 'Products: ' .$id. '<br>';

if (isset($_SESSION['User']))
{  //the user with account can fill in and create new auction 
require_once ('db.php');
require_once ('vendor/autoload.php');
$client = new MongoDB\Client('mongodb://localhost:27017');
$collection = $client->lazada->product;

$query = $collection->find(['_id'=> new MongoDB\BSON\ObjectId("$id")]);

$products = $query->toArray();

echo '<p>Hello World</p>';

foreach ($products as $product) {
    echo "<form method='post'>";
    echo "<p><label for='name'><b>Product name:</b></label>";

    //Users are not allowed to change product details
    echo "<input type='text' name='name' required value='".$product["name"]."' readonly='true'></p>";
    echo "<p><label for='price'><b>Price:</b></label>";
    echo "<input type='number' name='price' required value='".$product["price"]."' readonly='true'></p>";
    echo "<p><label for='description'><b>Description:</b></label>";
    echo "<input type='text' name='description' required value='".$product["description"]."' readonly='true'></p>";

    //Customer information
    echo "<p><label for='customername'><b>Customer Name:</b></label>";
    echo "<input type='text' name='customername' required value=''></p>";
    echo "<p><label for='phone'><b>Phone:</b></label>";
    echo "<input type='text' name='phone' required value=''></p>";
    echo "<p><label for='address'><b>Address:</b></label>";
    echo "<input type='text' name='address' required value=''></p>";
    echo "<p><input type='submit' name='create' value='create'></p>";
    echo "</form>";
}

if (isset($_POST['create'])) {

    $sql = "SELECT * FROM lazada.order"; // display first order first
                    // Execute the query
    $res = mysqli_query($conn, $sql);
                    // Count the rows
    $count = mysqli_num_rows($res);


    $Order_ID = $count + 1;
    $name = $_POST['name'];
    $price = $_POST['price'];
    $status = "Ready";
    $customerName = $_POST['customername'];
    $customerPhone = $_POST['phone'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $insertSql = "INSERT INTO lazada.order (Order_ID, Product_Name, Price, Status, Customer_Name, Customer_Phone, Phone, Address) VALUES 
    ('".$Order_ID."','".$name."','".$price."','".$status."', '".$customerName."', '".$customerPhone."','".$phone."', '".$address."');";

    $execute = mysqli_query($conn, $insertSql);

    header("Location: updateproduct.php?id=".$id);
}

if (isset($_POST['back'])){
  header("Location: productview.php");
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
<!-- <form method="post">
  <div>
    <h1>Create a product for sale</h1>
    <p>Fill up the form with correct values.</p>

    <p><label for="hub_id"><b>Hub ID:</b></label>
    <input type="number" name="hub_id" value='""' required></p>

    <p><label for="vendor_id"><b>Vendor ID:</b></label>
    <input type="number" name="vendor_id" required></p>


    <p><label for="name"><b>Product name</b></label>
    <input type="text" name="name" required></p>

    <p><label for="price"><b>Price:</b></label>
    <input type="number" name="price" required></p>

    <p><label for="description"><b>Description</b></label>
    <input type="text" name="description" required></p>

    <p><input type="submit" name="create" value="create"></p>
  </div>
</form> -->
