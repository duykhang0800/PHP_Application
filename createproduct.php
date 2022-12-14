<form method="post">
   <div>
    <input type="submit" name="back" value="Return main Page">
   </div>
</form>

<?php
session_start();

if (isset($_SESSION['User'])){  //the user with account can fill in and create new auction 
require_once ('db.php');
require_once ('vendor/autoload.php');
$client = new MongoDB\Client('mongodb://localhost:27017');
$collection = $client->lazada->product;

if (isset($_POST['back'])){
  $criteria = 'all';
  header("Location: vendorview.php?criteria=".$criteria);
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
    'name' => $name,
    'price' => (float)$price,
    'description' => $description
  ]);
}
}
else {
  header('Location: login.php');
  echo 'You have to login first';
}
?>
<form method="post">
  <div>
    <h1>Create a product for sale</h1>
    <p>Fill up the form with correct values.</p>

    <p><label for="hub_id"><b>Hub ID:</b></label>
    <input type="number" name="hub_id" required></p>

    <p><label for="vendor_id"><b>Vendor ID:</b></label>
    <input type="number" name="vendor_id" required></p>


    <p><label for="name"><b>Product name:</b></label>
    <input type="text" name="name" required></p>

    <p><label for="price"><b>Price:</b></label>
    <input type="number" name="price" required></p>

    <p><label for="description"><b>Description:</b></label>
    <input type="text" name="description" required></p>

    <p><input type="submit" name="create" value="create"></p>
  </div>
</form>
