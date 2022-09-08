<?php
session_start();
?>
<form method="post">
   <div>
    <input type="submit" name="create" value="Add product">
    <input type="submit" name="logout" value="Log Out">
   </div>
</form>
<?php
// if($_SESSION['User'] == 'admin'){
//   header('Location: adminview.php');
// }

if (isset($_SESSION['User'])){    //after login the user will able to view all auction and navigate page in this main page

require_once ('db.php');
require_once ('vendor/autoload.php');
$client = new MongoDB\Client('mongodb://localhost:27017');
$collection = $client->lazada->product;

$username = $_SESSION['User'];

$sql = "SELECT * FROM Vendor WHERE Username = '$username'";
$stmt = $dbh->query($sql);
$vendor = $stmt->fetch(PDO::FETCH_ASSOC);

$vendor_id = (int)$vendor['Vendor_ID'];

if (isset($_POST['create'])){
  header('Location: createproduct.php');
}
if (isset($_POST['logout'])){
  header('Location: logout.php');
}

$query = $collection->find(['vendor_id' => $vendor_id],[]);

$products = $query->toArray();

echo '_____________________________________________ <br> <br>';
echo 'Products: ' . $products[1]['name'] . '<br>';
foreach ($products as $product) {
    // $id = $product['_id'];
    // $sql = "SELECT MAX(Bid) AS current FROM Bid WHERE Auction_ID = '$id'";
    // $stmt = $dbh->query($sql);
    // $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo '<b>' . 'ID : ' . $product['_id'] . '<br>' . '</b>';
    echo 'Product : ' . $product['name'] . '<br>';
    echo 'Price: ' . $product['price'] . '<br>';
    echo 'Description: ' . $product['description'] . '<br>';
    echo 'Seller: ' . $product['vendor_id'] . '<br>';
    echo '_____________________________________________ <br> <br>';
}

}
else { // this part will be in eveypage to make sure user is logged in
  header('Location: login.php');
  echo 'You have to login first';
}
?>
