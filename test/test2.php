<?php
function performSyncOnApp($conn)
{

    $operation = $_POST['OP'];
    $tableName = $_POST['TABLE'];
    $idOfRow = $_POST['ID'];

    $idOfRowForSync = "";

    $idOfRowForSync = getIdFromAppId($conn, $tableName, $idOfRow);

    $SQL_EXECUTE = "";

    switch ($tableName) {
        case AccountDetail::$TABLE_NAME:
            if ($operation == "DELETE") {
                $SQL_EXECUTE = "DELETE FROM  $tableName  WHERE " . AccountDetail::$ID . " = $idOfRowForSync;";
            } else {
                $SQL_EXECUTE = setUpAccountDetail($operation, $conn, $idOfRowForSync);
            }
            break;

        case Item::$TABLE_NAME:
            if ($operation == "DELETE") {
                $SQL_EXECUTE = "DELETE FROM  $tableName  WHERE " . Item::$ID . " = $idOfRowForSync;";
            } else {
                $SQL_EXECUTE = setUpItem($operation, $conn, $idOfRowForSync);
            }
            break;

        case Customer::$TABLE_NAME:
            if ($operation == "DELETE") {
                $SQL_EXECUTE = "DELETE FROM  $tableName  WHERE " . Customer::$ID . " = $idOfRowForSync;";
            } else {
                $SQL_EXECUTE = setUpCustomer($operation, $conn, $idOfRowForSync);
            }
            break;

        case BillDetail::$TABLE_NAME:
            if ($operation == "DELETE") {
                $SQL_EXECUTE = "DELETE FROM  $tableName  WHERE " . BillDetail::$ID . " = $idOfRowForSync;";
            } else {
                $SQL_EXECUTE = setUpBillDetail($operation, $conn, $idOfRowForSync);
            }
            break;

        case Cart::$TABLE_NAME:
            if ($operation == "DELETE") {
                $SQL_EXECUTE = "DELETE FROM  $tableName  WHERE " . Cart::$ID . " = $idOfRowForSync;";
            } else {
                $SQL_EXECUTE = setUpCart($operation, $conn, $idOfRowForSync);
            }
            break;

        case SalesReturn::$TABLE_NAME:
            if ($operation == "DELETE") {
                $SQL_EXECUTE = "DELETE FROM  $tableName  WHERE " . SalesReturn::$ID . " = $idOfRowForSync;";
            } else {
                $SQL_EXECUTE = setUpSalesReturn($operation, $conn, $idOfRowForSync);
            }
            break;

        case Payment::$TABLE_NAME:
            if ($operation == "DELETE") {
                $SQL_EXECUTE = "DELETE FROM  $tableName  WHERE " . Payment::$ID . " = $idOfRowForSync;";
            } else {
                $SQL_EXECUTE = setUpPayment($operation, $conn, $idOfRowForSync);
            }
            break;
    }

    if ($SQL_EXECUTE == null) {
        return true;
    } else {
        if (mysqli_query($conn, $SQL_EXECUTE)) {

            if ($operation == "INSERT") {
                $idOfRowForSync = mysqli_insert_id($conn);
            }

            $SQL_INSERT_APP_SYNC_QUERY = "INSERT INTO " . AppSync::$TABLE_NAME . "(
                " . AppSync::$COLUMN_ROW_ID . ",
                " . AppSync::$COLUMN_TABLE_NAME . ",
                " . AppSync::$COLUMN_OPERATION . ") VALUES
                ('$idOfRowForSync',
                '$tableName',
                '$operation'
                )";

            return mysqli_query($conn, $SQL_INSERT_APP_SYNC_QUERY);
        }
    }

}

