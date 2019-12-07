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

$Reader = new SpreadsheetReader('file/item.xls');
$Reader->ChangeSheet(0);

foreach ($Reader as $Row) {
    $id = trim($Row[0]);
    $name = trim($Row[2]);
    $brand = trim($Row[10]);
    $category = trim($Row[7]);
    $price = trim($Row[14]);

    if ($id != "" && $name != "" && $price != "") {
        if ($brand == "") {
            $brand = "NA";
        }
        if ($category == "") {
            $category = "NA";
        }
      //  echo "<br>" . $id . " - " . $name . " - " . $brand . " - " . $category . " - " . $price;
        insert($conn, strtoupper($id), strtoupper($name), strtoupper($category), strtoupper($brand), strtoupper($price));
    }
}
function insert($conn, $id, $name, $cat, $brand, $price)
{
    $insertQuery = "INSERT INTO `tb_item`( `tb_item_id`,`tb_item_unit_id`, `tb_item_co_barcode`, `tb_item_name`, `tb_item_brand`, `tb_item_category`, `tb_item_price`)
    VALUES ('$id','1A','$id','$name','$brand','$cat','$price');";
    if (mysqli_query($conn, $insertQuery)) {
        echo "<br>$name Inserted Successfully";
    }
}
