<div class="main-content">
    <div class="wrapper">
        <h1>Shipper View</h1>

            <br /><br /><br />

            <?php
            if ($_SESSION["db_user"] = 'lazadashipper') { //this is similar as user main page but have functions for shipper
                require_once ('db.php');
                require_once 'vendor/autoload.php';
                $client = new MongoDB\Client('mongodb://localhost:27017');
                $collection = $client->lazada->product;
                
                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
            }
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
                    // Get all the orders from database
                    $sql = "SELECT * FROM lazada.order ORDER BY Order_ID DESC"; // display latest order first
                    // Execute the query
                    $res = mysqli_query($mysqli, $sql);
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
                                    <td>
                                        <?php
                                            // Ready, On Deli, Deli-ed, Cancelled
                                            if($Status=="Ready")
                                            {
                                                echo"<label>$Status</label>";
                                            }
                                            elseif($Status=="On Delivery")
                                            {
                                                echo"<label style='color: blue;'>$Status</label>";
                                            }
                                            elseif($Status=="Delivered")
                                            {
                                                echo"<label style='color: yellow;'>$Status</label>";
                                            }
                                            elseif($Status=="Cancelled")
                                            {
                                                echo"<label style='color: red;'>$Status</label>";
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $Customer_Name; ?></td>
                                    <td><?php echo $Customer_Phone; ?></td>
                                    <td><?php echo $Phone; ?></td>
                                    <td><?php echo $Address; ?></td>
                                    <td>
                                        <form method="post">
                                            <div>
                                                <input type="submit" name="update" value="Update Product">
                                            </div>
                                        </form>
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
