<?php
include 'common/common.php';

mysqli_autocommit($conn, false);
$commitTransaction = true;

$updateFlagSetupQuery = "UPDATE " . Staff::$TABLE_NAME . "
 SET " . Staff::$COLUMN_PAUSE . " = '1' ," . Staff::$COLUMN_FORCE . " = '1', " . Staff::$COLUMN_UPDATE . " = '0'";

if (mysqli_query($conn, $updateFlagSetupQuery)) {

    $updateFlagResumeSetupQuery = "UPDATE " . Staff::$TABLE_NAME . "
    SET " . Staff::$COLUMN_PAUSE . " = '0' ";
    if (!mysqli_query($conn, $updateFlagResumeSetupQuery)) {
        $commitTransaction = false;
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
