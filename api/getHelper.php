<?php
function addCustomer($conn, $timeStamp)
{ 
    $returnOpArray = array();
    $returnOpArray['operation'] = 'add_customer';
    $selectRawQuery = "SELECT * FROM " . AppSync::$TABLE_NAME . " WHERE " . AppSync::$COLUMN_TIMESTAMP . " ='$timeStamp' ORDER BY " . AppSync::$ID . " ASC";
    $selectRawResult = mysqli_query($conn, $selectRawQuery);
    $tableOperation = array();
    if (mysqli_num_rows($selectRawResult) > 0) {
        while ($row = mysqli_fetch_assoc($selectRawResult)) {
            $rawId = $row[AppSync::$COLUMN_ROW_ID];
            $tableName = $row[AppSync::$COLUMN_TABLE_NAME];
            if ($tableName == Customer::$TABLE_NAME) {
                $ttableOperation = array();
                $ttableOperation['table_name'] = Customer::$TABLE_NAME;
                $ttableOperation['operation'] = "insert";
                $selectCurrentRow = "SELECT * FROM " . Customer::$TABLE_NAME . " WHERE " . Customer::$ID . " = '$rawId';";
                $selectCurrentRowResult = mysqli_query($conn, $selectCurrentRow);
                if (mysqli_num_rows($selectCurrentRowResult) > 0) {
                    $rows = array();
                    while ($row = mysqli_fetch_assoc($selectCurrentRowResult)) {
                        $rows[Customer::$ID] = $row[Customer::$ID];
                        $rows[Customer::$STAFF_ID] = $row[Customer::$STAFF_ID];
                        $rows[Customer::$COLUMN_CR_NO] = $row[Customer::$COLUMN_CR_NO];
                        $rows[Customer::$COLUMN_SHOP_NAME] = $row[Customer::$COLUMN_SHOP_NAME];
                        $rows[Customer::$COLUMN_NAME] = $row[Customer::$COLUMN_NAME];
                        $rows[Customer::$COLUMN_DAY] = $row[Customer::$COLUMN_DAY];
                        $rows[Customer::$COLUMN_PHONE] = $row[Customer::$COLUMN_PHONE];
                        $rows[Customer::$COLUMN_EMAIL] = $row[Customer::$COLUMN_EMAIL];
                        $rows[Customer::$COLUMN_ADDRESS] = $row[Customer::$COLUMN_ADDRESS];
                        $rows[Customer::$COLUMN_TELEPHONE] = $row[Customer::$COLUMN_TELEPHONE];
                        $rows[Customer::$COLUMN_VAT_NO] = $row[Customer::$COLUMN_VAT_NO];
                    }
                }
                $ttableOperation['row'] = $rows;
                array_push($tableOperation, $ttableOperation);
            }
        }
    }
    $returnOpArray['table_operation'] = $tableOperation;
    return $returnOpArray;
}