function setUpAccountDetail($operation, $conn, $idOfRowForSync)
{
    $returnSqlString = "";
    $appId = $_POST['_id'];
    $custId = $_POST[AccountDetail::$COLUMN_CUSTOMER_ID];
    $total = $_POST[AccountDetail::$COLUMN_TOTAL];
    $paid = $_POST[AccountDetail::$COLUMN_PAID];
    $due = $_POST[AccountDetail::$COLUMN_DUE];

    if ($operation == "UPDATE") {
        $returnSqlString = "UPDATE " . AccountDetail::$TABLE_NAME . " SET
        " . AccountDetail::$COLUMN_CUSTOMER_ID . " ='$custId',
        " . AccountDetail::$COLUMN_TOTAL . " ='$total',
        " . AccountDetail::$COLUMN_PAID . " ='$paid',
        " . AccountDetail::$COLUMN_DUE . " ='$due'
        WHERE " . AccountDetail::$ID . " = '$idOfRowForSync'";
    } else {
        if ($idOfRowForSync != "") {
            $returnSqlString = null;
        } else {
            $returnSqlString = "INSERT INTO " . AccountDetail::$TABLE_NAME . "
            (" . AccountDetail::$appId . " ,
              " . AccountDetail::$COLUMN_CUSTOMER_ID . " ,
              " . AccountDetail::$COLUMN_TOTAL . " ,
              " . AccountDetail::$COLUMN_PAID . " ,
              " . AccountDetail::$COLUMN_DUE . " ) VALUES
            ($appId,$custId,$total,$paid,$due)";
        }
    }
    return $returnSqlString;
}

function setUpItem($operation, $conn, $idOfRowForSync)
{
    $returnSqlString = "";
    $appId = $_POST['_id'];
    $name = $_POST[Item::$COLUMN_NAME];
    $brand = $_POST[Item::$COLUMN_BRAND];
    $catagory = $_POST[Item::$COLUMN_CATEGORY];
    $price = $_POST[Item::$COLUMN_PRICE];

    if ($operation == "UPDATE") {
        $returnSqlString = "UPDATE " . Item::$TABLE_NAME . " SET
       " . Item::$COLUMN_NAME . " ='$name',
        " . Item::$COLUMN_BRAND . " ='$brand',
        " . Item::$COLUMN_CATEGORY . " ='$catagory',
        " . Item::$COLUMN_PRICE . " ='$price'
         WHERE " . Item::$ID . " = '$idOfRowForSync'";
    } else {
        if ($idOfRowForSync != "") {
            $returnSqlString = null;
        } else {
            $returnSqlString = "INSERT INTO
            " . Item::$TABLE_NAME . "(
                " . Item::$appId . ",
                " . Item::$COLUMN_NAME . ",
                " . Item::$COLUMN_BRAND . ",
                " . Item::$COLUMN_CATEGORY . ",
                " . Item::$COLUMN_PRICE . ")
            VALUES
             ('$appId','$name','$brand','$catagory','$price')";
        }
    }
    return $returnSqlString;
}

function setUpCustomer($operation, $conn, $idOfRowForSync)
{
    $returnSqlString = "";
    $appId = $_POST['_id'];
    $staffId = $_POST['my_username'];
    $crNumber = $_POST[Customer::$COLUMN_CR_NO];
    $shopName = $_POST[Customer::$COLUMN_SHOP_NAME];
    $name = $_POST[Customer::$COLUMN_NAME];
    $phone = $_POST[Customer::$COLUMN_PHONE];
    $email = $_POST[Customer::$COLUMN_EMAIL];
    $address = $_POST[Customer::$COLUMN_ADDRESS];
    if ($operation == "UPDATE") {
        $returnSqlString = "UPDATE " . Customer::$TABLE_NAME . " SET " .
        Customer::$STAFF_ID . " = '$staffId',
        " . Customer::$COLUMN_CR_NO . "='$crNumber',
        " . Customer::$COLUMN_SHOP_NAME . "='$shopName',
        " . Customer::$COLUMN_NAME . "='$name',
        " . Customer::$COLUMN_PHONE . "='$phone',
        " . Customer::$COLUMN_EMAIL . "='$email',
        " . Customer::$COLUMN_ADDRESS . "='$address'
         WHERE  " . Customer::$ID . "= '$idOfRowForSync'";
    } else {
        if ($idOfRowForSync != "") {
            $returnSqlString = null;
        } else {
            $returnSqlString = "INSERT INTO
            " . Customer::$TABLE_NAME . "(
                " . Customer::$appId . " ,
                " . Customer::$STAFF_ID . " ,
                " . Customer::$COLUMN_CR_NO . ",
                " . Customer::$COLUMN_SHOP_NAME . ",
                " . Customer::$COLUMN_NAME . ",
                " . Customer::$COLUMN_PHONE . ",
                " . Customer::$COLUMN_EMAIL . ",
                " . Customer::$COLUMN_ADDRESS . ") VALUES
            ('$appId','$staffId','$crNumber','$shopName','$name','$phone','$email','$address')";
        }
    }
    return $returnSqlString;
}

