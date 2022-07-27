<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/dbhelper.php');

class comment
{
    private $fm;
    private $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new format();
    }

    public function insert_binhluan()
    {
        $product_id = $_POST['product_id_binhluan'];
        $customer_id = $_POST['customer_id'];
        $binhluan = $_POST['binhluan'];
        if ($customer_id == '' || $binhluan == '') {
            $alert = "<span class='error'>Không Được Để Trống</span>";
            return $alert;
        } else {
            $query = "INSERT INTO tbl_binhluan(customer_Id,binhluan,productId) 
                VALUES ('$customer_id', '$binhluan', '$product_id')";

            $result = $this->db->insert($query);
            if ($result) {
                $alert = "<span class='success'>Bình Luận sẽ được admin kiểm duyệt</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Bình Luận không thành công</span>";
                return $alert;
            }
        }
    }

    public function show_comment()
    {
        $query = "SELECT bl.*, pro.productId, pro.productName, pro.image, cus.name
        FROM tbl_binhluan bl 
        INNER JOIN tbl_product pro ON bl.productId = pro.productId
        INNER JOIN tbl_customer cus ON bl.customer_id = cus.id
        ORDER BY binhluan_id DESC";
        return $this->db->select($query);
    }

    public function get_comments_by_productId($product_id)
    {
        $query = "SELECT bl.*, cus.name
        FROM tbl_binhluan bl 
        INNER JOIN tbl_customer cus ON bl.customer_id = cus.id
        WHERE productId = $product_id
        ORDER BY binhluan_id DESC";
        return $this->db->select($query);
    }

    public function del_comment($id)
    {
        $query = "DELETE FROM tbl_binhluan where binhluan_id = '$id'";
        $result = $this->db->delete($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