function addSales($conn, $timeStamp)
{
    $returnOpArray = array();
    $returnOpArray['operation'] = 'sales';
    $selectRawQuery = "SELECT * FROM " . AppSync::$TABLE_NAME . " WHERE " . AppSync::$COLUMN_TIMESTAMP . " ='$timeStamp' ORDER BY " . AppSync::$ID . " ASC";
    $selectRawResult = mysqli_query($conn, $selectRawQuery);
    $tableOperation = array();
    if (mysqli_num_rows($selectRawResult) > 0) {
        while ($row = mysqli_fetch_assoc($selectRawResult)) {
            $rawId = $row[AppSync::$COLUMN_ROW_ID];
            $tableName = $row[AppSync::$COLUMN_TABLE_NAME];
            if ($tableName == BillDetail::$TABLE_NAME) {
                $ttableOperation = array();
                $ttableOperation['table_name'] = BillDetail::$TABLE_NAME;
                $ttableOperation['operation'] = "insert";
                $selectCurrentRow = "SELECT * FROM " . BillDetail::$TABLE_NAME . " WHERE " . BillDetail::$ID . " = '$rawId';";
                $selectCurrentRowResult = mysqli_query($conn, $selectCurrentRow);
                if (mysqli_num_rows($selectCurrentRowResult) > 0) {
                    $rows = array();
                    while ($row = mysqli_fetch_assoc($selectCurrentRowResult)) {
                        $rows[BillDetail::$ID] = $row[BillDetail::$ID];
                        $rows[BillDetail::$COLUMN_DATE] = $row[BillDetail::$COLUMN_DATE];
                        $rows[BillDetail::$COLUMN_CUST_ID] = $row[BillDetail::$COLUMN_CUST_ID];
                        $rows[BillDetail::$COLUMN_QTY] = $row[BillDetail::$COLUMN_QTY];
                        $rows[BillDetail::$COLUMN_PRICE] = $row[BillDetail::$COLUMN_PRICE];

                        $rows[BillDetail::$TABLE_NAME."_total_vat_amount"] = '0';
                        $rows[BillDetail::$TABLE_NAME."_grand_total"] = $row[BillDetail::$COLUMN_PRICE];

                        $rows[BillDetail::$COLUMN_RETURNED_TOTAL] = $row[BillDetail::$COLUMN_RETURNED_TOTAL];
                        $rows[BillDetail::$COLUMN_CURRENT_TOTAL] = $row[BillDetail::$COLUMN_CURRENT_TOTAL];
                        $rows[BillDetail::$COLUMN_PAID] = $row[BillDetail::$COLUMN_PAID];
                        $rows[BillDetail::$COLUMN_DUE] = $row[BillDetail::$COLUMN_DUE];
                        $rows[BillDetail::$COLUMN_DISCOUNT] = $row[BillDetail::$COLUMN_DISCOUNT];
                    } 
                }
                $ttableOperation['row'] = $rows;
                array_push($tableOperation, $ttableOperation);
            } elseif ($tableName == Cart::$TABLE_NAME) {
                $ttableOperation = array();
                $ttableOperation['table_name'] = Cart::$TABLE_NAME;
                $ttableOperation['operation'] = "insert";
                $selectCurrentRow = "SELECT * FROM " . Cart::$TABLE_NAME . " WHERE " . Cart::$ID . " = '$rawId';";
                $selectCurrentRowResult = mysqli_query($conn, $selectCurrentRow);
                if (mysqli_num_rows($selectCurrentRowResult) > 0) {
                    $rows = array();
                    while ($row = mysqli_fetch_assoc($selectCurrentRowResult)) {
                        $rows[Cart::$ID] = $row[Cart::$ID];
                        $rows[Cart::$COLUMN_BILL_ID] = $row[Cart::$COLUMN_BILL_ID];
                        $rows[Cart::$COLUMN_ITEM_ID] = $row[Cart::$COLUMN_ITEM_ID];
                        $rows[Cart::$COLUMN_UNIT_ID] = $row[Cart::$COLUMN_UNIT_ID];
                        $rows[Cart::$COLUMN_NAME] = $row[Cart::$COLUMN_NAME];
                        $rows[Cart::$COLUMN_BRAND] = $row[Cart::$COLUMN_BRAND];
                        $rows[Cart::$COLUMN_CATEGORY] = $row[Cart::$COLUMN_CATEGORY];
                        $rows[Cart::$COLUMN_PRICE] = $row[Cart::$COLUMN_PRICE];

                        $rows[Cart::$TABLE_NAME."_item_vat_percentage"] = '0';
                        $rows[Cart::$TABLE_NAME."_item_vat_amount"] = '0';
                        $rows[Cart::$TABLE_NAME."_item_total_price"] = $row[Cart::$COLUMN_PRICE];

                        $rows[Cart::$COLUMN_QTY] = $row[Cart::$COLUMN_QTY];
                        $rows[Cart::$COLUMN_TOTAL] = $row[Cart::$COLUMN_TOTAL];
                        $rows[Cart::$TABLE_NAME."_total_vat_amount"] = '0';
                        $rows[Cart::$TABLE_NAME."_grand_total"] =  $row[Cart::$COLUMN_TOTAL];
                        $rows[Cart::$COLUMN_RETURN_QTY] = $row[Cart::$COLUMN_RETURN_QTY];
                    }
                }
                $ttableOperation['row'] = $rows;
                array_push($tableOperation, $ttableOperation);
            } elseif ($tableName == Payment::$TABLE_NAME) {
                $ttableOperation = array();
                $ttableOperation['table_name'] = Payment::$TABLE_NAME;
                $ttableOperation['operation'] = "insert";
                $selectCurrentRow = "SELECT * FROM " . Payment::$TABLE_NAME . " WHERE " . Payment::$ID . " = '$rawId';";
                $selectCurrentRowResult = mysqli_query($conn, $selectCurrentRow);
                if (mysqli_num_rows($selectCurrentRowResult) > 0) {
                    $rows = array();
                    while ($row = mysqli_fetch_assoc($selectCurrentRowResult)) {
                        $rows[Payment::$ID] = $row[Payment::$ID];
                        $rows[Payment::$COLUMN_BILL_ID] = $row[Payment::$COLUMN_BILL_ID];
                        $rows[Payment::$COLUMN_DATE] = $row[Payment::$COLUMN_DATE];
                        $rows[Payment::$COLUMN_TYPE] = $row[Payment::$COLUMN_TYPE];
                        $rows[Payment::$COLUMN_AMOUNT] = $row[Payment::$COLUMN_AMOUNT];
                    }
                }
                $ttableOperation['row'] = $rows;
                array_push($tableOperation, $ttableOperation);
            }
        }
    }
    $returnOpArray['table_operation'] = $tableOperation;
    return $returnOpArray;
}