function setUpBillDetail($operation, $conn, $idOfRowForSync)
{
    $returnSqlString = "";
    $appId = $_POST['_id'];
    $dateBill = $_POST[BillDetail::$COLUMN_DATE];
    $custId = $_POST[BillDetail::$COLUMN_CUST_ID];
    $price = $_POST[BillDetail::$COLUMN_PRICE];
    $qty = $_POST[BillDetail::$COLUMN_QTY];

    if ($operation == "UPDATE") {
        $returnSqlString = "UPDATE " . BillDetail::$TABLE_NAME . " SET
        " . BillDetail::$COLUMN_DATE . "='$dateBill',
        " . BillDetail::$COLUMN_CUST_ID . "='$custId',
        " . BillDetail::$COLUMN_PRICE . "='$price',
        " . BillDetail::$COLUMN_QTY . "='$qty'
                            WHERE " . BillDetail::$ID . "= '$idOfRowForSync'";
    } else {
        if ($idOfRowForSync != "") {
            $returnSqlString = null;
        } else {
            $returnSqlString = "INSERT INTO
            " . BillDetail::$TABLE_NAME . "(
                " . BillDetail::$appId . ",
                " . BillDetail::$COLUMN_DATE . ",
                " . BillDetail::$COLUMN_CUST_ID . ",
                " . BillDetail::$COLUMN_PRICE . ",
                " . BillDetail::$COLUMN_QTY . ") VALUES
            ('$appId','$dateBill','$custId','$price','$qty')";
        }
    }
    return $returnSqlString;
}

function setUpCart($operation, $conn, $idOfRowForSync)
{
    $returnSqlString = "";
    $appId = $_POST['_id'];
    $billId = $_POST[Cart::$COLUMN_BILL_ID];
    $itemId = $_POST[Cart::$COLUMN_ITEM_ID];
    $name = $_POST[Cart::$COLUMN_NAME];
    $brand = $_POST[Cart::$COLUMN_BRAND];
    $category = $_POST[Cart::$COLUMN_CATEGORY];
    $price = $_POST[Cart::$COLUMN_PRICE];
    $qty = $_POST[Cart::$COLUMN_QTY];
    $total = $_POST[Cart::$COLUMN_TOTAL];
    $returnQty = $_POST[Cart::$COLUMN_RETURN_QTY];

    if ($operation == "UPDATE") {
        $returnSqlString = "UPDATE " . Cart::$TABLE_NAME . " SET
        " . Cart::$COLUMN_BILL_ID . "='$billId',
        " . Cart::$COLUMN_ITEM_ID . "='$itemId',
        " . Cart::$COLUMN_NAME . "='$name',
        " . Cart::$COLUMN_BRAND . "='$brand',
        " . Cart::$COLUMN_CATEGORY . "='$category',
        " . Cart::$COLUMN_PRICE . "='$price',
        " . Cart::$COLUMN_QTY . "='$qty',
        " . Cart::$COLUMN_TOTAL . "='$total',
        " . Cart::$COLUMN_RETURN_QTY . "='$returnQty'
        WHERE " . Cart::$ID . "= '$idOfRowForSync'";
    } else {
        if ($idOfRowForSync != "") {
            $returnSqlString = null;
        } else {
            $returnSqlString = "INSERT
            INTO " . Cart::$TABLE_NAME . "(
               " . Cart::$appId . ",
               " . Cart::$COLUMN_BILL_ID . ",
               " . Cart::$COLUMN_ITEM_ID . ",
               " . Cart::$COLUMN_NAME . ",
               " . Cart::$COLUMN_BRAND . ",
               " . Cart::$COLUMN_CATEGORY . ",
               " . Cart::$COLUMN_PRICE . ",
               " . Cart::$COLUMN_QTY . ",
               " . Cart::$COLUMN_TOTAL . ",
               " . Cart::$COLUMN_RETURN_QTY . ") VALUES
            ('$appId','$billId','$itemId','$name','$brand','$category','$price','$qty','$total','$returnQty')";
        }
    }
    return $returnSqlString;
}

