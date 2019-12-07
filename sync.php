<?php
include 'common/common.php';
include 'operation/dbAppSyncHelper.php';

$userName = $_POST['my_username'];
$password = null;

$version = $_POST['app_version'];
if ($version != $app_version) {
    $response["status"] = "VERSION";
} else {
    $userSignature = $_POST['mysign'];
    $resultOfAuth = checkUserNamePassword($conn, $userName, $password, $userSignature);
    if ($resultOfAuth != null) {

        if ($forcePush_data) {
            $response["status"] = "PUSH";
        } else {
            if ($update_data) {
                $response["status"] = "UPDATE";
            } else {
                //******started */
                if (performSyncOnApp($conn)) {
                    $response["success"] = true;
                }
                //******END ****/
            }
        }
    } else {
        $response["status"] = "USER";
    }
}

echo json_encode($response);
