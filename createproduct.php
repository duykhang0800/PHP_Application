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
$collection = $client->amazon->product;

if (isset($_POST['back'])){
  header("Location: productview.php");
}

if(isset($_POST['create'])){

  $name = $_POST['name'];
  $minimum = $_POST['minimum'];
  $date = $_POST['date'];

  $res = $collection->insertOne([
    'productName' => $name,
    'price' => $price,
    'ownerEmail' => $_SESSION['User']
  ]);
  header("Location: productview.php");
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

    <p><label for="name"><b>Product name</b></label>
    <input type="text" name="name" required></p>

    <p><label for="price"><b>Price</b></label>
    <input type="number" name="price" required></p>

    <!-- <p><label for="date"><b>Closing date</b></label>
    <input type="date" name="date" required></p> -->

    <p><input type="submit" name="create" value="create"></p>
  </div>
</form>
