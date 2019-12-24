<?php

//-1 TABLE APP SYNC
class AppSync
{
    public static $TABLE_NAME = "tb_app_sync";
    public static $ID = "tb_app_sync_id";
    public static $COLUMN_OP_CODE = "tb_app_sync_op_code";
    public static $COLUMN_TIMESTAMP = "tb_app_sync_timestamp";
    public static $COLUMN_ROW_ID = "tb_app_sync_row_id";
    public static $COLUMN_TABLE_NAME = "tb_app_sync_table_name";
    public static $COLUMN_OPERATION = "tb_app_sync_operation";
}

//0 TABLE STAFF
class Staff
{
    public static $TABLE_NAME = "tb_staff";

    public static $ID = "tb_staff_id";
    public static $COLUMN_NAME = "tb_staff_name";
    public static $COLUMN_USER_NAME = "tb_staff_username";
    public static $COLUMN_PASSWORD = "tb_staff_password";
    public static $COLUMN_EMAIL = "tb_staff_email";
    public static $COLUMN_PRECISION = "tb_staff_precision";
    public static $COLUMN_FORCE = "tb_staff_force";
    public static $COLUMN_UPDATE = "tb_staff_update";
    public static $COLUMN_PAUSE = "tb_staff_pause";
    public static $COLUMN_SIGNATURE = "tb_staff_signature";
}

class ItemUnit
{

    public static $TABLE_NAME = "tb_item_unit";

    public static $ID = "tb_item_unit_id";
    public static $COLUMN_UNIT_NAME = "tb_item_unit_unit_name";
    public static $COLUMN_QTY = "tb_item_unit_qty";
}

//1 TABLE ITEM
class Item
{
    public static $TABLE_NAME = "tb_item";

    public static $ID = "tb_item_id";
    public static $COLUMN_UNIT_ID = "tb_item_unit_id";
    public static $COLUMN_BARCODE = "tb_item_co_barcode";
    public static $COLUMN_NAME = "tb_item_name";
    public static $COLUMN_BRAND = "tb_item_brand";
    public static $COLUMN_CATEGORY = "tb_item_category";
    public static $COLUMN_PRICE = "tb_item_price";

}

//2 TABLE CUSTOMER
class Customer
{
    public static $TABLE_NAME = "tb_customer";

    public static $ID = "tb_customer_id";
    public static $STAFF_ID = "tb_customer_staff_id";
    public static $COLUMN_BARCODE = "tb_customer_co_barcode";
    public static $COLUMN_CR_NO = "tb_customer_cr_no";
    public static $COLUMN_SHOP_NAME = "tb_customer_shop_name";
    public static $COLUMN_NAME = "tb_customer_name";
    public static $COLUMN_DAY = "tb_customer_day";
    public static $COLUMN_PHONE = "tb_customer_phone";
    public static $COLUMN_EMAIL = "tb_customer_email";

    public static $COLUMN_ADDRESS_AREA = "tb_customer_address_area";
    public static $COLUMN_ADDRESS_ROAD = "tb_customer_address_road";
    public static $COLUMN_ADDRESS_BLOCK = "tb_customer_address_block";
    public static $COLUMN_ADDRESS_SHOP_NUM = "tb_customer_address_shop_num";

    public static $COLUMN_TELEPHONE = "tb_customer_telephone";
    public static $COLUMN_VAT_NO = "tb_customer_vat_no";

}

//3 TABLE BILL DETAIL
class BillDetail
{
    public static $TABLE_NAME = "tb_bill_detail";

    public static $ID = "tb_bill_detail_id";
    public static $COLUMN_DATE = "tb_bill_detail_dateofbill";
    public static $COLUMN_CUST_ID = "tb_bill_detail_custid";
    public static $COLUMN_PRICE = "tb_bill_detail_price";
    public static $COLUMN_QTY = "tb_bill_detail_qty";

    public static $COLUMN_RETURNED_TOTAL = "tb_bill_detail_returned_total";
    public static $COLUMN_CURRENT_TOTAL = "tb_bill_detail_current_total";
    public static $COLUMN_PAID = "tb_bill_detail_paid";
    public static $COLUMN_DUE = "tb_bill_detail_due";

    public static $COLUMN_DISCOUNT = "tb_bill_detail_discount";

}

//4 TABLE CART
class Cart
{
    public static $TABLE_NAME = "tb_cart";

    public static $ID = "tb_cart_id";
    public static $COLUMN_BILL_ID = "tb_cart_billid";
    public static $COLUMN_ITEM_ID = "tb_cart_itemid";
    public static $COLUMN_UNIT_ID = "tb_cart_unit_id";
    public static $COLUMN_NAME = "tb_cart_name";
    public static $COLUMN_BRAND = "tb_cart_brand";
    public static $COLUMN_CATEGORY = "tb_cart_category";
    public static $COLUMN_PRICE = "tb_cart_price";
    public static $COLUMN_QTY = "tb_cart_qty";
    public static $COLUMN_TOTAL = "tb_cart_total";
    public static $COLUMN_RETURN_QTY = "tb_cart_returnqty";

}

//5 TABLE SALES RETURN
class SalesReturn
{

    public static $TABLE_NAME = "tb_sales_return";

    public static $ID = "tb_sales_return_id";
    public static $COLUMN_DATE = "tb_sales_return_dateofreturn";
    public static $COLUMN_BILL_ID = "tb_sales_return_billid";
    public static $COLUMN_ITEM_ID = "tb_sales_return_itemid";
    public static $COLUMN_UNIT_ID = "tb_sales_return_unit_id";
    public static $COLUMN_PRICE = "tb_sales_return_price";
    public static $COLUMN_QTY = "tb_sales_return_qty";
    public static $COLUMN_TOTAL = "tb_sales_return_total";
}

//6 TABLE PAYMENT
class Payment
{
    public static $TABLE_NAME = "tb_payment";

    public static $ID = "tb_payment_id";
    public static $COLUMN_BILL_ID = "tb_payment_billid";
    public static $COLUMN_DATE = "tb_payment_dateofreturn";
    public static $COLUMN_AMOUNT = "tb_payment_amount";
    public static $COLUMN_TYPE = "tb_payment_type";
}
