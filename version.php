<?php
include('common/common.php');
$version = $_POST['app_version'];

// $sam = $_POST['sample'];
// echo $sam;

if($version == $app_version){
    $response["success"] = true;
}else{
    $response["status"]  = "VERSION";
}

echo json_encode($response);
?>