<?php
session_start();
$_SESSION['db_user'] = 'signinnup';

require_once 'db.php';

if (isset($_POST['register'])){   //move user to register page
  header('Location: register.php');
}

//Need to add checking if the user is product owner or vendor
if (isset($_POST['act'])) {   //if the hav an account they can fill in with eith phone number or email together with pass word to login
  $username = $_POST['user'];
  $password = $_POST['password'];
  $role = $_POST['role'];
  if ($username == 'admin' && $password == 'admin'){    //admin account
    $_SESSION["User"] = 'admnin';
    $_SESSION['db_user'] = 'auctionadmin';
    header("Location: adminview.php");
  }
  else{   //regular user account
    $sql = "SELECT * FROM $role WHERE Username = '$username'";
    $stmt = $dbh->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
      if ($row['Role'] == 'customer' && $row['Password' == $password]) {
        $_SESSION["User"] = $row['Username'];
        $_SESSION['db_user'] = 'signinnup';
        header("Location: productview.php");
      }

      if ($row['Role'] == 'vendor' && $row['Password' == $password]) {
        $_SESSION["User"] = $row['Username'];
        $_SESSION['db_user'] = 'lazadavendor';
        header("Location: productview.php");
      }

      if ($row['Role'] == 'shipper' && $row['Password' == $password]) {
        $_SESSION["User"] = $row['Username'];
        $_SESSION['db_user'] = 'lazadashipper';
        header("Location: productview.php");
      }
    }

    if ($row && $row['Password'] == $password) {
      $_SESSION["User"] = $row['Username'];
      $_SESSION['db_user'] = 'signinnup';
      header("Location: productview.php");
    }
    else {
      echo "<p>Login failed. Please try again<p>";
      echo 'Price: ' . $row . '<br>';
    }
  }
}
  
?>

<form method="post">
  
  <h2>Login</h2>
  <div>
    <b>Select Role:</b>
    <select name="role" id="role">
      <option value="Customer">Customer</option>
      <option value="Vendor">Vendor</option>
      <option value="Shipper">Shipper</option>
    </select><br>
  </div>
  <div>
    <b>User</b><br>
    <input type="text" name="user">
  </div>
  <div>
    <b>Password</b><br>
    <input type="password" name="password">
  </div>
  <div>
    <input type="submit" name="act" value="Login">
    <input type="submit" name="register" value="Sign up">
  </div>
</form>