function setUpSalesReturn($operation, $conn, $idOfRowForSync)
{
    $returnSqlString = "";
    $appId = $_POST['_id'];
    $dateRe = $_POST[SalesReturn::$COLUMN_DATE];
    $billId = $_POST[SalesReturn::$COLUMN_BILL_ID];
    $itemId = $_POST[SalesReturn::$COLUMN_ITEM_ID];
    $price = $_POST[SalesReturn::$COLUMN_PRICE];
    $qty = $_POST[SalesReturn::$COLUMN_QTY];
    $total = $_POST[SalesReturn::$COLUMN_TOTAL];
    if ($operation == "UPDATE") {
        $returnSqlString = "UPDATE " . SalesReturn::$TABLE_NAME . " SET
        " . SalesReturn::$COLUMN_DATE . "='$dateRe',
        " . SalesReturn::$COLUMN_BILL_ID . "='$billId',
        " . SalesReturn::$COLUMN_ITEM_ID . "='$itemId',
        " . SalesReturn::$COLUMN_PRICE . "='$price',
        " . SalesReturn::$COLUMN_QTY . "='$qty',
        " . SalesReturn::$COLUMN_TOTAL . "='$total'
        WHERE " . SalesReturn::$ID . "= '$idOfRowForSync'";
    } else {
        if ($idOfRowForSync != "") {
            $returnSqlString = null;
        } else {
            $returnSqlString = "INSERT
            INTO " . SalesReturn::$TABLE_NAME . "(
                " . SalesReturn::$appId . ",
                " . SalesReturn::$COLUMN_DATE . ",
                " . SalesReturn::$COLUMN_BILL_ID . ",
                " . SalesReturn::$COLUMN_ITEM_ID . ",
                " . SalesReturn::$COLUMN_PRICE . ",
                " . SalesReturn::$COLUMN_QTY . ",
                " . SalesReturn::$COLUMN_TOTAL . ") VALUES
             ('$appId','$dateRe','$billId','$itemId','$price','$qty','$total')";
        }
    }
    return $returnSqlString;
}

