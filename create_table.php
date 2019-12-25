<?php
include 'common/common.php';

$itemInsert = false;

$AppSyncTableQuery = "CREATE TABLE IF NOT EXISTS " . AppSync::$TABLE_NAME . " (
    " . AppSync::$ID . " BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
    " . AppSync::$COLUMN_OP_CODE . " VARCHAR(100) ,
    " . AppSync::$COLUMN_TIMESTAMP . " BIGINT ,
    " . AppSync::$COLUMN_ROW_ID . " VARCHAR(100) ,
    " . AppSync::$COLUMN_TABLE_NAME . " VARCHAR(100) ,
    " . AppSync::$COLUMN_OPERATION . " VARCHAR(100)
)ENGINE = INNODB;";

if (mysqli_query($conn, $AppSyncTableQuery)) {
    echo "<br>Table AppSyncTableQuery created successfully<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

echo "<br><br><br>";

$RequestItemTableQuery = "CREATE TABLE IF NOT EXISTS " . RequestItem::$TABLE_NAME . " (
    " . RequestItem::$ID . " BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
    " . RequestItem::$COLUMN_NAME . " VARCHAR(100) ,
    " . RequestItem::$COLUMN_QTY . " INT
)ENGINE = INNODB;";

if (mysqli_query($conn, $RequestItemTableQuery)) {
    echo "<br>Table RequestItem TableQuery created successfully<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

echo "<br><br><br>";


$StaffTableQuery = "CREATE TABLE IF NOT EXISTS " . Staff::$TABLE_NAME . " (
    " . Staff::$ID . " VARCHAR(100) PRIMARY KEY ,
    " . Staff::$COLUMN_NAME . " VARCHAR(100) ,
    " . Staff::$COLUMN_USER_NAME . " VARCHAR(100) ,
    " . Staff::$COLUMN_SIGNATURE . " VARCHAR(1000) ,
    " . Staff::$COLUMN_PASSWORD . " VARCHAR(100) ,
    " . Staff::$COLUMN_EMAIL . " VARCHAR(100) ,
    " . Staff::$COLUMN_PRECISION . " INT UNSIGNED AUTO_INCREMENT UNIQUE,
    " . Staff::$COLUMN_FORCE . " INT ,
    " . Staff::$COLUMN_PAUSE . " INT ,
    " . Staff::$COLUMN_UPDATE . " INT
)ENGINE = INNODB;";

if (mysqli_query($conn, $StaffTableQuery)) {
    echo "<br>Table StaffTableQuery created successfully<br>";
    $insertDummyStaff = "INSERT INTO `tb_staff`(`tb_staff_id`, `tb_staff_name`, `tb_staff_username`, `tb_staff_password`, `tb_staff_email`,
    `tb_staff_precision`, `tb_staff_force`, `tb_staff_update`,`tb_staff_pause`)
   VALUES ('1','ALI','ali','ali','ali@gmail.com','1','1','0','0')";
    if (mysqli_query($conn, $insertDummyStaff)) {
        echo "<br>Successfully Inserted Dummy Data";
    } else {
        echo "<br>Failed To Insert Dummy Data";
    }
    $insertDummyStaff = "INSERT INTO `tb_staff`(`tb_staff_id`, `tb_staff_name`, `tb_staff_username`, `tb_staff_password`, `tb_staff_email`,
    `tb_staff_precision`, `tb_staff_force`, `tb_staff_update`,`tb_staff_pause`)
   VALUES ('2','AKBAR','akbar','akbar','akbar@gmail.com','2','1','0','0')";
    if (mysqli_query($conn, $insertDummyStaff)) {
        echo "<br>Successfully Inserted Dummy Data";
    } else {
        echo "<br>Failed To Insert Dummy Data";
    }
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

echo "<br><br><br>";

$ItemTableQuery = "CREATE TABLE IF NOT EXISTS " . Item::$TABLE_NAME . " (
    " . Item::$ID . " VARCHAR(100) PRIMARY KEY ,
    " . Item::$COLUMN_UNIT_ID . " VARCHAR(100) ,
    " . Item::$COLUMN_BARCODE . " VARCHAR(100) ,
    " . Item::$COLUMN_NAME . " VARCHAR(100) ,
    " . Item::$COLUMN_BRAND . " VARCHAR(100) ,
    " . Item::$COLUMN_CATEGORY . " VARCHAR(100) ,
    " . Item::$COLUMN_PRICE . " DECIMAL(18,9)
)ENGINE = INNODB;";

