<?php
function addCustomer($conn)
{
    mysqli_autocommit($conn, false);
    $commitTransaction = true;
    $custTableId = $_POST[Customer::$ID];
    if (!checkAlreadyExist($conn, Customer::$TABLE_NAME, Customer::$ID, $custTableId)) {
        $id = $_POST[Customer::$ID];
        $staffId = $_POST['staff_id'];
        $barcode = $_POST[Customer::$COLUMN_BARCODE];
        $crNumber = $_POST[Customer::$COLUMN_CR_NO];
        $shopName = $_POST[Customer::$COLUMN_SHOP_NAME];
        $day = $_POST[Customer::$COLUMN_DAY];
        $name = $_POST[Customer::$COLUMN_NAME];
        $phone = $_POST[Customer::$COLUMN_PHONE];
        $email = $_POST[Customer::$COLUMN_EMAIL];
        $address = $_POST[Customer::$COLUMN_ADDRESS];
        $telephone = $_POST[Customer::$COLUMN_TELEPHONE];
        $vatNo = $_POST[Customer::$COLUMN_VAT_NO];
        $insertCustomerQuery = "INSERT INTO
        " . Customer::$TABLE_NAME . "(
            " . Customer::$ID . " ,
            " . Customer::$STAFF_ID . " ,
            " . Customer::$COLUMN_BARCODE . " ,
            " . Customer::$COLUMN_CR_NO . ",
            " . Customer::$COLUMN_SHOP_NAME . ",
            " . Customer::$COLUMN_DAY . ",
            " . Customer::$COLUMN_NAME . ",
            " . Customer::$COLUMN_PHONE . ",
            " . Customer::$COLUMN_EMAIL . ",
            " . Customer::$COLUMN_TELEPHONE . ",
            " . Customer::$COLUMN_VAT_NO . ",
            " . Customer::$COLUMN_ADDRESS . ") VALUES
        ('$id','$staffId','$barcode','$crNumber','$shopName','$day','$name','$phone','$email','$telephone','$vatNo','$address')";
        if (mysqli_query($conn, $insertCustomerQuery)) {
            $timeStampTime = $_POST['time_stamp'];
            $tableName = Customer::$TABLE_NAME;
            $opCode = $_POST['OP_CODE'];
            $operation = "INSERT";
            $rowId = $id;
            if (!insertIntoSyncLog($conn, $tableName, $rowId, $operation, $opCode, $timeStampTime)) {
                $commitTransaction = false;
            }
        } else {
            $commitTransaction = false;
        }
    }
    if ($commitTransaction) {
        mysqli_commit($conn);
        return true;
    } else {
        mysqli_rollback($conn);
        return false;
    }
}
function addSale($conn)
{
    mysqli_autocommit($conn, false);
    $commitTransaction = true;
    $billId = $_POST[BillDetail::$ID];
    if (!checkAlreadyExist($conn, BillDetail::$TABLE_NAME, BillDetail::$ID, $billId)) {
        $custId = $_POST[BillDetail::$COLUMN_CUST_ID];
        $date = $_POST[BillDetail::$COLUMN_DATE];
        $price = $_POST[BillDetail::$COLUMN_PRICE];
        $qty = $_POST[BillDetail::$COLUMN_QTY];
        $returnTotal = $_POST[BillDetail::$COLUMN_RETURNED_TOTAL];
        $currentTotal = $_POST[BillDetail::$COLUMN_CURRENT_TOTAL];
        $paid = $_POST[BillDetail::$COLUMN_PAID];
        $due = $_POST[BillDetail::$COLUMN_DUE];
        $discount = $_POST[BillDetail::$COLUMN_DISCOUNT];
        $insertBillDeatilQuery = "INSERT INTO " . BillDetail::$TABLE_NAME . "(
            " . BillDetail::$ID . ",
            " . BillDetail::$COLUMN_CUST_ID . ",
            " . BillDetail::$COLUMN_DATE . ",
            " . BillDetail::$COLUMN_PRICE . ",
            " . BillDetail::$COLUMN_QTY . ",
            " . BillDetail::$COLUMN_RETURNED_TOTAL . ",
            " . BillDetail::$COLUMN_CURRENT_TOTAL . ",
            " . BillDetail::$COLUMN_PAID . ",
            " . BillDetail::$COLUMN_DISCOUNT . ",
            " . BillDetail::$COLUMN_DUE . ")
            VALUES ('$billId','$custId','$date','$price',
            '$qty','$returnTotal','$currentTotal','$paid','$discount','$due')";
        if (mysqli_query($conn, $insertBillDeatilQuery)) {
            $timeStampTime = $_POST['time_stamp'];
            $tableName = BillDetail::$TABLE_NAME;
            $opCode = $_POST['OP_CODE'];
            $operation = "INSERT";
            $rowId = $billId;
            if (!insertIntoSyncLog($conn, $tableName, $rowId, $operation, $opCode, $timeStampTime)) {
                $commitTransaction = false;
            } else {
                $cartLength = $_POST['cart_length'];
                for ($i = 0; $i < $cartLength; $i++) {
                    $cartId = $_POST[Cart::$ID . $i];
                    $unitId = $_POST[Cart::$COLUMN_UNIT_ID . $i];
                    $billId = $_POST[Cart::$COLUMN_BILL_ID . $i];
                    $itemId = $_POST[Cart::$COLUMN_ITEM_ID . $i];
                    $name = $_POST[Cart::$COLUMN_NAME . $i];
                    $brand = $_POST[Cart::$COLUMN_BRAND . $i];
                    $category = $_POST[Cart::$COLUMN_CATEGORY . $i];
                    $price = $_POST[Cart::$COLUMN_PRICE . $i];
                    $qty = $_POST[Cart::$COLUMN_QTY . $i];
                    $total = $_POST[Cart::$COLUMN_TOTAL . $i];
                    $returnQty = $_POST[Cart::$COLUMN_RETURN_QTY . $i];
                    $insertCartQuery = "INSERT INTO " . Cart::$TABLE_NAME . "(
                    " . Cart::$ID . ",
                    " . Cart::$COLUMN_BILL_ID . ",
                    " . Cart::$COLUMN_ITEM_ID . ",
                    " . Cart::$COLUMN_UNIT_ID . ",
                    " . Cart::$COLUMN_NAME . ",
                    " . Cart::$COLUMN_BRAND . ",
                    " . Cart::$COLUMN_CATEGORY . ",
                    " . Cart::$COLUMN_PRICE . ",
                    " . Cart::$COLUMN_QTY . ",
                    " . Cart::$COLUMN_TOTAL . ",
                    " . Cart::$COLUMN_RETURN_QTY . "
                     ) VALUES
                     ('$cartId','$billId','$itemId','$unitId','$name','$brand','$category','$price','$qty','$total','$returnQty')";
                    if (!mysqli_query($conn, $insertCartQuery)) {
                        $commitTransaction = false;
                        break;
                    }
                    $timeStampTime = $_POST['time_stamp'];
                    $tableName = Cart::$TABLE_NAME;
                    $opCode = $_POST['OP_CODE'];
                    $operation = "INSERT";
                    $rowId = $cartId;
                    if (!insertIntoSyncLog($conn, $tableName, $rowId, $operation, $opCode, $timeStampTime)) {
                        $commitTransaction = false;
                        break;
                    }
                }
                if ($_POST['payment_length'] > 0) {
                    $paymentId = $_POST[Payment::$ID];
                    $billId = $_POST[Payment::$COLUMN_BILL_ID];
                    $date = $_POST[Payment::$COLUMN_DATE];
                    $amount = $_POST[Payment::$COLUMN_AMOUNT];
                    $type = $_POST[Payment::$COLUMN_TYPE];
                    $insertPayment = "INSERT INTO " . Payment::$TABLE_NAME . "(
                 " . Payment::$ID . ",
                  " . Payment::$COLUMN_BILL_ID . ",
                  " . Payment::$COLUMN_DATE . ",
                  " . Payment::$COLUMN_TYPE . ",
                  " . Payment::$COLUMN_AMOUNT . "
                 ) VALUES
                ('$paymentId','$billId','$date','$type','$amount')";
                    if (!mysqli_query($conn, $insertPayment)) {
                        $commitTransaction = false;
                    } else {
                        $timeStampTime = $_POST['time_stamp'];
                        $tableName = Payment::$TABLE_NAME;
                        $opCode = $_POST['OP_CODE'];
                        $operation = "INSERT";
                        $rowId = $paymentId;
                        if (!insertIntoSyncLog($conn, $tableName, $rowId, $operation, $opCode, $timeStampTime)) {
                            $commitTransaction = false;
                        }
                    }
                }
            }
        } else {

            $commitTransaction = false;
        }
    }
    if ($commitTransaction) {
        mysqli_commit($conn);
        return true;
    } else {
        mysqli_rollback($conn);
        return false;
    }
}
function addPay($conn)
{
    mysqli_autocommit($conn, false);
    $commitTransaction = true;
    $paymentId = $_POST[Payment::$ID];
    if (!checkAlreadyExist($conn, Payment::$TABLE_NAME, Payment::$ID, $paymentId)) {
        $billId = $_POST[Payment::$COLUMN_BILL_ID];
        $date = $_POST[Payment::$COLUMN_DATE];
        $amount = $_POST[Payment::$COLUMN_AMOUNT];
        $type = $_POST[Payment::$COLUMN_TYPE];
        $insertPayment = "INSERT INTO " . Payment::$TABLE_NAME . "(
         " . Payment::$ID . ",
          " . Payment::$COLUMN_BILL_ID . ",
          " . Payment::$COLUMN_DATE . ",
          " . Payment::$COLUMN_TYPE . ",
          " . Payment::$COLUMN_AMOUNT . "
         ) VALUES
        ('$paymentId','$billId','$date','$type','$amount')";
        if (mysqli_query($conn, $insertPayment)) {
            $timeStampTime = $_POST['time_stamp'];
            $tableName = Payment::$TABLE_NAME;
            $opCode = $_POST['OP_CODE'];
            $operation = "INSERT";
            $rowId = $paymentId;
            if (!insertIntoSyncLog($conn, $tableName, $rowId, $operation, $opCode, $timeStampTime)) {
                $commitTransaction = false;
            } else {
                $billId = $_POST[BillDetail::$ID];
                $paidAmount = $_POST[BillDetail::$COLUMN_PAID];
                $discountAmount = $_POST[BillDetail::$COLUMN_DISCOUNT];
                $dueAmount = $_POST[BillDetail::$COLUMN_DUE];
                $updateBillDue = "UPDATE " . BillDetail::$TABLE_NAME . "
            SET " . BillDetail::$COLUMN_PAID . " = '$paidAmount',
            " . BillDetail::$COLUMN_DUE . " = '$dueAmount' ,
            " . BillDetail::$COLUMN_DISCOUNT . " = '$discountAmount'
            WHERE " . BillDetail::$ID . " = '$billId'";
                if (!mysqli_query($conn, $updateBillDue)) {
                    $commitTransaction = false;
                } else {
                    $timeStampTime = $_POST['time_stamp'];
                    $tableName = BillDetail::$TABLE_NAME;
                    $opCode = $_POST['OP_CODE'];
                    $operation = "UPDATE";
                    $rowId = $billId;
                    if (!insertIntoSyncLog($conn, $tableName, $rowId, $operation, $opCode, $timeStampTime)) {
                        $commitTransaction = false;
                    }
                }
            }
        } else {
            $commitTransaction = false;
        }
    }
    if ($commitTransaction) {
        mysqli_commit($conn);
        return true;
    } else {
        mysqli_rollback($conn);
        return false;
    }
}
function addSaleReturn($conn)
{
    mysqli_autocommit($conn, false);
    $commitTransaction = true;
    $salesReturnId = $_POST[SalesReturn::$ID];
    if (!checkAlreadyExist($conn, SalesReturn::$TABLE_NAME, SalesReturn::$ID, $salesReturnId)) {
        $date = $_POST[SalesReturn::$COLUMN_DATE];
        $billId = $_POST[SalesReturn::$COLUMN_BILL_ID];
        $itemId = $_POST[SalesReturn::$COLUMN_ITEM_ID];

        $unitId = $_POST[SalesReturn::$COLUMN_UNIT_ID];
        
        $price = $_POST[SalesReturn::$COLUMN_PRICE];
        $qty = $_POST[SalesReturn::$COLUMN_QTY];
        $total = $_POST[SalesReturn::$COLUMN_TOTAL];
        $insertSalesReturn = "INSERT INTO " . SalesReturn::$TABLE_NAME . "(
          " . SalesReturn::$ID . ",
          " . SalesReturn::$COLUMN_DATE . ",
          " . SalesReturn::$COLUMN_BILL_ID . ",
          " . SalesReturn::$COLUMN_ITEM_ID . ",
          " . SalesReturn::$COLUMN_UNIT_ID . ",
          " . SalesReturn::$COLUMN_PRICE . ",
          " . SalesReturn::$COLUMN_QTY . ",
          " . SalesReturn::$COLUMN_TOTAL . "
         ) VALUES
        ('$salesReturnId','$date','$billId','$itemId','$unitId','$price','$qty','$total')";
        if (mysqli_query($conn, $insertSalesReturn)) {
            $timeStampTime = $_POST['time_stamp'];
            $tableName = SalesReturn::$TABLE_NAME;
            $opCode = $_POST['OP_CODE'];
            $operation = "INSERT";
            $rowId = $salesReturnId;
            if (!insertIntoSyncLog($conn, $tableName, $rowId, $operation, $opCode, $timeStampTime)) {
                $commitTransaction = false;
            } else {
                $billId = $_POST[BillDetail::$ID];
                $returnTotal = $_POST[BillDetail::$COLUMN_RETURNED_TOTAL];
                $currentTotal = $_POST[BillDetail::$COLUMN_CURRENT_TOTAL];
                $currentDue = $_POST[BillDetail::$COLUMN_DUE];
                $updateBillDue = "UPDATE " . BillDetail::$TABLE_NAME . "
                SET " . BillDetail::$COLUMN_RETURNED_TOTAL . " = '$returnTotal' ,
                " . BillDetail::$COLUMN_CURRENT_TOTAL . " = '$currentTotal' ,
                " . BillDetail::$COLUMN_DUE . " = '$currentDue'
                WHERE " . BillDetail::$ID . " = '$billId'";
                if (mysqli_query($conn, $updateBillDue)) {
                    $timeStampTime = $_POST['time_stamp'];
                    $tableName = BillDetail::$TABLE_NAME;
                    $opCode = $_POST['OP_CODE'];
                    $operation = "UPDATE";
                    $rowId = $billId;
                    if (!insertIntoSyncLog($conn, $tableName, $rowId, $operation, $opCode, $timeStampTime)) {
                        $commitTransaction = false;
                    } else {
                        $cartId = $_POST[Cart::$ID];
                        $returnQty = $_POST[Cart::$COLUMN_RETURN_QTY];

                        $updateCart = "UPDATE " . Cart::$TABLE_NAME . "
                        SET " . Cart::$COLUMN_RETURN_QTY . " = '$returnQty'
                        WHERE " . Cart::$ID . " = '$cartId'";
                        if (mysqli_query($conn, $updateCart)) {
                            $timeStampTime = $_POST['time_stamp'];
                            $tableName = Cart::$TABLE_NAME;
                            $opCode = $_POST['OP_CODE'];
                            $operation = "UPDATE";
                            $rowId = $cartId;
                            if (!insertIntoSyncLog($conn, $tableName, $rowId, $operation, $opCode, $timeStampTime)) {
                                $commitTransaction = false;
                            }
                        } else {
                            $commitTransaction = false;
                        }
                    }
                } else {
                    $commitTransaction = false;
                }
            }
        } else {
            $commitTransaction = false;
        }
    }
    if ($commitTransaction) {
        mysqli_commit($conn);
        return true;
    } else {
        mysqli_rollback($conn);
        return false;
    }
}

function checkAlreadyExist($conn, $tableName, $selection, $id)
{
    $sqlQueryForCheckAlreadyExist = "SELECT * FROM $tableName WHERE $selection = '$id'";
    $result = mysqli_query($conn, $sqlQueryForCheckAlreadyExist);
    return mysqli_num_rows($result) > 0;
}

function insertIntoSyncLog($conn, $tableName, $rowId, $operation, $opCode, $timestamps)
{
    $insertSyncLogQuery = "INSERT INTO " . AppSync::$TABLE_NAME . "
    (" . AppSync::$COLUMN_OP_CODE . " ,
    " . AppSync::$COLUMN_TIMESTAMP . " ,
    " . AppSync::$COLUMN_ROW_ID . " ,
      " . AppSync::$COLUMN_TABLE_NAME . " ,
      " . AppSync::$COLUMN_OPERATION . " )
      VALUES
    ('$opCode','$timestamps','$rowId','$tableName','$operation')";
    return mysqli_query($conn, $insertSyncLogQuery);
}
