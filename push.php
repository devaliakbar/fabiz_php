<?php
include 'common/common.php';
include 'operation/serverPushHelper.php';

mysqli_autocommit($conn, false);
$commitTransaction = true;

$updateFlagSetupQuery = "UPDATE " . Staff::$TABLE_NAME . "
 SET " . Staff::$COLUMN_FORCE . " = '1', " . Staff::$COLUMN_UPDATE . " = '0'";

if (mysqli_query($conn, $updateFlagSetupQuery)) {
    $jsonArray = file_get_contents($_FILES['fabizjson']['tmp_name']);

    for ($i = 0; i < count($jsonArray); $i++) {
        $SUCCESS = false;
        $currentTb = $jsonArray[$i];
        switch ($currentTb['table_name']) {
            case "tb_info":
                $SUCCESS = addInfo($conn, $currentTb['value']);
                break;

            case "global_precision":
                $SUCCESS = addPrecision($conn, $currentTb['value']);
                break;

            case "tb_staff":
                $SUCCESS = addStaff($conn, $currentTb['rows']);
                break;

            case "tb_item":
                $SUCCESS = addItem($conn, $currentTb['rows']);
                break;

            case "tb_item_unit":
                $SUCCESS = addUnit($conn, $currentTb['rows']);
                break;

            case "tb_customer":
                $SUCCESS = addCustomer($conn, $currentTb['rows']);
                break;

            case "tb_bill_detail":
                $SUCCESS = addBillDetail($conn, $currentTb['rows']);
                break;

            case "tb_cart":
                $SUCCESS = addCart($conn, $currentTb['rows']);
                break;

            case "tb_payment":
                $SUCCESS = addPayment($conn, $currentTb['rows']);
                break;

            case "tb_sales_return":
                $SUCCESS = addsSalesreturn($conn, $currentTb['rows']);
                break;
        }

        if (!$SUCCESS) {
            $commitTransaction = false;
            break;
        }

    }

} else {
    $commitTransaction = false;
}

if ($commitTransaction) {
    mysqli_commit($conn);
    $response["success"] = true;
} else {
    mysqli_rollback($conn);
}

echo json_encode($response);

function deleteAllTableValues($conn)
{
    $deleteTable = "DELETE FROM tb_app_sync";
    if (mysqli_query($conn, $deleteTable)) {
        $deleteTable = "DELETE FROM tb_bill_detail";
        if (mysqli_query($conn, $deleteTable)) {
            $deleteTable = "DELETE FROM tb_cart";
            if (mysqli_query($conn, $deleteTable)) {
                $deleteTable = "DELETE FROM tb_customer";
                if (mysqli_query($conn, $deleteTable)) {
                    $deleteTable = "DELETE FROM tb_global_precision";
                    if (mysqli_query($conn, $deleteTable)) {
                        $deleteTable = "DELETE FROM tb_info";
                        if (mysqli_query($conn, $deleteTable)) {
                            $deleteTable = "DELETE FROM tb_item";
                            if (mysqli_query($conn, $deleteTable)) {
                                $deleteTable = "DELETE FROM tb_item_unit";
                                if (mysqli_query($conn, $deleteTable)) {
                                    $deleteTable = "DELETE FROM tb_payment";
                                    if (mysqli_query($conn, $deleteTable)) {
                                        $deleteTable = "DELETE FROM tb_request_item";
                                        if (mysqli_query($conn, $deleteTable)) {
                                            $deleteTable = "DELETE FROM tb_sales_return";
                                            if (mysqli_query($conn, $deleteTable)) {
                                                $deleteTable = "DELETE FROM tb_staff";
                                                if (mysqli_query($conn, $deleteTable)) {
                                                    return false;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return false;
}
