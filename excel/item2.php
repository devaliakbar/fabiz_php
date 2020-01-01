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

$Reader = new SpreadsheetReader('file/item2.xlsx');
$Reader->ChangeSheet(0);

foreach ($Reader as $Row) {
    $id = trim($Row[0]);
    $name = trim($Row[1]);
    $brand = trim($Row[8]);
    $category = trim($Row[5]);
    $price = '12';
    $barcode = trim($Row[4]);

    if ($id != "" && $name != "" && $price != "") {
        if ($brand == "") {
            $brand = "NA";
        }
        if ($category == "") {
            $category = "NA";
        }
      //  echo "<br>" . $id . " - " . $name . " - " . $brand . " - " . $category . " - " . $price;
        insert($conn, strtoupper($id), strtoupper($name), strtoupper($category), strtoupper($brand), strtoupper($price),$barcode);
    }
}
function insert($conn, $id, $name, $cat, $brand, $price,$barcode)
{
    $insertQuery = "INSERT INTO `tb_item`( `tb_item_id`,`tb_item_unit_id`, `tb_item_co_barcode`, `tb_item_name`, `tb_item_brand`, `tb_item_category`, `tb_item_price`)
    VALUES ('$id','1A','$barcode','$name','$brand','$cat','$price');";
    if (mysqli_query($conn, $insertQuery)) {
        echo "<br>$name Inserted Successfully";
    }
}
