<?php
session_start();
?>
<form method="post">
   <div>
      <input type="submit" name="logout" value="Log Out">
   </div>
</form>

<form method="post">
  <input id="search" name="search" type="text" placeholder="Search by Customer name">
  <input id="submit" type="submit" value="Search">
</form>

<?php
if (isset($_SESSION['User'])){    //after login the user will able to view all auction and navigate page in this main page

require_once ('db.php');
require_once ('vendor/autoload.php');

$username = $_SESSION['User'];

$criteria = $_GET['criteria'];

if ($criteria == 'all') {
  $query = "SELECT * FROM lazada.order;";

  $orders = mysqli_query($conn, $query);

  echo '_____________________________________________ <br> <br>';
  foreach ($orders as $order) {
      echo '<b>' . 'ID : ' . $order['Order_ID'] . '<br>' . '</b>';
      echo 'Product Name : ' . $order['Product_name'] . '<br>';
      echo 'Price: ' . $order['Price'] . '<br>';
      echo 'Status: ' . $order['Status'] . '<br>';
      echo 'Customer Name: ' . $order['Customer_Name'] . '<br>';
      echo 'Customer Phone: ' . $order['Customer_Phone'] . '<br>';
      echo 'Address: ' . $order['Address'] . '<br>';
      echo '<form method="post">';
      echo '<button type="submit" name="update" value="'.$order['Order_ID'].'">Update</button>';
      echo '</form>';
      echo '_____________________________________________ <br> <br>';
  }
} else {
  $query = "SELECT * FROM lazada.order WHERE Customer_Name = '$criteria';";

  $orders = mysqli_query($conn, $query);

  echo '_____________________________________________ <br> <br>';
  foreach ($orders as $order) {
      echo '<b>' . 'ID : ' . $order['Order_ID'] . '<br>' . '</b>';
      echo 'Product Name : ' . $order['Product_name'] . '<br>';
      echo 'Price: ' . $order['Price'] . '<br>';
      echo 'Status: ' . $order['Status'] . '<br>';
      echo 'Customer Name: ' . $order['Customer_Name'] . '<br>';
      echo 'Customer Phone: ' . $order['Customer_Phone'] . '<br>';
      echo 'Address: ' . $order['Address'] . '<br>';
      echo '<form method="post">';
      echo '<button type="submit" name="update" value="'.$order['Order_ID'].'">Update</button>';
      echo '</form>';
      echo '_____________________________________________ <br> <br>';
}
}

if (isset($_POST['create'])){
  header('Location: createorder.php');
}

if (isset($_POST['update'])){
  $id = $_POST['update'];
  echo 'orders: ' .$id. '<br>';
  header("Location: updateorder.php?id=".$id);
}

if (isset($_POST['updateInfo'])) {
  $username = $_SESSION['User'];
  header("Location: updatevendorinfo.php?username=".$username);
}

if (isset($_POST['logout'])){
  header('Location: logout.php');
}

if (isset($_POST['search'])) {
  $criteria = trim($_POST['search']);
  header("Location: shipperview.php?criteria=" . (string)$criteria);
}
}
else { // this part will be in eveypage to make sure user is logged in
  header('Location: login.php');
  echo 'You have to login first';
}
?>