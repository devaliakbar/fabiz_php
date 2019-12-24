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
$staffId = 1;
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
        insert($conn, strtoupper($id), strtoupper($name), strtoupper($address), strtoupper($phone),$staffId);
        if($staffId == 1){
            $staffId = 2;
        }else{
            $staffId =1;
        }
    }
}
function insert($conn, $id, $name, $address, $phone, $staffId)
{
    $insertQuery = "INSERT INTO `tb_customer`(`tb_customer_id`, `tb_customer_staff_id`, 
    `tb_customer_co_barcode`, `tb_customer_cr_no`, `tb_customer_shop_name`, `tb_customer_day`, `tb_customer_name`, `tb_customer_phone`, `tb_customer_email`, `tb_customer_telephone`, `tb_customer_vat_no`, `tb_customer_address_area`,`tb_customer_address_road`,`tb_customer_address_block`,`tb_customer_address_shop_num`) 
    VALUES 
    ('$id','$staffId','$id','CR_NO','$name','NA','Contact Person','$phone','NA','NA','NA','$address','NA','NA','NA')";
    if (mysqli_query($conn, $insertQuery)) {
        echo "<br>$name Inserted Successfully";
    }else{
        mysqli_error();
        die();
    }
}