if (mysqli_query($conn, $ItemTableQuery)) {
    echo "<br>Table ItemTable created successfully<br>";
    $itemInsert = true;
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

echo "<br><br><br>";

$CustomerTableQuery = "CREATE TABLE IF NOT EXISTS " . Customer::$TABLE_NAME . " (
    " . Customer::$ID . " VARCHAR(100) PRIMARY KEY ,
    " . Customer::$STAFF_ID . " VARCHAR(100) ,
    " . Customer::$COLUMN_BARCODE . " VARCHAR(100) ,
    " . Customer::$COLUMN_CR_NO . " VARCHAR(100) ,
    " . Customer::$COLUMN_SHOP_NAME . " VARCHAR(100) ,
    " . Customer::$COLUMN_DAY . " VARCHAR(100) ,
    " . Customer::$COLUMN_NAME . " VARCHAR(100) ,
    " . Customer::$COLUMN_PHONE . " VARCHAR(100) ,
    " . Customer::$COLUMN_EMAIL . " VARCHAR(100) ,
    " . Customer::$COLUMN_TELEPHONE . " VARCHAR(100) ,
    " . Customer::$COLUMN_VAT_NO . " VARCHAR(100) ,

    " . Customer::$COLUMN_ADDRESS_AREA . " VARCHAR(100) ,
    " . Customer::$COLUMN_ADDRESS_ROAD . " VARCHAR(100) ,
    " . Customer::$COLUMN_ADDRESS_BLOCK . " VARCHAR(100) ,
    " . Customer::$COLUMN_ADDRESS_SHOP_NUM . " VARCHAR(100)
)ENGINE = INNODB;";

if (mysqli_query($conn, $CustomerTableQuery)) {
    echo "<br>Table CustomerTable created successfully<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

echo "<br><br><br>";

$BillDetailTableQuery = "CREATE TABLE IF NOT EXISTS " . BillDetail::$TABLE_NAME . " (
    " . BillDetail::$ID . " VARCHAR(100) PRIMARY KEY ,
    " . BillDetail::$COLUMN_DATE . " VARCHAR(100) ,
    " . BillDetail::$COLUMN_CUST_ID . " VARCHAR(100) ,
    " . BillDetail::$COLUMN_PRICE . " DECIMAL(18,9) ,
    " . BillDetail::$COLUMN_QTY . " INT ,
    " . BillDetail::$COLUMN_RETURNED_TOTAL . " DECIMAL(18,9) ,
    " . BillDetail::$COLUMN_CURRENT_TOTAL . " DECIMAL(18,9) ,
    " . BillDetail::$COLUMN_PAID . " DECIMAL(18,9) ,
    " . BillDetail::$COLUMN_DISCOUNT . " DECIMAL(18,9) ,
    " . BillDetail::$COLUMN_DUE . " DECIMAL(18,9)

)ENGINE = INNODB;";

if (mysqli_query($conn, $BillDetailTableQuery)) {
    echo "<br>Table BillDetailTable created successfully<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

echo "<br><br><br>";

$CartTableQuery = "CREATE TABLE IF NOT EXISTS " . Cart::$TABLE_NAME . " (
    " . Cart::$ID . " VARCHAR(100) PRIMARY KEY ,
    " . Cart::$COLUMN_BILL_ID . " VARCHAR(100) ,
    " . Cart::$COLUMN_ITEM_ID . " VARCHAR(100) ,
    " . Cart::$COLUMN_UNIT_ID . " VARCHAR(100) ,
    " . Cart::$COLUMN_NAME . " VARCHAR(100) ,
    " . Cart::$COLUMN_BRAND . " VARCHAR(100) ,
    " . Cart::$COLUMN_CATEGORY . " VARCHAR(100) ,
    " . Cart::$COLUMN_PRICE . " DECIMAL(18,9) ,
    " . Cart::$COLUMN_QTY . " INT ,
    " . Cart::$COLUMN_TOTAL . " DECIMAL(18,9) ,
    " . Cart::$COLUMN_RETURN_QTY . " DECIMAL(18,9)
)ENGINE = INNODB;";

if (mysqli_query($conn, $CartTableQuery)) {
    echo "<br>Table CartTable created successfully<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

echo "<br><br><br>";

$SalesReturnTableQuery = "CREATE TABLE IF NOT EXISTS " . SalesReturn::$TABLE_NAME . " (
    " . SalesReturn::$ID . " VARCHAR(100) PRIMARY KEY ,
    " . SalesReturn::$COLUMN_DATE . " VARCHAR(100) ,
    " . SalesReturn::$COLUMN_BILL_ID . " VARCHAR(100) ,
    " . SalesReturn::$COLUMN_ITEM_ID . " VARCHAR(100) ,
    " . SalesReturn::$COLUMN_UNIT_ID . " VARCHAR(100) ,
    " . SalesReturn::$COLUMN_PRICE . " DECIMAL(18,9) ,
    " . SalesReturn::$COLUMN_QTY . " INT ,
    " . SalesReturn::$COLUMN_TOTAL . " DECIMAL(18,9)
)ENGINE = INNODB;";

