<?php
include 'common/common.php';

$userName = $_POST['my_username'];
$password = null;
$version = $_POST['app_version'];
if ( $version != $app_version ) {
    $response['status'] = 'VERSION';
} else {
    $userSignature = $_POST['mysign'];
    $resultOfAuth = checkUserNamePassword( $conn, $userName, $password, $userSignature );
    if ( $resultOfAuth != null ) {
        if ( $forcePush_data ) {
            $response['status'] = 'PUSH';
        } else {
            if ( $update_data ) {
                $response['status'] = 'UPDATE';
            } else {
                mysqli_autocommit( $conn, false );
                $commitTransaction = true;
                $tableName = RequestItem::$TABLE_NAME;
                $columnName = RequestItem::$COLUMN_NAME;
                $columnQty = RequestItem::$COLUMN_QTY;

                for ( $i = 0; $i < $_POST['row_size']; $i++ ) {
                    $name = $_POST[$columnName . $i];
                    $qty = $_POST[$columnQty . $i];
                    $insertRequestItemQuery = "INSERT INTO $tableName($columnName, $columnQty) VALUES ('$name','$qty')";
                    if ( !mysqli_query( $conn, $insertRequestItemQuery ) ) {
                        $commitTransaction = false;
                    }
                }
                if ( $commitTransaction ) {
                    if ( mysqli_query( $conn, 'DELETE FROM ' . AppSync::$TABLE_NAME .
                    ' WHERE ' . AppSync::$COLUMN_TABLE_NAME . " = '" . RequestItem::$TABLE_NAME . "'" ) ) {
                        $timestamps = time();
                        $insertSyncLogQuery = 'INSERT INTO ' . AppSync::$TABLE_NAME . "
                        (" . AppSync::$COLUMN_OP_CODE . " ,
                        " . AppSync::$COLUMN_TIMESTAMP . " ,
                        " . AppSync::$COLUMN_ROW_ID . " ,
                          " . AppSync::$COLUMN_TABLE_NAME . " ,
                          " . AppSync::$COLUMN_OPERATION . " )
                          VALUES
                        ('REQUEST_ITEM','1','1','1','1')";
                        if ( mysqli_query( $conn, $insertSyncLogQuery ) ) {
                            mysqli_commit( $conn );
                            $response['success'] = true;
                        } else {
                            mysqli_rollback( $conn );
                        }
                    } else {
                        mysqli_rollback( $conn );
                    }

                } else {
                    mysqli_rollback( $conn );
                }
            }
        }

    } else {
        $response['status'] = 'USER';
    }
}
echo json_encode( $response );
?>