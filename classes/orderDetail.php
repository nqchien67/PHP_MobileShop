<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/dbhelper.php');
include_once('product.php');
class orderDetail
{
    private $db;
    private $fm;
    private $pd;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new format();
        $this->pd = new product();
    }

    public function insert_order_detail($data, $orderId)
    {
        $productId = $data["productId"];
        $quantity = $data["quantity"];
        $price = $data["price"];
        $totalPrice = $data["totalPrice"];
        $this->pd->checked_quantity($productId,$quantity);

        $query = "INSERT INTO tbl_orderdetail (productId, orderId, quantity, price, totalPrice) VALUES" .
            "('$productId','$orderId','$quantity','$price','$totalPrice')";
        $this->db->insert($query);
    }

    public function get_detail_by_orderId($orderId)
    {
        $query = "SELECT tbl_orderdetail.*, tbl_product.productName, tbl_product.image
            from tbl_orderdetail INNER JOIN tbl_product ON tbl_orderdetail.productId = tbl_product.productId where orderId = '$orderId'";
        return $this->db->select($query);
    }

    public function del_order_detail($orderId)
    {
        $orderId = mysqli_real_escape_string($this->db->link, $orderId);
        $query = "DELETE FROM tbl_orderdetail WHERE orderId ='$orderId'";
        $result = $this->db->delete($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    // public function update_quantity_orderDetail($quantity,$cartId){
    //     $quantity = mysqli_real_escape_string($this->db->link,$quantity);
    //     $cartId = mysqli_real_escape_string($this->db->link,$cartId);
    //     //neu nguoi dung khong chon anh
    //     $query = "UPDATE tbl_orderdetail SET
    //     quantity = '$quantity'

    //     WHERE orderId = '$orderId'";
    //     $result = $this->db->update($query);
    //     if($result){
    //         $msg = "<span class ='success'>Cập Nhật Giỏ Hàng Thành Công</span>";
    //         return $msg;
    //     }
    //     else{
    //         $msg = "<span class='error'>Cập Nhật Giỏ Hàng Thất Bại</span>";
    //         return $msg;
    //     }
    // }
}
