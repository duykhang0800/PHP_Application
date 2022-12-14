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
$client = new MongoDB\Client('mongodb://localhost:27017');
$collection = $client->lazada->product;

$query = $collection->find(['_id'=> new MongoDB\BSON\ObjectId("$id")]);

$products = $query->toArray();

echo '<p>Hello World</p>';

foreach ($products as $product) {
    echo "<form method='post'>";
    echo "<p><label for='hub_id'><b>Hub ID:</b></label>";
    echo "<input type='number' name='hub_id' required value='".$product["hub_id"]."'></p>";
    echo "<p><label for='vendor_id'><b>Vendor ID:</b></label>";
    echo "<input type='number' name='vendor_id' required value='".$product["vendor_id"]."'></p>";
    echo "<p><label for='name'><b>Product name:</b></label>";
    echo "<input type='text' name='name' required value='".$product["name"]."'></p>";
    echo "<p><label for='price'><b>Price:</b></label>";
    echo "<input type='number' name='price' required value='".$product["price"]."'></p>";
    echo "<p><label for='description'><b>Description:</b></label>";
    echo "<input type='text' name='description' required value='".$product["description"]."'></p>";
    echo "<p><input type='submit' name='update' value='update'></p>";
    echo "</form>";
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $vendor_id = $_POST['vendor_id'];
    $hub_id = $_POST['hub_id'];

    $res = $collection->updateOne(['_id' => new \MongoDB\BSON\ObjectID($id)], 
            ['$set' => ['name' => $name, 
            'price' => (float)$price, 
            'vendor_id' => (int)$vendor_id, 
            'hub_id' => (int)$hub_id,
            'description' => $description]]);

    header("Location: updateproduct.php?id=".$id);
}

if (isset($_POST['back'])){
  $criteria = 'all';
  header("Location: vendorview.php?criteria=".$criteria);
}
}
else {
  header('Location: login.php');
  echo 'You have to login first';
}
?>