function addPayment($conn, $timeStamp)
{
    $returnOpArray = array();
    $returnOpArray['operation'] = 'add_payment';
    $selectRawQuery = "SELECT * FROM " . AppSync::$TABLE_NAME . " WHERE " . AppSync::$COLUMN_TIMESTAMP . " ='$timeStamp' ORDER BY " . AppSync::$ID . " ASC";
    $selectRawResult = mysqli_query($conn, $selectRawQuery);
    $tableOperation = array();
    if (mysqli_num_rows($selectRawResult) > 0) {
        while ($row = mysqli_fetch_assoc($selectRawResult)) {
            $rawId = $row[AppSync::$COLUMN_ROW_ID];
            $tableName = $row[AppSync::$COLUMN_TABLE_NAME];
            if ($tableName == Payment::$TABLE_NAME) {
                $ttableOperation = array();
                $ttableOperation['table_name'] = Payment::$TABLE_NAME;
                $ttableOperation['operation'] = "insert";
                $selectCurrentRow = "SELECT * FROM " . Payment::$TABLE_NAME . " WHERE " . Payment::$ID . " = '$rawId';";
                $selectCurrentRowResult = mysqli_query($conn, $selectCurrentRow);
                if (mysqli_num_rows($selectCurrentRowResult) > 0) {
                    $rows = array();
                    while ($row = mysqli_fetch_assoc($selectCurrentRowResult)) {
                        $rows[Payment::$ID] = $row[Payment::$ID];
                        $rows[Payment::$COLUMN_BILL_ID] = $row[Payment::$COLUMN_BILL_ID];
                        $rows[Payment::$COLUMN_DATE] = $row[Payment::$COLUMN_DATE];
                        $rows[Payment::$COLUMN_TYPE] = $row[Payment::$COLUMN_TYPE];
                        $rows[Payment::$COLUMN_AMOUNT] = $row[Payment::$COLUMN_AMOUNT];
                    }
                }
                $ttableOperation['row'] = $rows;
                array_push($tableOperation, $ttableOperation);
            } elseif ($tableName == BillDetail::$TABLE_NAME) {
                $ttableOperation = array();
                $ttableOperation['table_name'] = BillDetail::$TABLE_NAME;
                $ttableOperation['operation'] = "update";
                $selectCurrentRow = "SELECT * FROM " . BillDetail::$TABLE_NAME . " WHERE " . BillDetail::$ID . " = '$rawId';";
                $selectCurrentRowResult = mysqli_query($conn, $selectCurrentRow);
                if (mysqli_num_rows($selectCurrentRowResult) > 0) {
                    $rows = array();
                    while ($row = mysqli_fetch_assoc($selectCurrentRowResult)) {
                        $rows[BillDetail::$ID] = $row[BillDetail::$ID];
                        $rows[BillDetail::$COLUMN_PAID] = $row[BillDetail::$COLUMN_PAID];
                        $rows[BillDetail::$COLUMN_DUE] = $row[BillDetail::$COLUMN_DUE];
                    }
                }
                $ttableOperation['row'] = $rows;
                array_push($tableOperation, $ttableOperation);
            }
        }
    }
    $returnOpArray['table_operation'] = $tableOperation;
    return $returnOpArray;
}

