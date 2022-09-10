<?php
session_start();
?>
<form method="post">
   <div>
    <input type="submit" name="logout" value="Log Out">
    <input type="submit" name="updateInfo" value="Update Information">
   </div>
</form>
<?php

if (isset($_SESSION['User'])){    //after login the user will able to view all auction and navigate page in this main page

  require_once ('db.php');
  require_once ('vendor/autoload.php');
  $client = new MongoDB\Client('mongodb://localhost:27017');
  $collection = $client->lazada->product;
  
  if (isset($_POST['purchase'])){
    $id = $_POST['purchase'];
    echo 'Products: ' .$id. '<br>';
    header("Location: createorder.php?id=".$id);
  }

  if (isset($_POST['logout'])){
    header('Location: logout.php');
  }

  if (isset($_POST['updateInfo'])) {
    $username = $_SESSION['User'];
    header("Location: updatecustomerinfo.php?username=".$username);
  }
  
  $query = $collection->find();
  
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
      echo '<form method="post">';
      echo '<button type="submit" name="purchase" value="'.$product['_id'].'">Purchase</button>';
      echo '</form>';
      echo '_____________________________________________ <br> <br>';
  }

}
else { // this part will be in eveypage to make sure user is logged in
  header('Location: login.php');
  echo 'You have to login first';
}
?>