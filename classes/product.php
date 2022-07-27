<?php

$filepath = realpath(dirname(__FILE__));
//dường dẫn thực
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/dbhelper.php');
?>
<?php
class product
{
    public $fm;
    private $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new format();
    }
    public function search_product($tukhoa)
    {
        $tukhoa = $this->fm->validation($tukhoa);
        $query = "SELECT * FROM tbl_product WHERE productName LIKE '%$tukhoa%'"; //tim tu giong tu khoa trong productName
        $result = $this->db->select($query);
        return $result;
    }
    public function insert_product($data)
    {
        $productName = mysqli_real_escape_string($this->db->link, $data['name']);
        $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
        $category = mysqli_real_escape_string($this->db->link, $data['category']);
        $product_desc = mysqli_real_escape_string($this->db->link, $data['description']);
        $price = mysqli_real_escape_string($this->db->link, $data['price']);
        $quantity = mysqli_real_escape_string($this->db->link, $data['quantity']);
        $unique_image = mysqli_real_escape_string($this->db->link, $data['image']);

        $query = "INSERT INTO tbl_product(productName, brandId, catId, product_desc, price, image, quantity) VALUES('$productName','$brand','$category','$product_desc','$price','$unique_image','$quantity')";
        $result = $this->db->insert($query);
        if ($result) {
            $alert = "<span class= 'success'>Insert Product Successfully</span>";
            return $alert;
        } else {
            $alert = "<span class= 'error'>Insert Product Not Success</span>";
            return $alert;
        }
    }
    public function insert_slider($data, $files)
    {
        $sliderName = mysqli_real_escape_string($this->db->link, $data['sliderName']);
        $type = mysqli_real_escape_string($this->db->link, $data['type']);
        //kiem tra hinh anh va lay hinh anh cho vao folder uploads
        //chỉ cho phép file có đuôi chấm....
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name']; //tên ảnh
        $file_size = $_FILES['image']['size']; //kích thước hình ảnh
        $file_temp = $_FILES['image']['tmp_name']; //file tạm để lưu hình ảnh

        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        //chuyển tất cả chữ hoa thành chữ thường

        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $uploaded_image = "uploads/" . $unique_image;
        //nếu trống
        if ($sliderName == "" || $type == "") {
            $alert = "<span class='error'>Các trường không được để trống</span>";
            return $alert;
        } else {
            if (!empty($file_name)) {
                //neu nguoi dung chon anh
                if ($file_size > 2048000) { //kiểm tra kích cơ file hịnh anh
                    $alert = "<span class='success'>Kích thước ảnh quá lớn</span>";
                    return $alert;
                } elseif (in_array($file_ext, $permited) === false) {
                    $alert = "<span class='error'>Bạn chỉ có thể tải lên:-" . implode(',', $permited) . "</span>";
                    return $alert;
                }
                move_uploaded_file($file_temp, $uploaded_image);

                if (isset($data["pro"])) {
                    $productId = mysqli_real_escape_string($this->db->link, $data['pro']);
                    $query = "INSERT INTO tbl_slider(sliderName,type,slider_image, productId) VALUES('$sliderName','$type','$unique_image','$productId')";
                } else {
                    $query = "INSERT INTO tbl_slider(sliderName,type,slider_image) VALUES('$sliderName','$type','$unique_image')";
                }
                $result = $this->db->insert($query);

                if ($result) {
                    $alert = "<span class= 'success'>Thêm slider thành công</span>";
                    return $alert;
                } else {
                    $alert = "<span class= 'error'>Thêm slider thất bại</span>";
                    return $alert;
                }
            }
        }
    }
    public function get_image_name($id)
    {
        $query = "SELECT tbl_product.image from tbl_product where tbl_product.productId = '$id'";
        $result = $this->db->select($query);
        return $result->fetch_assoc()["image"];
    }
    public function show_slider()
    {
        $query = "SELECT * FROM tbl_slider where type ='1' order by  sliderId desc";
        $result = $this->db->select($query);
        return $result;
    }

    public function show_slider_list()
    {
        $query = "SELECT sl.*, pr.productName FROM tbl_slider sl
        LEFT JOIN tbl_product pr ON sl.productId = pr.productId
        order by sliderId desc";
        $result = $this->db->select($query);
        return $result;
    }
    public function show_product()
    {

        $query = "SELECT tbl_product.*,tbl_category.catName, tbl_brand.brandName
            -- chọn cột product lấy tất cả
            -- chọn cột category lấy catName
            -- chọn cột brand lấy brandname
            -- từ table product 
            -- inner join  
            from  tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
            INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId order by tbl_product.productId desc";
        $result = $this->db->select($query);
        return $result;
    }

    public function getproductbyId($id)
    {
        $query = "SELECT * FROM tbl_product where productId = '$id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function getproductbyId_admin($id)
    {
        $query = "SELECT tbl_product.*,tbl_category.catName, tbl_brand.brandName
        from tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
        INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId order by tbl_product.productId desc";
        $query = "SELECT * FROM tbl_product where productId = '$id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function update_product($data, $id)
    {
        $productName = mysqli_real_escape_string($this->db->link, $data['name']);
        $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
        $category = mysqli_real_escape_string($this->db->link, $data['category']);
        $product_desc = mysqli_real_escape_string($this->db->link, $data['description']);
        $price = mysqli_real_escape_string($this->db->link, $data['price']);
        $unique_image = mysqli_real_escape_string($this->db->link, $data['image']);
        $quantity = mysqli_real_escape_string($this->db->link, $data['quantity']);

        //// Kiem tra hình ảnh và lấy hình ảnh cho vào folder upload
        // $permited  = array('jpg', 'jpeg', 'png', 'gif');

        // $file_name = $_FILES['image']['name'];
        // $file_size = $_FILES['image']['size'];
        // $file_temp = $_FILES['image']['tmp_name'];

        // $div = explode('.', $file_name);
        // $file_ext = strtolower(end($div));
        // // $file_current = strtolower(current($div));
        // $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        // $uploaded_image = "uploads/" . $unique_image;

        // if ($productName == "" || $brand == "" || $category == "" || $product_desc == "" || $price == "" || $type == "") {
        //     $alert = "<span class='error'>Fields must be not empty</span>";
        //     return $alert;
        // } else {
        //     if (!empty($file_name)) {
        //         //Nếu người dùng chọn ảnh
        //         if ($file_size > 20480) {

        //             $alert = "<span class='success'>Image Size should be less then 2MB!</span>";
        //             return $alert;
        //         } elseif (in_array($file_ext, $permited) === false) {
        //             // echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";	
        //             $alert = "<span class='success'>You can upload only:-" . implode(', ', $permited) . "</span>";
        //             return $alert;
        //         }
        //         move_uploaded_file($file_temp, $uploaded_image);
        $query = "";
        if ($unique_image != "") {
            $query = "UPDATE tbl_product SET
					productName = '$productName',
					brandId = '$brand',
					catId = '$category', 
					price = '$price', 
					image = '$unique_image',
					product_desc = '$product_desc',
                    quantity = '$quantity'
					WHERE productId = '$id'";
        } else {
            //Nếu người dùng không chọn ảnh
            $query = "UPDATE tbl_product SET
					productName = '$productName',
					brandId = '$brand',
					catId = '$category', 
					price = '$price', 		
					product_desc = '$product_desc',
                    quantity = '$quantity'
					WHERE productId = '$id'";
        }
        $result = $this->db->update($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function update_type_slider($id, $type)
    {
        $type = mysqli_real_escape_string($this->db->link, $type);
        $query = "UPDATE tbl_slider SET type = '$type' WHERE sliderId = '$id'";
        $result = $this->db->update($query);
        return $result;
    }
    public function del_product($id)
    {
        $query = "DELETE FROM tbl_product WHERE productId = '$id'";
        $result = $this->db->delete($query);
        if ($result) {
            $alert = "<span class='success'>Xóa Sản Phẩm Thành Công</span>";
            return $alert;
        } else {
            $alert = "<span class = 'error'>Xóa Sản Phẩm Thất Bại</span>";
            return $alert;
        }
    }

    public function del_slider($id)
    {
        $query = "DELETE FROM tbl_slider WHERE sliderId = '$id'";
        $result = $this->db->delete($query);
        if ($result) {
            $alert = "<span class='success'>Xóa Slider Thành Công</span>";
            return $alert;
        } else {
            $alert = "<span class = 'error'>Xóa Slider Thất Bại</span>";
            return $alert;
        }
    }

    public function del_wishlist($proid, $customer_id)
    {
        $query = "DELETE FROM tbl_wishlist WHERE productId = '$proid' and customer_id = '$customer_id'";
        $result = $this->db->delete($query);
        return $result;
    }

    private function getProductFromOrder($from)
    {
        $query = "SELECT pr.*
        FROM tbl_product pr 
        INNER JOIN tbl_orderdetail ot ON ot.productId = pr.productId 
        INNER JOIN tbl_order od ON od.orderId = ot.orderId 
        WHERE (od.date_order BETWEEN '$from 00:00:00' AND NOW()) 
        AND (od.status != 3)";
        return $this->db->select($query);
    }

    private function getFeatheredList($from)
    {
        $orderList = $this->getProductFromOrder($from);
        $productList = array();
        $exist = false;
        while ($data = $orderList->fetch_assoc()) {
            foreach ($productList as $key => $row) {
                if ($data["productId"] == $row["productId"]) {
                    $productList[$key]["times"]++;
                    $exist = true;
                    break;
                }
            }
            if (!$exist) {
                $data["times"] = 1;
                array_push($productList, $data);
            }
            $exist = false;
        }
        return $productList;
    }

    public function getproduct_feathered()
    {
        $now = date("Y-m-d");
        $productList = null;
        $i = 0;
        do {
            $i++;
            $number = $i * 30;
            $from = date('Y-m-d', strtotime($now . " - {$number} days"));
            $productList = $this->getFeatheredList($from);
        } while (count($productList) < 4);

        $timesArr = array_column($productList, "times");
        array_multisort($timesArr, SORT_DESC, $productList);

        $result = array();
        for ($i = 0; $i < 4; $i++) {
            array_push($result, $productList[$i]);
        }
        return $result;
    }

    public function getproduct_new()
    {
        $sp_tungtrang = 4;
        if (!isset($_GET['trang'])) {
            $trang = 1;
        } else {
            $trang = $_GET['trang'];
        }
        $tung_trang = ($trang - 1) * $sp_tungtrang;
        $query = "SELECT * FROM tbl_product order by productId  desc LIMIT $tung_trang,$sp_tungtrang";
        $result = $this->db->select($query);
        return $result;
    }
    public function get_all_product()
    {
        $query = "SELECT * FROM tbl_product";
        $result = $this->db->select($query);
        return $result;
    }

    public function get_details($id)
    {
        $query = "SELECT tbl_product.*,tbl_category.catName, tbl_brand.brandName
            --
            from  tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
            INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId where tbl_product.productId = '$id'";
        $result = $this->db->select($query);
        return $result;
    }
    public function getLastestXiaomi()
    {
        $query = "SELECT * FROM tbl_product WHERE brandId = '18' order by productId desc LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }
    public function getLastestOppo()
    {
        $query = "SELECT * FROM tbl_product WHERE brandId = '17' order by productId desc LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }
    public function getLastestSamSung()
    {
        $query = "SELECT * FROM tbl_product WHERE brandId = '8' order by productId desc LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }
    public function getLastestIPhone()
    {
        $query = "SELECT * FROM tbl_product WHERE brandId = '9' order by productId desc LIMIT 1";
        $result = $this->db->select($query);
        return $result;
    }
    public function get_wishlist($customer_id)
    {
        $query = "SELECT * FROM tbl_wishlist WHERE customer_id = '$customer_id' order by id desc";
        $result = $this->db->select($query);
        return $result;
    }
    public function insertWishlist($productId, $customer_id)
    {
        $quantity = mysqli_real_escape_string($this->db->link, $productId);
        $customer_id = mysqli_real_escape_string($this->db->link, $customer_id);
        $check_wlist = "SELECT * FROM tbl_wishlist WHERE productId = '$productId' AND customer_id = '$customer_id'";
        $result_check_wlist = $this->db->select($check_wlist); //thực thi câu lệnh
        if (!$result_check_wlist) {
            $query = "SELECT * FROM tbl_product WHERE productId = '$productId'"; //câu lệnh
            $result = $this->db->select($query)->fetch_assoc(); //truy vấn , trả về mảng được lập chỉ mục chuỗi

            $image = $result["image"];
            $price = $result["price"];
            $productName = $result["productName"];
            $query_insert = "INSERT INTO tbl_wishlist(productId,price,image,customer_id,productName) VALUES('$productId','$price','$image','$customer_id','$productName')";
            $insert_wlist = $this->db->insert($query_insert);
            if ($insert_wlist) {
                $alert = "<span class='success'>Thêm Vào Danh Sách Yêu Thích Thành Công</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Thêm Vào Danh Sách Yêu Thích Thất Bại</span>";
                return $alert;
            }
        } else {
            $msg = "<span class='error'>Đã Thêm Vào Danh Sách Yêu Thích Rồi</span>";
            return $msg;
        }
    }

    public function showProductLowQuanity($number)
    {
        $query = "SELECT pr.*, cat.catName, br.brandName
        from  tbl_product pr INNER JOIN tbl_category cat ON pr.catId = cat.catId
        INNER JOIN tbl_brand br ON pr.brandId = br.brandId 
        WHERE pr.quantity <= '$number'
        order by pr.productId desc";
        $result = $this->db->select($query);
        return $result;
    }

    public function updateQuantity($id, $quantity)
    {
        $query = "UPDATE tbl_product SET quantity = '$quantity' WHERE productId = '$id'";
        return $this->db->update($query);
    }

    public function checkQuantity($id)
    {
        //Kiem tra so luong
        $query = "SELECT quantity From tbl_product where productId = '$id'";
        return $this->db->select($query)->fetch_assoc()["quantity"];
        // Dùng lênh select lấy ra số lượng trong bảng product
    }

    public function checked_quantity($id, $ordered_quantity)
    {
        //giam so luong sau khi khach hang mua
        $current_Quantity = $this->checkQuantity($id); // so luong hien tai
        $newQuantity = $current_Quantity - $ordered_quantity; //so luong moi bang so luong hien tai tru di so luong da dat
        $this->updateQuantity($id, $newQuantity); // goi lai so luong
    }
}

?>    