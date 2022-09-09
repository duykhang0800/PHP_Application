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
                    $sql = "SELECT * FROM Order ORDER BY Order_ID DESC"; // display latest order first
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
                                        <a href="<?php echo SITEURL; ?>shipperpage/updateorder.php?id=<?php echo $Order_ID; ?>" class="btn-secondary">Update Order</a>
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
