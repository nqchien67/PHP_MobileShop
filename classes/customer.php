<?php
ob_start();
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/dbhelper.php');
?>
<?php
class customer
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
        $tenbinhluan = $_POST['tennguoibinhluan'];
        $binhluan = $_POST['binhluan'];
        if ($tenbinhluan == '' || $binhluan == '') {
            $alert = "<span class='error'>Không Được Để Trống</span>";
            return $alert;
        } else {
            $query = "INSERT INTO tbl_binhluan(tenbinhluan,binhluan,product_id) VALUES ('$tenbinhluan', '$binhluan', '$product_id')";
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

    public function insert_customers($data)
    {
        $name = mysqli_real_escape_string($this->db->link, $data['name']);
        // $city = mysqli_real_escape_string($this->db->link,$data['city']);
        // $zipcode = mysqli_real_escape_string($this->db->link,$data['zipcode']);
        $email = mysqli_real_escape_string($this->db->link, $data['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "<span class = 'error'>Định dạng Email bị lỗi</span>";
                return $emailErr;
            }
        $address = mysqli_real_escape_string($this->db->link, $data['address']);
        // $country = mysqli_real_escape_string($this->db->link,$data['country']);
        $phone = mysqli_real_escape_string($this->db->link, $data['phone']);
        $password = mysqli_real_escape_string($this->db->link, md5($data['password']));

        if ($name == "" || $email == "" || $address == "" || $phone == "" || $password == "") {
            $alert = "<span class='error'>Fields must be not empty</span>";
            return $alert;
        } else {
            $check_email = "SELECT * FROM tbl_customer WHERE email = '$email' LIMIT 1";
            $result_check = $this->db->select($check_email);
            $check_phone = "SELECT * FROM tbl_customer WHERE phone = '$phone' LIMIT 1";

            if ($result_check) {
                $alert = "<span class = 'error'> Email đã tồn tại</span>";
                return $alert;
            } else {
                $query = "INSERT INTO tbl_customer(name,email,address,phone,password) VALUES ('$name', '$email', '$address', '$phone','$password')";
                $result = $this->db->insert($query);
                if ($result) {
                    $alert = "<span class='success'> Tạo Tài Khoản Thành Công</span>";
                    return $alert;
                } else {
                    $alert = "<span class='error'> Tạo Tài Khoản Thất Bại</span>";
                    return $alert;
                }
            }
        }
    }
    public function login_customers($data)
    {
        $email = mysqli_real_escape_string($this->db->link, $data['email']);
        $password = mysqli_real_escape_string($this->db->link, md5($data['password']));
        if ($email == '' || $password == '') {
            $alert = "<span class='error'> Email hoặc mật khẩu không  đúng</span>";
            return $alert;
        } else {
            $check_email = "SELECT * FROM tbl_customer WHERE email = '$email' AND password='$password' LIMIT 1";

            $result_check = $this->db->select($check_email);
            if ($result_check) {
                $value = $result_check->fetch_assoc();
                Session::set('customer_login', true);
                Session::set('customer_Id', $value['id']);
                Session::set('customer_name', $value['name']);
                header('Location:order.php');
            } else {
                $alert = "<span class = 'error'>Email Hoặc Mật Khẩu Không Phù Hợp</span>";
                return $alert;
            }
        }
    }
    public function show_customers($id)
    {
        $query = "SELECT * FROM tbl_customer WHERE id = '$id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function get_customerName($id)
    {
        $query = "SELECT name FROM tbl_customer WHERE id = '$id'";
        $result = $this->db->select($query);
        if ($result != null) {
            return $result->fetch_assoc()["name"];
        } else {
            return "";
        }
    }

    public function show_comment()
    {
        $query = "SELECT * FROM tbl_binhluan order by binhluan_id desc";
        $result = $this->db->select($query);
        return $result;
    }
    public function del_comment($id)
    {
        $query = "DELETE FROM tbl_binhluan where binhluan_id = '$id'";
        $result = $this->db->delete($query);
        if ($result) {
            $alert = "<span class='success'>Xóa bình luận thành công</span>";
            return $alert;
        } else {
            $alert = "<span class='error'>Xóa bình luận không thành công</span>";
            return $alert;
        }
    }
    public function update_customers($data, $id)
    {
        $name = mysqli_real_escape_string($this->db->link, $data['name']);
        $email = mysqli_real_escape_string($this->db->link, $data['email']);
        $address = mysqli_real_escape_string($this->db->link, $data['address']);
        $phone = mysqli_real_escape_string($this->db->link, $data['phone']);
        if ($name == "" || $email == "" || $address == "" || $phone == "") {
            $alert = "<span class='error'>Các Trường Không Được Để Trống</span>";
            return $alert;
        } else {
            $query = "UPDATE tbl_customer SET name='$name',email='$email',address='$address',phone='$phone' WHERE id = '$id'";
            $result = $this->db->insert($query);
            if ($result) {
                $alert = "<span class='success'>Cập Nhật Thông Tin Thành Công</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Cập Nhật Thông Tin Thất Bại</span>";
                return $alert;
            }
        }
    }
}
?>    
