<?php

session_start();

$conn = new mysqli("localhost","root","15042001","lazada") or die(mysqli_error($conn));

$update = false;
$Order_ID = 0;
$Product_name = '';
$Price = '';
$Status = '';
$Customer_Name = '';
$Customer_Phone = '';
$Phone = '';
$Address = '';


if (isset($_POST['save'])){
    //$Order_ID = $_POST['Order_ID'];
    $Product_name = $_POST['Product_name'];
    $Price = $_POST['Price'];
    $Status = $_POST['Status'];
    $Customer_Name = $_POST['Customer_Name'];
    $Customer_Phone = $_POST['Customer_Phone'];
    $Phone = $_POST['Phone'];
    $Address = $_POST['Address'];

    $conn->query("INSERT INTO tbl_Order(Product_name, Price, Status, Customer_Name, Customer_Phone, Phone, Address)
                VALUES('$Product_name', '$Price', '$Status', '$Customer_Name', '$Customer_Phone', '$Phone', '$Address')") 
                or die($conn->error);
    
    $_SESSION['message'] = "Record has been saved";
    $_SESSION['message_type'] = "success";

    header("location: shipper_view.php");
}

if (isset($_GET['edit'])){
    $Order_ID = $_GET['edit'];
    $update = true;
    $result = $conn->query("select * from tbl_Order where Order_ID=$Order_ID") or die($conn->error());
    if ($result->num_rows){
        $row = $result->fetch_array();
        $Product_name = $row['Product_name'];
        $Price = $row['Price'];
        $Status = $row['Status'];
        $Customer_Name = $row['Customer_Name'];
        $Customer_Phone = $row['Customer_Phone'];
        $Phone = $row['Phone'];
        $Address = $row['Address'];
    }
    

if(isset($_POST['update'])){
    $Order_ID = $_POST['Order_ID'];
    $Product_name = $_POST['Product_name'];
    $Price = $_POST['Price'];
    $Status = $_POST['Status'];
    $Customer_Name = $_POST['Customer_Name'];
    $Customer_Phone = $_POST['Customer_Phone'];
    $Phone = $_POST['Phone'];
    $Address = $_POST['Address'];

    $conn->query("UPDATE tbl_Order SET  Product_name='$Product_name',
                                        Price ='$Price',
                                        Status ='$Status',
                                        Customer_Name='$Customer_Name',
                                        Customer_Phone='$Customer_Phone',
                                        Phone='$Phone',
                                        Address='$Address',
                                        WHERE Order_ID=$Order_ID") 
                or die($conn->error);

    $_SESSION['message'] = "Record has been updated";
    $_SESSION['message_type'] = "warning";

    header('location: shipper_view.php');
}

}

