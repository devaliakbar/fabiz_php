<?php
$app_version = 1;
$forcePush_data = false;
$update_data = false;
$pause_sync = false;

function checkUserNamePassword($conn, $username, $password, $userSignature)
{

    if($userSignature == null){
        $queryForUserCheck = "SELECT * FROM " . Staff::$TABLE_NAME . " WHERE BINARY " . Staff::$COLUMN_USER_NAME . " = '$username' AND " . Staff::$COLUMN_PASSWORD . " = '$password'";
    }else{
        $queryForUserCheck = "SELECT * FROM " . Staff::$TABLE_NAME . " WHERE BINARY " . Staff::$COLUMN_SIGNATURE . " = '$userSignature'";
    }
    $userCheckresult = mysqli_query($conn, $queryForUserCheck);
    if (mysqli_num_rows($userCheckresult) > 0) {
        $returnArray = array();
        while ($row = mysqli_fetch_assoc($userCheckresult)) {
            $returnArray['precision'] = $row[Staff::$COLUMN_PRECISION];
            $returnArray['idOfStaff'] = $row[Staff::$ID];
            $returnArray['nameOfStaff'] = $row[Staff::$COLUMN_NAME];
        }
        if($userSignature == null){
            $returnSign = md5(time());
            $queryForUpdateSignature = "UPDATE " . Staff::$TABLE_NAME . " SET " . Staff::$COLUMN_SIGNATURE . "='$returnSign' WHERE BINARY " . Staff::$COLUMN_USER_NAME . " = '$username' AND " . Staff::$COLUMN_PASSWORD . " = '$password'";
            if (!mysqli_query($conn, $queryForUpdateSignature)) {
                return null;
            }
            $returnArray['mysign'] = $returnSign;
        }


        return $returnArray;
    } else {
        return null;
    }
}

function updateFlag($conn, $userName)
{
    $updateFlagQuery = "UPDATE " . Staff::$TABLE_NAME . " 
    SET " . Staff::$COLUMN_FORCE . " = '0'," . Staff::$COLUMN_UPDATE . " = '0' 
    WHERE " . Staff::$COLUMN_USER_NAME . " = '$userName'";
    return mysqli_query($conn, $updateFlagQuery);
}