function addSalesReturn($conn, $timeStamp)
{
    $returnOpArray = array();
    $returnOpArray['operation'] = 'sales_return';
    $selectRawQuery = "SELECT * FROM " . AppSync::$TABLE_NAME . " WHERE " . AppSync::$COLUMN_TIMESTAMP . " ='$timeStamp' ORDER BY " . AppSync::$ID . " ASC";
    $selectRawResult = mysqli_query($conn, $selectRawQuery);
    $tableOperation = array();
    if (mysqli_num_rows($selectRawResult) > 0) {
        while ($row = mysqli_fetch_assoc($selectRawResult)) {
            $rawId = $row[AppSync::$COLUMN_ROW_ID];
            $tableName = $row[AppSync::$COLUMN_TABLE_NAME];
            if ($tableName == SalesReturn::$TABLE_NAME) {
                $ttableOperation = array();
                $ttableOperation['table_name'] = SalesReturn::$TABLE_NAME;
                $ttableOperation['operation'] = "insert";
                $selectCurrentRow = "SELECT * FROM " . SalesReturn::$TABLE_NAME . " WHERE " . SalesReturn::$ID . " = '$rawId';";
                $selectCurrentRowResult = mysqli_query($conn, $selectCurrentRow);
                if (mysqli_num_rows($selectCurrentRowResult) > 0) {
                    $rows = array();
                    while ($row = mysqli_fetch_assoc($selectCurrentRowResult)) {
                        $rows[SalesReturn::$ID] = $row[SalesReturn::$ID];
                        $rows[SalesReturn::$COLUMN_DATE] = $row[SalesReturn::$COLUMN_DATE];
                        $rows[SalesReturn::$COLUMN_BILL_ID] = $row[SalesReturn::$COLUMN_BILL_ID];
                        $rows[SalesReturn::$COLUMN_ITEM_ID] = $row[SalesReturn::$COLUMN_ITEM_ID];
                        $rows[SalesReturn::$COLUMN_UNIT_ID] = $row[SalesReturn::$COLUMN_UNIT_ID];
                        $rows[SalesReturn::$COLUMN_PRICE] = $row[SalesReturn::$COLUMN_PRICE];

                        $rows[SalesReturn::$TABLE_NAME."_item_vat_percentage"] = '0';
                        $rows[SalesReturn::$TABLE_NAME."_item_vat_amount"] = '0';
                        $rows[SalesReturn::$TABLE_NAME."_item_total_price"] = $row[COLUMN_TOTAL::$COLUMN_PRICE];

                        $rows[SalesReturn::$COLUMN_QTY] = $row[SalesReturn::$COLUMN_QTY];
                        $rows[SalesReturn::$COLUMN_TOTAL] = $row[SalesReturn::$COLUMN_TOTAL];

                        $rows[SalesReturn::$TABLE_NAME."_total_vat_amount"] = '0';
                        $rows[SalesReturn::$TABLE_NAME."_grand_total"] =  $row[SalesReturn::$COLUMN_TOTAL];
                    }
                }
                $ttableOperation['row'] = $rows;
                array_push($tableOperation, $ttableOperation);
            } elseif ($tableName == BillDetail::$TABLE_NAME) {
                $ttableOperation = array();
                $ttableOperation['table_name'] = BillDetail::$TABLE_NAME;
                $ttableOperation['operation'] = "update";
                $selectCurrentRow = "SELECT * FROM " . BillDetail::$TABLE_NAME . " WHERE " . BillDetail::$ID . " = '$rawId';";
                $selectCurrentRowResult = mysqli_query($conn, $selectCurrentRow);
                if (mysqli_num_rows($selectCurrentRowResult) > 0) {
                    $rows = array();
                    while ($row = mysqli_fetch_assoc($selectCurrentRowResult)) {
                        $rows[BillDetail::$ID] = $row[BillDetail::$ID];
                        $rows[BillDetail::$COLUMN_RETURNED_TOTAL] = $row[BillDetail::$COLUMN_RETURNED_TOTAL];
                        $rows[BillDetail::$COLUMN_CURRENT_TOTAL] = $row[BillDetail::$COLUMN_CURRENT_TOTAL];
                        $rows[BillDetail::$COLUMN_DUE] = $row[BillDetail::$COLUMN_DUE];
                    }
                }
                $ttableOperation['row'] = $rows;
                array_push($tableOperation, $ttableOperation);
            } elseif ($tableName == Cart::$TABLE_NAME) {
                $ttableOperation = array();
                $ttableOperation['table_name'] = Cart::$TABLE_NAME;
                $ttableOperation['operation'] = "update";
                $selectCurrentRow = "SELECT * FROM " . Cart::$TABLE_NAME . " WHERE " . Cart::$ID . " = '$rawId';";
                $selectCurrentRowResult = mysqli_query($conn, $selectCurrentRow);
                if (mysqli_num_rows($selectCurrentRowResult) > 0) {
                    $rows = array();
                    while ($row = mysqli_fetch_assoc($selectCurrentRowResult)) {
                        $rows[Cart::$ID] = $row[Cart::$ID];
                        $rows[Cart::$COLUMN_RETURN_QTY] = $row[Cart::$COLUMN_RETURN_QTY];
                    }
                }
                $ttableOperation['row'] = $rows;
                array_push($tableOperation, $ttableOperation);
            }
        }
    }
    $returnOpArray['table_operation'] = $tableOperation;
    return $returnOpArray;
}
