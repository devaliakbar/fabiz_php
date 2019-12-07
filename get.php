<?php
include 'common/common.php';
include 'api/getHelper.php';

$transactions = array();
$selectTransactionsQuery = "SELECT DISTINCT " . AppSync::$COLUMN_TIMESTAMP . "," . AppSync::$COLUMN_OP_CODE . " FROM " . AppSync::$TABLE_NAME . " ORDER BY " . AppSync::$ID . " ASC";

$selectTransactionsQueryResult = mysqli_query($conn, $selectTransactionsQuery);
if (mysqli_num_rows($selectTransactionsQueryResult) > 0) {
    $response["success"] = true;
    while ($row = mysqli_fetch_assoc($selectTransactionsQueryResult)) {
        $timeStamp = $row[AppSync::$COLUMN_TIMESTAMP];
        $opCode = $row[AppSync::$COLUMN_OP_CODE];
        switch ($opCode) {
            case "ADD_CUST":
                array_push($transactions, addCustomer($conn, $timeStamp));
                break;
            case "SALE":
                array_push($transactions, addSales($conn, $timeStamp));
                break;
            case "PAY":
                array_push($transactions, addPayment($conn, $timeStamp));
                break;
            case "SALE_RETURN":
                array_push($transactions, addSalesReturn($conn, $timeStamp));
                break;
        }
    }
} else {
    $response["status"] = "EMPTY";
}

$response['transactions'] = $transactions;
echo json_encode($response);
