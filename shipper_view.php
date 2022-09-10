<html>
    <head>
        <title> SHIPPER VIEW </title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php require_once 'update_order.php'; ?>

        <?php   
        if (isset($_SESSION['message'])): ?>        
        <div class="alert alert-<?=$_SESSION['message_type']?>">
            <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            ?>
        </div>
        <?php endif; ?>   
        <div class="container">
        <?php 
            $conn = new mysqli("localhost","root","15042001","lazada") or die(mysqli_error($conn));
            $result = $conn->query("SELECT * FROM tbl_Order") or die($conn->error);
        ?>

            <div class="row justify-content-center">
                <table class="table">
                    <thead>
                        <tr>
                            
                            <th>Product_name</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Customer_Name</th>
                            <th>Customer_Phone</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
            <?php
                while($row = $result->fetch_assoc()): ?>
                    <tr>
                        
                        <td><?php echo $row['Product_name']; ?></td>
                        <td><?php echo $row['Price']; ?></td>
                        <td><?php echo $row['Status']; ?></td>
                        <td><?php echo $row['Customer_Name']; ?></td>
                        <td><?php echo $row['Customer_Phone']; ?></td>
                        <td><?php echo $row['Phone']; ?></td>
                        <td><?php echo $row['Address']; ?></td>
                        <td>
                            <a href="shipper_view.php?edit=<?php echo $row['Order_ID']; ?>"
                            class="btn btn-info">Update</a>
                        </td
                    </tr>
                <?php endwhile; ?>
                </table>
              </div>

            <?php
            function pre_r($array){
                echo'<pre>';
                print_r($array);
                echo'</pre>';
            }
        ?>
        <div class="row-justify-content-center">
        <form action="update_order.php" method="post">
            <input type="hidden" name="OrderID" value="<?php echo$Order_ID ?>">
            
            <div class="form-group">
            <label>Product name</label>
            <input type="text" name="Product_name" class="form-control"
            value="<?php echo $Product_name; ?>" placeholder="Enter Product Name">
            </div>

            <div class="form-group">
            <label>Price</label>
            <input type="text" name="Price" class="form-control" 
            value="<?php echo $Price; ?>"placeholder="Enter Price">
            </div>

            <div class="form-group">
            <label>Status</label>
            <input type="text" name="Status" class="form-control" 
            value="<?php echo $Status; ?>"placeholder="Enter Status">
            </div>

            <div class="form-group">
            <label>Customer Phone</label>
            <input type="text" name="Customer_Phone" class="form-control" 
            value="<?php echo $Customer_Phone; ?>"placeholder="Enter Customer Phone">
            </div>

            <div class="form-group">
            <label>Phone</label>
            <input type="text" name="Phone" class="form-control" 
            value="<?php echo $Phone; ?>"placeholder="Enter Phone">
            </div>

            <div class="form-group">
            <label>Address</label>
            <input type="text" name="Address" class="form-control" 
            value="<?php echo $Address; ?>"placeholder="Enter Address">
            </div>

            <div class="form-group">
            <?php 
            if ($update == true):
            ?>
                <button type="submit" class="btn btn-info" name="update">Update</button>
                
            <?php else: ?>
                <button type="submit" class="btn btn-primary" name="save">Save</button>
            <?php endif; ?>
            </div>
        
        </form>
    </div>
    </div>
    </body>
</html>