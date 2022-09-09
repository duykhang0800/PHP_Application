
<div class ="main-content">
    <div class="div-wrapper">
        <h1>Update Order Status</h1>
        <br></br>
        
        <?php 
            // check if id set
            if(isset($_GET['Order_ID']))
            {
                // get order details
                $Order_ID = $_GET['Order_ID'];
                // get other details based on order ID
                $sql = "select * from Order where Order_ID=$Order_ID";
                // Execute the query
                $res = mysqli_query($conn, $sql);
                // count the rows
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    // details available
                    $row=mysqli_fetch_assoc($res);

                    $Product_name = $row['Product_name'];
                    $Price = $row['Price'];
                    $Status = $row['Status'];
                    $Customer_Name = $row['Customer_Name'];
                    $Customer_Phone = $row['Customer_Phone'];
                    $Phone = $row['Phone'];
                    $Address = $row['Address'];
                }
                else
                {
                    // details unavailable
                    // back to shipper view page
                    header('location:'.SITEURL.'shipperpage/shipperview.php');
                }
            }
            else
            {
                // back to shipper view page
                header('location:'.SITEURL.'shipperpage/shipperview.php');
            }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr> 
                    <td>Product Name </td>
                    <td><b><?php echo $Product_name; ?></b></td>
                </tr>
                <tr> 
                    <td>Status </td>
                    <td> 
                        <select name="status">
                            <option <?php if($Status=="Ready"){echo"selected";} ?> value="Ready">Ready</option>
                            <option <?php if($Status=="On Delivery"){echo"selected";} ?> value="On Delivery">Ordered</option>
                            <option <?php if($Status=="Delivered"){echo"selected";} ?> value="Delivered">Ordered</option>
                            <option <?php if($Status=="Cancelled"){echo"selected";} ?> value="Cancalled">Ordered</option>
                        </select>
                    </td>
                </tr>
                
                <tr>
                    <td>Address:</td>
                    <td>
                        <textarea name="Address" cols="30" rows="5"><?php echo $Address; ?></textarea>
                    </td>
                    <td>Customer Phone:</td>
                    <td>
                        <input type="text" name="Customer_Phone" value="<?php echo $Customer_Phone; ?>">
                    </td>
                    <td>Price:</td>
                    <td>
                        <b><?php echo $Price; ?></b>
                    </td>
                </tr>
                <tr>
                    <td clospan="2">
                        <input type="hidden" name="Order_ID" value="<?php echo $Order_ID; ?>">
                        <input type="hidden" name="Price" value="<?php echo $Price; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php 
            // check if Update button is pressed
            if(isset($_POST['submit']))
            {
                //echo "Pressed";
                // get all the data from the form
                $Order_ID=$_POST['Order_ID'];
                $Price=$_POST['Price'];
                $Status=$_POST['Status'];
                $Customer_Name=$_POST['Customer_Name'];
                $Customer_Phone=$_POST['Customer_Phone'];
                $Phone=$_POST['Phone'];
                $Address=$_POST['Address'];

                // update status values
                $sql2 = "UPDATE Order SET
                    Status = '$Status',
                    Customer_Name = '$Customer_Name',
                    Customer_Phone = '$Customer_Name',
                    Phone = '$Phone',
                    Address = '$Address'
                    WHERE Order_ID = $Order_ID;
                ";
                // Execute the query
                $res2 = mysqli_query($conn, $sql2);

                // check if update status updated or not
                // back to shipper view page
                if($res2==true)
                {
                    // updated
                    $_SESSION['update'] = "<div class='success'>Order Status Updated Successfully.</div>";
                    header('location:'.SITEURL.'shipperpage/shipperview.php');
                }
                else
                {
                    // update failed
                    $_SESSION['update'] = "<div class='error'>Order Status Updated Failed.</div>";
                    header('location:'.SITEURL.'shipperpage/shipperview.php');
                }
            }
        ?>
    </div>
</div>