<?php
session_start();
?>
<form method="post">
  <div>
    <input type="submit" name="create" value="Add product">
    <input type="submit" name="updateInfo" value="Update Information">
    <input type="submit" name="logout" value="Log Out">
  </div>
</form>

<form method="post">
  <input id="search" name="search" type="text" placeholder="Search by name">
  <input id="submit" type="submit" value="Search">
</form>
<?php
if (isset($_SESSION['User'])) {    //after login the user will able to view all auction and navigate page in this main page

  require_once('db.php');
  require_once('vendor/autoload.php');
  $client = new MongoDB\Client('mongodb://localhost:27017');
  $collection = $client->lazada->product;

  $criteria = $_GET['criteria'];

  $username = $_SESSION['User'];

  $sql = "SELECT * FROM Vendor WHERE Username = '$username'";
  $stmt = $dbh->query($sql);
  $vendor = $stmt->fetch(PDO::FETCH_ASSOC);

  $vendor_id = (int)$vendor['Vendor_ID'];

  if ($criteria == 'all') {
    $query = $collection->find(['vendor_id' => $vendor_id], []);

    $products = $query->toArray();

    echo '_____________________________________________ <br> <br>';
    foreach ($products as $product) {
      echo '<b>' . 'ID : ' . $product['_id'] . '<br>' . '</b>';
      echo 'Product : ' . $product['name'] . '<br>';
      echo 'Price: ' . $product['price'] . '<br>';
      echo 'Description: ' . $product['description'] . '<br>';
      echo 'Seller: ' . $product['vendor_id'] . '<br>';
      echo '<form method="post">';
      echo '<button type="submit" name="update" value="' . $product['_id'] . '">Update</button>';
      echo '</form>';
      echo '_____________________________________________ <br> <br>';
    }
  } else {
    $query = $collection->find(['vendor_id' => $vendor_id, 'name' => $criteria], []);

    $products = $query->toArray();

    echo '_____________________________________________ <br> <br>';
    foreach ($products as $product) {
      echo '<b>' . 'ID : ' . $product['_id'] . '<br>' . '</b>';
      echo 'Product : ' . $product['name'] . '<br>';
      echo 'Price: ' . $product['price'] . '<br>';
      echo 'Description: ' . $product['description'] . '<br>';
      echo 'Seller: ' . $product['vendor_id'] . '<br>';
      echo '<form method="post">';
      echo '<button type="submit" name="update" value="' . $product['_id'] . '">Update</button>';
      echo '</form>';
      echo '_____________________________________________ <br> <br>';
    }
  }

  if (isset($_POST['create'])) {
    header('Location: createproduct.php');
  }

  if (isset($_POST['update'])) {
    $id = $_POST['update'];
    echo 'Products: ' . $id . '<br>';
    header("Location: updateproduct.php?id=" . $id);
  }

  if (isset($_POST['updateInfo'])) {
    $username = $_SESSION['User'];
    header("Location: updatevendorinfo.php?username=" . $username);
  }

  if (isset($_POST['logout'])) {
    header('Location: logout.php');
  }

  if (isset($_POST['search'])) {
    $criteria = trim($_POST['search']);
    header("Location: vendorview.php?criteria=" . (string)$criteria);
  }
} else { // this part will be in eveypage to make sure user is logged in
  header('Location: login.php');
  echo 'You have to login first';
}
?>