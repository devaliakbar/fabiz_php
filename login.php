<?php
include 'common/common.php';

$userName = $_POST['my_username'];
$password = $_POST['my_password'];

$version = $_POST['app_version'];
if ($version != $app_version) {
    $response["status"] = "VERSION";
} else {
    $resultOfAuth = checkUserNamePassword($conn, $userName, $password, null);
    if ($resultOfAuth != null) {
        $response["success"] = true;
        $response["precision"] = $resultOfAuth['precision'];
        $response["idOfStaff"] = $resultOfAuth['idOfStaff'];
        $response["nameOfStaff"] = $resultOfAuth['nameOfStaff'];
        $response["mysign"] = $resultOfAuth['mysign'];
    } else {
        $response["status"] = "USER";
    }
}

echo json_encode($response);
