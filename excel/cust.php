<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
require 'php-excel-reader/excel_reader2.php';
require 'SpreadsheetReader.php';

$conn = mysqli_connect("localhost", "root", "", "fabiz");
if (!$conn) {
    mysqli_error();
    die();
}

$Reader = new SpreadsheetReader('file/cust.xls');
$Reader->ChangeSheet(0);

foreach ($Reader as $Row) {
    $id = trim($Row[0]);
    $name = trim($Row[1]);
    $address = trim($Row[2]);
    $phone = trim($Row[3]);

    if ($id != "" && $name != "") {
        if ($address == "") {
            $address = "NA";
        }
        if ($phone == "") {
            $phone = "NA";
        }
        // echo "<br>" . $id . " - " . $name . " - " . $address . " - " . $phone ;
        insert($conn, strtoupper($id), strtoupper($name), strtoupper($address), strtoupper($phone));
    }
}
function insert($conn, $id, $name, $address, $phone)
{
    $insertQuery = "INSERT INTO `tb_customer`(`tb_customer_id`, `tb_customer_staff_id`, 
    `tb_customer_co_barcode`, `tb_customer_cr_no`, `tb_customer_shop_name`, `tb_customer_day`, `tb_customer_name`, `tb_customer_phone`, `tb_customer_email`, `tb_customer_telephone`, `tb_customer_vat_no`, `tb_customer_address`) 
    VALUES 
    ('$id','1','$id','CR_NO','SHOP_NAME','NA','$name','$phone','NA','NA','NA','$address')";
    if (mysqli_query($conn, $insertQuery)) {
        echo "<br>$name Inserted Successfully";
    }
}
