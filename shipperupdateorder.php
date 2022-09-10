<?php
session_start();
require_once 'db.php';
?>

<div class ="main-content">
    <div class="div-wrapper">
        <h1>Update Order Status</h1>
        <br></br>
        
        <?php
            
            // check if id is set 
            if(isset($_GET['Order_ID']))
            {
                // get order details
                $Order_ID = $_GET['Order_ID'];
                $db_select = mysqli_select_db($conn, 'lazada') or die(mysql_error());
                // get other details based on order ID
                $sql = "select * from tbl_Order where Order_ID=$Order_ID";
                // Execute the query
                $res = mysqli_query($conn, $sql);
                // count the rows
                $count = mysqli_num_rows($res);
                if($count==1)
                {
                    // details available
                    $row=mysqli_fetch_assoc($res);
                    $Order_ID = row['Order_ID'];
                    $Product_name = $row['Product_name'];
                    $Price = $row['Price'];
                    $Status = $row['Status'];
                    $Customer_Name = $row['Customer_Name'];
                    //$Customer_Phone = $row['Customer_Phone'];
                    $Phone = $row['Phone'];
                    $Address = $row['Address'];
                }
                else
                {
                    // details unavailable
                    // back to shipper view page
                    if (isset($_POST['logout'])){
                        header('Location: shipperview.php');
                    }
                    //header('location:'.SITEURL.'shipperview.php');
                }
            
            }
            else
            {
                // back to shipper view page
                if (isset($_POST['logout'])){
                    header('Location: shipperview.php');
                }
                //header('location:'.SITEURL.'PHP_Application-main/shipperview.php');
            }
                
                
            
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr> 
                    <td>Product Name </td>
                    <td>
                        <input type="text" name="Product_Name" value="">
                    </td>
                </tr>

                <tr> 
                    <td>Price </td>
                    <td>
                        <input type="number" name="Price" value="">
                    </td>
                </tr>

                <tr> 
                    <td>Address </td>
                    <td>
                        <textarea name="address" cols="30" rows="5"></textarea>
                    </td>
                </tr>

                <tr> 
                    <td>Phone</td>
                    <td>
                        <input type="number" name="Phone" value="<?php echo $Phone; ?>">
                    </td>
                </tr>

                <tr> 
                    <td>Status </td>
                    <td> 
                        <select name="status">
                            <option value="Ready">Ready</option>
                            <option value="Shipped">Shipped</option>
                            <option value="Cancalled">Cancelled</option>
                        </select>
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
           
       
    </div>
</div>
        
