<?php
session_start();
 ?>

 <form method="post">
    <div>
     <input type="submit" name="back" value="Return main Page">
    </div>
 </form>

<?php
if ($_SESSION['User'] == 'admin'){
  require_once 'db.php';
  require_once 'vendor/autoload.php';
  $client = new MongoDB\Client('mongodb://localhost:27017');
  $collection = $client->auction->auction;

  if (isset($_POST['back'])){
    header("Location: view.php");
  }

  if (isset($_POST['add'])){    //admin can add money to the user balance
    $user = $_POST['user'];
    $amount = $_POST['amount'];

    $sql2 = "SELECT Balance FROM Customer WHERE Customer_Email = '$user'";
    $stmt2 = $dbh->query($sql2);
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

    $sql = "UPDATE Customer SET Balance = Balance + $amount WHERE Customer_Email = '$user'";
    $stmt = $dbh->query($sql);

    $sql1 = "SELECT Customer_Email, Balance FROM Customer WHERE Customer_Email = '$user'";
    $stmt1 = $dbh->query($sql1);
    $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

    echo $row1['Customer_Email'] . " Balance: " . $row2['Balance'] . " => " . $row1['Balance'];
  }

  if (isset($_POST['tranfer'])){    //the admin can tranfer money from buyer to seller of an auction after it expired
    $id = $_POST['aid'];

    $doc = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

    if(empty($doc)){
      echo 'This auction does not exist';
    }
    else{
      $seller = $doc['ownerEmail'];

      $sql1 = "SELECT Balance FROM Customer WHERE Customer_Email = '$seller'";
      $stmt1 = $dbh->query($sql1);
      $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

      $sql2 = "SELECT MAX(Bid) AS amount FROM Bid WHERE Auction_ID = '$id'";
      $stmt2 = $dbh->query($sql2);
      $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
      $amount = $row2['amount'];

      $sql3 = "SELECT Customer_Email AS buyer FROM Bid WHERE Auction_ID = '$id'  AND Bid = '$amount'";
      $stmt3 = $dbh->query($sql3);
      $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
      $buyer = $row3['buyer'];

      $sql4 = "SELECT Balance FROM Customer WHERE Customer_Email = '$buyer'";
      $stmt4 = $dbh->query($sql4);
      $row4 = $stmt4->fetch(PDO::FETCH_ASSOC);

      try {  //transaction logic
        $dbh->beginTransaction();
        if ($amount > $row4['Balance']){
          echo "Buyer account is too low";
        }
        else {
          $sqlto = "UPDATE Customer SET Balance = Balance  + $amount WHERE Customer_Email = '$seller'";
          $stmtto = $dbh->query($sqlto);
          $resto= $stmtto->execute();

          $sqlfrom = "UPDATE Customer SET Balance = Balance  - $amount WHERE Customer_Email = '$buyer'";
          $stmtfrom = $dbh->prepare($sqlfrom);
          $resfrom = $stmtfrom->execute();

          $dbh->commit();

          $sql5 = "SELECT Balance FROM Customer WHERE Customer_Email = '$buyer'";
          $stmt5 = $dbh->query($sql5);
          $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);

          $sql6 = "SELECT Balance FROM Customer WHERE Customer_Email = '$seller'";
          $stmt6 = $dbh->query($sql6);
          $row6 = $stmt6->fetch(PDO::FETCH_ASSOC);

          echo $seller . " Balance: " . $row1['Balance'] . " => " . $row6['Balance'] . '<br>';
          echo $buyer . " Balance: " . $row4['Balance'] . " => " . $row5['Balance'] . '<br>';
        }
      }
      catch (Exception $e){
        $dbh->rollBack();
        die($e->getMessage());
      }
    }
  }

  if (isset($_POST['delete'])){  //after finish transaction admin can remove the auction
    $id = $_POST['id'];

    $doc = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);

    $sql = "DELETE FROM bid WHERE Auction_ID = '$id'";
    $stmt = $dbh->query($sql);

    echo 'Auction: ' . $id . "has been deleted.";
  }
}
else {
  header('Location: login.php');
  echo 'You have to login first';
}
?>

<form method="post">
  <div>
    <h2>Add Money To An Account:</h2>
    <span>User Email:</span> <input type="text" name="user" required><br>
    <span>Add:</span> <input type="number" name="amount" required><br>
    <input type="submit" name="add" value="Add To Account"><br>
  </div>
</form>
<form method="post">
  <div>
    <h2>Tranfer money for finishing Auction:</h2>
    <span>Aution ID: </span> <input type="text" name="aid" required><br>
    <input type="submit" name="tranfer" value="Submit Tranfer"><br>
  </div>
</form>
<form method="post">
  <div>
    <h2>Delete An Auction:</h2>
    <span>Aution ID: </span> <input type="text" name="id" required><br>
    <input type="submit" name="delete" value="Delete Auction"><br>
  </div>
</form>
