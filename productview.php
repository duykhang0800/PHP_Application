<?php
session_start();
?>
<form method="post">
  <div>
    <!-- <input type="submit" name="create" value="Add product"> -->
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

  if ($criteria == 'all') {
    $query = $collection->find();

    $products = $query->toArray();

    echo '_____________________________________________ <br> <br>';
    foreach ($products as $product) {
      echo '<b>' . 'ID : ' . $product['_id'] . '<br>' . '</b>';
      echo 'Product : ' . $product['name'] . '<br>';
      echo 'Price: ' . $product['price'] . '<br>';
      echo 'Description: ' . $product['description'] . '<br>';
      echo 'Seller: ' . $product['vendor_id'] . '<br>';
      echo '<form method="post">';
      echo '<button type="submit" name="purchase" value="' . $product['_id'] . '">Purchase</button>';
      echo '</form>';
      echo '_____________________________________________ <br> <br>';
    }
  } else {
    $query = $collection->find(['name' => $criteria], []);

    $products = $query->toArray();

    echo '_____________________________________________ <br> <br>';
    foreach ($products as $product) {
      echo '<b>' . 'ID : ' . $product['_id'] . '<br>' . '</b>';
      echo 'Product : ' . $product['name'] . '<br>';
      echo 'Price: ' . $product['price'] . '<br>';
      echo 'Description: ' . $product['description'] . '<br>';
      echo 'Seller: ' . $product['vendor_id'] . '<br>';
      echo '<form method="post">';
      echo '<button type="submit" name="purchase" value="' . $product['_id'] . '">Purchase</button>';
      echo '</form>';
      echo '_____________________________________________ <br> <br>';
    }
  }

  if (isset($_POST['purchase'])) {
    $id = $_POST['purchase'];
    echo "<script> window.location.replace('createorder.php?id=".$id."') </script>";
  }

  if (isset($_POST['updateInfo'])) {
    $username = $_SESSION['User'];
    echo "<script> window.location.replace('updatecustomerinfo.php?username=".$username."') </script>";
  }

  if (isset($_POST['logout'])) {
    echo "<script> window.location.replace('logout.php') </script>";
  }

  if (isset($_POST['search'])) {
    $criteria = trim($_POST['search']);
    echo "<script> window.location.replace('productview.php?criteria=".$criteria."') </script>";
  }
} else { // this part will be in eveypage to make sure user is logged in
  header('Location: login.php');
  echo 'You have to login first';
}
?>