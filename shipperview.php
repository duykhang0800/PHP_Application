<div class="main-content">
    <div class="wrapper">
        <h1>Shipper View</h1>

            <br /><br /><br />

            <?php
                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
            //}
            ?>
            <br></br>

            <table class="tbl-full">
                <tr>
                    <th>Order Number</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Customer Name</th>
                    <th>Customer Phone</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
                <?php
                    
                    // connect to the db
                    $conn = mysqli_connect('localhost','root','15042001') or die(mysql_error());
                    $db_select = mysqli_select_db($conn, 'lazada') or die(mysql_error());
                    // Get all the orders from database
                    $sql = "SELECT * FROM tbl_Order"; // display first order first
                    // Execute the query
                    $res = mysqli_query($conn, $sql);
                    // Count the rows
                    $count = mysqli_num_rows($res);
                    $on = 1; // create an order number, default value equal 1

                    if($count>0)
                    {
                        // Order is available
                        while($row = mysqli_fetch_assoc($res))
                        {
                            // get order details
                            $Order_ID = $row['Order_ID'];
                            $Product_name = $row['Product_name'];
                            $Price = $row['Price'];
                            $Status = $row['Status'];
                            $Customer_Name = $row['Customer_Name'];
                            $Customer_Phone = $row['Customer_Phone'];
                            $Phone = $row['Phone'];
                            $Address = $row['Address'];

                            ?>
                                <tr>
                                    <td><?php echo $on++; ?></td>
                                    <td><?php echo $Product_name; ?></td>
                                    <td><?php echo $Price; ?></td>
                                    <td><?php echo $Status?></td>
                                    <td><?php echo $Customer_Name; ?></td>
                                    <td><?php echo $Customer_Phone; ?></td>
                                    <td><?php echo $Phone; ?></td>
                                    <td><?php echo $Address; ?></td>
                                    <td>
                                    <a href="updateorder.php">
                                        <button>Update</button>
                                    </a>
                                    </td>
                                </tr>
                            <?php 
                        }
                    }
                    else
                    {
                        // Order unavailable
                        echo "<tr><td colspan ='12' class='error>Order not available</td></tr>";
                    }
                ?>
               
            </table>
    </div>
</div>