function setUpPayment($operation, $conn, $idOfRowForSync)
{
    $returnSqlString = "";
    $appId = $_POST['_id'];
    $custId = $_POST[Payment::$COLUMN_CUST_ID];
    $dateOfReturn = $_POST[Payment::$COLUMN_DATE];
    $amount = $_POST[Payment::$COLUMN_AMOUNT];
    $total = $_POST[Payment::$COLUMN_TOTAL];
    $paid = $_POST[Payment::$COLUMN_PAID];
    $due = $_POST[Payment::$COLUMN_DUE];
    if ($operation == "UPDATE") {
        $returnSqlString = "UPDATE " . Payment::$TABLE_NAME . " SET
        " . Payment::$COLUMN_CUST_ID . "='$custId',
        " . Payment::$COLUMN_DATE . "='$dateOfReturn',
        " . Payment::$COLUMN_AMOUNT . "='$amount',
        " . Payment::$COLUMN_TOTAL . "='$total',
        " . Payment::$COLUMN_PAID . "='$paid',
        " . Payment::$COLUMN_DUE . "='$due' WHERE
        " . Payment::$ID . "= '$idOfRowForSync'";
    } else {
        if ($idOfRowForSync != "") {
            $returnSqlString = null;
        } else {
            $returnSqlString = "INSERT INTO
            " . Payment::$TABLE_NAME . "(
                " . Payment::$appId . ",
                " . Payment::$COLUMN_CUST_ID . ",
                " . Payment::$COLUMN_DATE . ",
                " . Payment::$COLUMN_AMOUNT . ",
                " . Payment::$COLUMN_TOTAL . ",
                " . Payment::$COLUMN_PAID . ",
                " . Payment::$COLUMN_DUE . ") VALUES
            ('$appId','$custId','$dateOfReturn','$amount','$total','$paid','$due')";
        }
    }
    return $returnSqlString;
}

function getIdFromAppId($conn, $tableName, $idOfRow)
{
    $SQL_EXECUTE = "";
    $staffId = $_POST['my_username'];
    switch ($tableName) {
        case AccountDetail::$TABLE_NAME:
            $SQL_EXECUTE = "SELECT tb_account_detail._id AS id_for_update FROM tb_account_detail INNER JOIN tb_customer ON
                        tb_account_detail.tb_account_detail_customer_id = tb_customer.app_id
                        WHERE tb_account_detail.app_id = '$idOfRow' AND tb_customer.staff_id = '$staffId'";
            break;

        case Customer::$TABLE_NAME:
            $SQL_EXECUTE = "SELECT _id AS id_for_update FROM tb_customer WHERE staff_id = '$staffId' AND app_id ='$idOfRow'";
            break;

        case BillDetail::$TABLE_NAME:
            $SQL_EXECUTE = "SELECT tb_bill_detail._id AS id_for_update FROM
            tb_bill_detail INNER JOIN  tb_customer ON tb_bill_detail.tb_bill_detail_custid = tb_customer.app_id
            WHERE tb_customer.staff_id = '$staffId' AND tb_bill_detail.app_id ='$idOfRow'";
            break;

        case Cart::$TABLE_NAME:

            $SQL_EXECUTE = "SELECT tb_cart._id AS id_for_update FROM
        tb_cart INNER JOIN tb_bill_detail ON tb_cart.tb_cart_billid = tb_bill_detail.app_id
        INNER JOIN  tb_customer ON tb_bill_detail.tb_bill_detail_custid = tb_customer.app_id
        WHERE tb_customer.staff_id = '$staffId' AND tb_cart.app_id ='$idOfRow'";

            break;

        case SalesReturn::$TABLE_NAME:
            $SQL_EXECUTE = "SELECT tb_sales_return._id AS id_for_update FROM
        tb_sales_return INNER JOIN tb_bill_detail ON tb_sales_return.tb_sales_return_billid = tb_bill_detail.app_id
        INNER JOIN  tb_customer ON tb_bill_detail.tb_bill_detail_custid = tb_customer.app_id
        WHERE tb_customer.staff_id = '$staffId' AND tb_sales_return.app_id ='$idOfRow'";

            break;

        case Payment::$TABLE_NAME:
            $SQL_EXECUTE = "SELECT tb_payment._id AS id_for_update FROM
        tb_payment INNER JOIN  tb_customer ON tb_payment.tb_payment_custid = tb_customer.app_id
        WHERE tb_customer.staff_id = '$staffId' AND tb_payment.app_id ='$idOfRow'";
            break;
    }

    $result = mysqli_query($conn, $SQL_EXECUTE);
    $returnId = "";
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $returnId = $row["id_for_update"];
        }
    }
    return $returnId;

}