if (mysqli_query($conn, $SalesReturnTableQuery)) {
    echo "<br>Table SalesReturnTable created successfully<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

echo "<br><br><br>";

$PaymentTableQuery = "CREATE TABLE IF NOT EXISTS " . Payment::$TABLE_NAME . " (
    " . Payment::$ID . " VARCHAR(100) PRIMARY KEY ,
    " . Payment::$COLUMN_BILL_ID . " VARCHAR(100) ,
    " . Payment::$COLUMN_DATE . " VARCHAR(100) ,
    " . Payment::$COLUMN_TYPE . " VARCHAR(100) ,
    " . Payment::$COLUMN_AMOUNT . " DECIMAL(18,9)
)ENGINE = INNODB;";

if (mysqli_query($conn, $PaymentTableQuery)) {
    echo "<br>Table PaymentTable created successfully<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$ItemUnitTableQuery = "CREATE TABLE IF NOT EXISTS " . ItemUnit::$TABLE_NAME . " (
    " . ItemUnit::$ID . " VARCHAR(100) PRIMARY KEY ,
    " . ItemUnit::$COLUMN_UNIT_NAME . " VARCHAR(100) ,
    " . ItemUnit::$COLUMN_QTY . " INT
)ENGINE = INNODB;";

if (mysqli_query($conn, $ItemUnitTableQuery)) {
    echo "<br>Table ItemUnit created successfully<br>";
    $insertDummyStaff = "INSERT INTO `tb_item_unit`(`tb_item_unit_id`, `tb_item_unit_unit_name`, `tb_item_unit_qty`)
   VALUES ('1A','BASE (1)','1')";
    if (mysqli_query($conn, $insertDummyStaff)) {
        echo "<br>Successfully Inserted Dummy Data";
    } else {
        echo "<br>Failed To Insert Dummy Data";
    }

    $insertDummyStaff = "INSERT INTO `tb_item_unit`(`tb_item_unit_id`, `tb_item_unit_unit_name`, `tb_item_unit_qty`)
    VALUES ('2A','DOZEN (12)','12')";
    if (mysqli_query($conn, $insertDummyStaff)) {
        echo "<br>Successfully Inserted Dummy Data";
    } else {
        echo "<br>Failed To Insert Dummy Data";
    }

    $insertDummyStaff = "INSERT INTO `tb_item_unit`(`tb_item_unit_id`, `tb_item_unit_unit_name`, `tb_item_unit_qty`)
     VALUES ('3A','PACKET (3)','3')";
    if (mysqli_query($conn, $insertDummyStaff)) {
        echo "<br>Successfully Inserted Dummy Data";
    } else {
        echo "<br>Failed To Insert Dummy Data";
    }

    $insertDummyStaff = "INSERT INTO `tb_item_unit`(`tb_item_unit_id`, `tb_item_unit_unit_name`, `tb_item_unit_qty`)
     VALUES ('4A','PACKET (5)','5')";
    if (mysqli_query($conn, $insertDummyStaff)) {
        echo "<br>Successfully Inserted Dummy Data";
    } else {
        echo "<br>Failed To Insert Dummy Data";
    }

} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$itemInsert = false;
if ($itemInsert) {

    $insertItemData = "INSERT INTO `tb_item`( `tb_item_id`,`tb_item_unit_id`, `tb_item_co_barcode`, `tb_item_name`, `tb_item_brand`, `tb_item_category`, `tb_item_price`)
    VALUES ('1','1A','1','A','AA','AAA','100');";
    $insertItemData .= "INSERT INTO `tb_item`( `tb_item_id`,`tb_item_unit_id`, `tb_item_co_barcode`, `tb_item_name`, `tb_item_brand`, `tb_item_category`, `tb_item_price`)
    VALUES ('2','1A','2','B','BB','BBB','200.50');";
    $insertItemData .= "INSERT INTO `tb_item`( `tb_item_id`,`tb_item_unit_id`, `tb_item_co_barcode`, `tb_item_name`, `tb_item_brand`, `tb_item_category`, `tb_item_price`)
    VALUES ('3','1A','3','C','CC','CCC','300');";
    $insertItemData .= "INSERT INTO `tb_item`( `tb_item_id`,`tb_item_unit_id`, `tb_item_co_barcode`, `tb_item_name`, `tb_item_brand`, `tb_item_category`, `tb_item_price`)
    VALUES ('4','1A','4','D','DD','DDD','400.222');";
    $insertItemData .= "INSERT INTO `tb_item`( `tb_item_id`,`tb_item_unit_id`, `tb_item_co_barcode`, `tb_item_name`, `tb_item_brand`, `tb_item_category`, `tb_item_price`)
    VALUES ('5','1A','5','E','EE','EEE','500.555');";
    if (mysqli_multi_query($conn, $insertItemData)) {
        echo "<br>Item records created successfully";
    } else {
        echo "Error: " . $insertItemData . "<br>" . mysqli_error($conn);
    }
}
