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
   //regular user account
    $sql = "SELECT * FROM $role WHERE Username = '$username'";
    $stmt = $dbh->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && $row['Role'] == $role && $row['Password'] == $password) {
      if ($row['Role'] == 'Vendor') {
        $_SESSION["User"] = $row['Username'];
        $_SESSION['db_user'] = 'lazadavendor';
        $criteria = 'all';
        header("Location: vendorview.php?criteria=".$criteria);
      }

      if ($row['Role'] == 'Customer') {
        $_SESSION["User"] = $row['Username'];
        $_SESSION['db_user'] = 'lazadacustomer';
        $criteria = 'all';
        header("Location: productview.php?criteria=".$criteria);
      }

      if ($row['Role'] == 'Shipper') {
        $_SESSION["User"] = $row['Username'];
        $_SESSION['db_user'] = 'lazadashipper';
        header("Location: shipperview.php");
      }
    }
    else {
      echo "<p>Login failed. Please try again<p>";
      echo 'Username: ' . $row['Username'] . '<br>';
      echo 'Password: ' . $row['Password'] . '<br>';
      echo 'RoleSQL: ' . $row['Role'] . '<br>';
      echo 'Role: ' . $role . '<br>';
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
