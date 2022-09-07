<form method="post">
   <div>
    <input type="submit" name="back" value="Return main Page">
   </div>
</form>

<?php
session_start();
if (isset($_SESSION['User'])){

require_once ('db.php');
require_once ('vendor/autoload.php');

$user = $_SESSION['User'];
$sql1 = "SELECT Balance FROM Customer WHERE Customer_Email = '$user'";
$stmt1 = $dbh->query($sql1);
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

echo '<b>' . 'Your Balance is ' . $row1['Balance'] . '<br>' . '</b>';
if (isset($_POST['back'])){
  header("Location: view.php");
}

if (isset($_POST['bid'])){    //user can place the amount of bid for the auction the one by enter its id
    $id = $_POST['id'];
    $amount = $_POST['amount'];

    $client = new MongoDB\Client('mongodb://localhost:27017');
    $collection = $client->auction->auction;
    $filter = ['_id' => new MongoDB\BSON\ObjectId($id)];
    $document = $collection->findOne($filter);

    if(empty($document)){ //check for some business rule first then the mysql trigger check the rest
      echo 'This auction does not exist';
    }
    elseif (date('Y-m-d') > $document['closingDate']) {
      echo date('Y-m-d') . $document['closingDate'];
      echo 'This auction is expired';
    }
    elseif ($amount < $document['minimunBid']) {
      echo 'The bid amount is too low';
    }
    else{
      $sql2 = "INSERT INTO Bid (Customer_Email, Auction_ID, Bid) VALUES (?,?,?) ON DUPLICATE KEY UPDATE Bid = $amount";
      $stmt2 = $dbh->prepare($sql2);
      $result = $stmt2->execute([$user, $id, $amount]);
      if ($result){
        echo 'Place bid Successfully';
      }
      else {
        echo "Bid is invalid, either your bid is lower then current bid or you do not have enough money";
      }
    }
}

}
else {
  header('Location: login.php');
  echo 'You have to login first';
}

?>
<form method="post">
  <div>
    <span>Auction ID</span><br>
    <input type="text" name="id">
   </div>
  <div>
    <span>Bid Amount</span><br>
    <input type="number" name="amount">
   </div>
   <div>
    <input type="submit" name="bid" value="Place Bid">
   </div>
</form>
