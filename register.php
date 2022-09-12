<?php
session_start();
require_once('db.php')
?>
  <body>
    <div>
      <?php
      $_SESSION['db_user'] = 'signinnup';
      if(isset($_POST['create'])){ //recieve fields for user to insert new account to database
        $execute;

        if ($_POST['role'] == 'Customer') {
          $sql = "SELECT * FROM Customer"; // display first order first
          // Execute the query
          $res = mysqli_query($conn, $sql);
          // Count the rows
          $count = mysqli_num_rows($res);

          $id = $count + 1;
          $name = $_POST['name'];
          $username = $_POST['username'];
          $password = $_POST['password'];
          $address = $_POST['address'];
          $longitude = $_POST['longitude'];
          $latitude = $_POST['latitude'];
        
          $insertSql = "INSERT INTO Customer (Customer_ID, Customer_Name, Address, Latitude, Longitude, Username, Password, Role) VALUES 
          ('".$id."','".$name."','".$address."','".$latitude."', '".$longitude."', '".$username."','".$password."', 'Customer');";
        
          $execute = mysqli_query($conn, $insertSql);
        }
        
        if ($_POST['role'] == 'Vendor') {
          $sql = "SELECT * FROM Vendor"; // display first order first
          // Execute the query
          $res = mysqli_query($conn, $sql);
          // Count the rows
          $count = mysqli_num_rows($res);

          $id = $count + 1;
          $name = $_POST['name'];
          $username = $_POST['username'];
          $password = $_POST['password'];
          $address = $_POST['address'];
          $longitude = $_POST['longitude'];
          $latitude = $_POST['latitude'];
        
          $insertSql = "INSERT INTO Vendor (Vendor_ID, Vendor_Name, Address, Latitude, Longitude, Username, Password, Role) VALUES 
          ('".$id."','".$name."','".$address."','".$latitude."', '".$longitude."', '".$username."','".$password."', 'Vendor');";
        
          $execute = mysqli_query($conn, $insertSql);
        }

        if ($execute){
          header('Location: login.php');
        }
        else {
          echo "Create an account failed";
        }
      }
      ?>
    </div>
    <div>
      <form method="post">
        <div>
          <h1>Register</h1>
          <h3>Fill up the form with correct values.</h3>

          <div>
            <b>Sign up as:</b>
            <select name="role" id="role">
              <option value="Customer">Customer</option>
              <option value="Vendor">Vendor</option>
              <option value="Shipper">Shipper</option>
            </select><br>
          </div>

          <p><label for="name"><b>Name</b></label>
          <input type="text" name="name" required></p>
         
          <p><label for="longitude"><b>Longitude:</b></label>
          <input type="text" name="longitude" required></p>
          
          <p><label for="latitude"><b>Latitude:</b></label>
          <input type="text" name="latitude" required></p>
          
          <p><label for="username"><b>Username:</b></label>
          <input type="text" name="username" required></p>

          <p><label for="password"><b>Password</b></label>
          <input type="password" name="password" required></p>

          <p><label for="address"><b>Address</b></label>
          <input type="text" name="address"></p>

          <p><input type="submit" name="create" value="Sign Up"></p>
        </div>
      </form>
    </div>
  </body>
</html>
