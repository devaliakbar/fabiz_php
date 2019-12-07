<?php
include 'common/common.php';

$userName = $_POST['my_username'];
$password =null;

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
                if ($_POST['confirm_pull']) {
                    if (updateFlag($conn, $userName)) {
                        $response["success"] = true;
                    } else {
                        $response["status"] = "FAIL";
                    }
                } else {
                    $response["success"] = true;
                }
            }
        }

    } else {
        $response["status"] = "USER";
    }
}
echo json_encode($response);
