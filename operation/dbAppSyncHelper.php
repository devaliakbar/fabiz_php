<?php
include('appOperation.php');
function performSyncOnApp($conn)
{
    $OP_CODE = $_POST['OP_CODE'];
    $SUCCESS = false;
    switch ($OP_CODE) {
        case "ADD_CUST":
            $SUCCESS = addCustomer($conn);
            break;
        case "SALE":
            $SUCCESS = addSale($conn);
            break;
        case "PAY":
            $SUCCESS = addPay($conn);
            break;
        case "SALE_RETURN":
            $SUCCESS = addSaleReturn($conn);
            break;
    }
    return $SUCCESS;
}